<?php

namespace App\Tests\Controller;

use App\Tests\Fixtures\DataFixtureTestCase;

/**
 * Class MembershipsControllerTest
 * @package App\Tests\Controller
 */
class MembershipsControllerTest extends DataFixtureTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetMembershipsForUnAuthorizedUser()
    {
        $response = $this->request('/api/memberships', 'GET');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetMembershipsForAuthorizedUserWithUserRole()
    {
        $response = $this->request('/api/memberships', 'GET', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN']);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testGetMembershipsForAuthorizedUserWithRoleAdmin()
    {
        $response = $this->request('/api/memberships', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetMembershipsForAuthorizedUserWithRoleAdminWithGroupIdNotFound()
    {
        $response = $this->request('/api/memberships?group_id=4', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testGetMembershipsForAuthorizedUserWithRoleAdminWithUserIdNotFound()
    {
        $response = $this->request('/api/memberships?user_id=4', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testGetMembershipsResponseBody()
    {
        $response = $this->request('/api/memberships', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1, count($this->responseBody()));
        $this->assertArrayHasKey('id', $this->responseBody()[0]);
        $this->assertArrayHasKey('user_id', $this->responseBody()[0]);
        $this->assertArrayHasKey('group_id', $this->responseBody()[0]);
        $this->assertArrayHasKey('created_at', $this->responseBody()[0]);
    }

    public function testCreateMembershipSuccessfully()
    {
        $params = json_encode(['user_id' => 1, 'group_id' => 2]);
        $response = $this->request('/api/memberships', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN'], $params);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('id', $this->responseBody());
        $this->assertArrayHasKey('user_id', $this->responseBody());
        $this->assertArrayHasKey('group_id', $this->responseBody());
        $this->assertArrayHasKey('created_at', $this->responseBody());
    }

    public function testCreateMembershipAlreadyCreated()
    {
        $params = json_encode(['user_id' => 1, 'group_id' => 1]);
        $response = $this->request('/api/memberships', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN'], $params);
        $this->assertEquals(208, $response->getStatusCode());
    }
}