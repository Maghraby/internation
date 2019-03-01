<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\MembershipService;
use App\Controller\BaseController;
use App\Serializer\MembershipSerializer;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @Route("/api")
 * @return JsonResponse
 */
class MembershipsController extends BaseController
{
    /**
     * @var membershipService
     */
    private $membershipService;

    /**
     * MembershipsController constructor.
     * @param membershipService $membershipService
     */
    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    /**
     * @Route("/memberships", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('per_page', 10);
        $groupId = $request->query->getInt('group_id', null);
        $userId = $request->query->getInt('user_id', null);

        $filters = ['user' => $userId, 'group' => $groupId];

        try {
            $memberships = $this->membershipService->findAll($filters, $page, $perPage);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }

        $serializedMemberships = [];

        if (count($memberships) == 0) {
            return JsonResponse::create([], JsonResponse::HTTP_NO_CONTENT);
        }

        foreach ($memberships as $membership) {
            $membershipSerializer = new MembershipSerializer($membership);
            $serializedMemberships[] = $membershipSerializer->serialize();
        }

        return JsonResponse::create($serializedMemberships, JsonResponse::HTTP_OK);
    }


    /**
     * @Route("/memberships", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $postData = (array)json_decode($request->getContent(), true);
        $request->request->replace($postData);

        $data = $this->membershipData($request);

        try {
            $membership = $this->membershipService->create($data['groupId'], $data['userId']);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }


        $membershipSerializer = new MembershipSerializer($membership);

        return JsonResponse::create($membershipSerializer->serialize(), JsonResponse::HTTP_CREATED);
    }


    /**
     * @Route("/memberships/{id}", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $this->membershipService->delete($id);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }

        return JsonResponse::create([], JsonResponse::HTTP_OK);
    }

    /**
     * @param $request
     * @return array
     */
    private function membershipData($request)
    {
        return [
            'groupId' => $request->request->get('group_id'),
            'userId' => $request->request->get('user_id'),
        ];
    }
}
