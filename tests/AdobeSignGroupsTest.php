<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignGroupsTest extends BaseTestCase
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

    public function testCreateGroup()
    {
        $res = $this->adobeSign->createGroup([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetGroups()
    {
        $res = $this->adobeSign->getGroups();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetGroup()
    {
        $res = $this->adobeSign->getGroup('mock_group_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetGroupUsers()
    {
        $res = $this->adobeSign->getGroupUsers('mock_group_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testUpdateGroup()
    {
        $res = $this->adobeSign->updateGroup('mock_group_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testDeleteGroup()
    {
        $res = $this->adobeSign->deleteGroup('mock_group_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}