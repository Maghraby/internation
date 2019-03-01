<?php

namespace App\Tests\Controller;

use App\Tests\Fixtures\DataFixtureTestCase;

/**
 * Class UsersControllerTest
 * @package App\Tests\Controller
 */
class UsersControllerTest extends DataFixtureTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetUsersForUnAuthorizedUser()
    {
        $response = $this->request('/api/users', 'GET');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetUsersForAuthorizedUserWithUserRole()
    {
        $response = $this->request('/api/users', 'GET', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN']);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testGetUsersForAuthorizedUserWithRoleAdmin()
    {
        $response = $this->request('/api/users', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetUsersResponseBody()
    {
        $response = $this->request('/api/users', 'GET', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(2, count($this->responseBody()));
        $this->assertArrayHasKey('id', $this->responseBody()[0]);
        $this->assertArrayHasKey('name', $this->responseBody()[0]);
        $this->assertArrayHasKey('created_at', $this->responseBody()[0]);
        $this->assertArrayHasKey('memberships_count', $this->responseBody()[0]);
    }

    public function testCreateUserSuccessfully()
    {
        $params = json_encode(['name' => 'IBRAHIM']);
        $response = $this->request('/api/users', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN'], $params);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testCreateUserWithAuthenticationError()
    {
        $response = $this->request('/api/users', 'POST');
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testCreateUserWithAuthorizationError()
    {
        $params = json_encode(['name' => 'IBRAHIM']);
        $response = $this->request('/api/users', 'POST', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN'], $params);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testCreateUserWithValidationError()
    {
        $response = $this->request('/api/users', 'POST', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteUserCanDeleteHimSelf()
    {
        $response = $this->request('/api/users/1', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testDeleteUserSuccessfully()
    {
        $response = $this->request('/api/users/2', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteUserErrorNotFound()
    {
        $response = $this->request('/api/users/100', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'REAL_TOKEN']);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteUserWithAuthorizationError()
    {
        $response = $this->request('/api/users/2', 'DELETE', ['HTTP_X_AUTH_TOKEN' => 'FAKE_TOKEN']);
        $this->assertEquals(403, $response->getStatusCode());
    }
}