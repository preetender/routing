<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Preetender\Routing\Testing\HttpInteraction;

/**
 * Class TestCaseUserController
 * @package Tests
 */
class TestCaseUserController extends TestCase
{
    use HttpInteraction;

    /**
     * @inheritdoc
     */
    public function testListUsers()
    {
        $http = $this->http->get('users');
        $output = $http->getBody()->getContents();
        $this->assertEquals(200, $http->getStatusCode());
        $this->assertEquals('list all users', $output);
    }

    /**
     * @inheritdoc
     */
    public function testUserById()
    {
        $http = $this->http->get('users/1');
        $output = $http->getBody()->getContents();
        $this->assertEquals(200, $http->getStatusCode());
        $this->assertEquals('show user by id 1', $output);
    }

    /**
     * @inheritdoc
     */
    public function testCreateUserView()
    {
       $http = $this->http->get('users/create');
       $output = $http->getBody()->getContents();
       $this->assertEquals(200, $http->getStatusCode());
       $this->assertEquals('view create user', $output);
    }

    /**
     * @inheritdoc
     */
    public function testStoreUser()
    {
        $http = $this->http->post('users', [
            'form_params' => [
                'name' => 'test',
                'email' => 'test@test.com'
            ]
        ]);
        $this->assertEquals(201, $http->getStatusCode());
    }

    /**
     * @inheritdoc
     */
    public function testPatchUserById()
    {
        $http = $this->http->patch('users/edit/1', [
            'form_params' => [
                'name' => 'test'
            ]
        ]);
        $output = $http->getBody()->getContents();
        $this->assertEquals(200, $http->getStatusCode());
        $this->assertEquals('{"body":"update part of user 1","data":{"name":"test"}}', $output);
    }

    /**
     * @inheritdoc
     */
    public function testDeleteUserById()
    {
        $http = $this->http->delete('users/1');
        $output = $http->getBody()->getContents();
        $this->assertEquals(200, $http->getStatusCode());
        $this->assertEquals('delete user by id 1', $output);
    }
}