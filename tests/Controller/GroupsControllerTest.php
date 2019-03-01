<?php

namespace App\Tests\Controller;

use App\Tests\Fixtures\DataFixtureTestCase;

/**
 * Class GroupsControllerTest
 * @package App\Tests\Controller
 */
class GroupsControllerTest extends DataFixtureTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetGroupsForUnAuthorizedUser()
    {
        $response = $this->request('/api/groups', 'GET');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetGroupsForAuthorizedUserWithUserRole()
    {
        $response = $this->request('/api/groups', 'GET', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN']);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testGetGroupsForAuthorizedUserWithRoleAdmin()
    {
        $response = $this->request('/api/groups', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetGroupsResponseBody()
    {
        $response = $this->request('/api/groups', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(2, count($this->responseBody()));
        $this->assertArrayHasKey('id', $this->responseBody()[0]);
        $this->assertArrayHasKey('name', $this->responseBody()[0]);
        $this->assertArrayHasKey('created_at', $this->responseBody()[0]);
        $this->assertArrayHasKey('memberships_count', $this->responseBody()[0]);
    }

    public function testCreateGroupSuccessfully()
    {
        $params = json_encode(['name' => 'GROUP3']);
        $response = $this->request('/api/groups', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN'], $params);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('id', $this->responseBody());
        $this->assertArrayHasKey('name', $this->responseBody());
        $this->assertArrayHasKey('created_at', $this->responseBody());
        $this->assertArrayHasKey('memberships_count', $this->responseBody());
    }

    public function testCreateGroupWithAuthenticationError()
    {
        $response = $this->request('/api/groups', 'POST');
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testCreateGroupWithAuthorizationError()
    {
        $params = json_encode(['name' => 'GROUP3']);
        $response = $this->request('/api/groups', 'POST', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN'], $params);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testCreateGroupWithValidationError()
    {
        $response = $this->request('/api/groups', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testCreateGroupWithValidationErrorNameUniq()
    {
        $params = json_encode(['name' => 'GROUP1']);
        $response = $this->request('/api/groups', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN'], $params);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteGroupSuccessfully()
    {
        $response = $this->request('/api/groups/2', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteGroupErrorNotFound()
    {
        $response = $this->request('/api/groups/100', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteGroupWithAuthorizationError()
    {
        $response = $this->request('/api/groups/2', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN']);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testDeleteGroupWithGroupHasUsers()
    {
        $response = $this->request('/api/groups/1', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(422, $response->getStatusCode());
    }
}