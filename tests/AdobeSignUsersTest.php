<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignUsersTest extends BaseTestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->andReturn(['mock_response' => 'mock_response']);
    }

    public function testCreateUser()
    {
        $res = $this->adobeSign->createUser([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetUsers()
    {
        $res = $this->adobeSign->getUsers();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetUser()
    {
        $res = $this->adobeSign->getUser('mock_user_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testUpdateUser()
    {
        $res = $this->adobeSign->updateUser('mock_user_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testUpdateUserStatus()
    {
        $res = $this->adobeSign->updateUserStatus('mock_user_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}