<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignRemindersTest extends BaseTestCase
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

    public function testSendReminder()
    {
        $res = $this->adobeSign->sendReminder([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}