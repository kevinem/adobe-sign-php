<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignMegaSignsTest extends BaseTestCase
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

    public function testSendMegaSignAgreement()
    {
        $res = $this->adobeSign->sendMegaSignAgreement([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetMegaSigns()
    {
        $res = $this->adobeSign->getMegaSigns();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetMegaSign()
    {
        $res = $this->adobeSign->getMegaSign('mock_mega_sign_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetMegaSignAgreements()
    {
        $res = $this->adobeSign->getMegaSignAgreements('mock_mega_sign_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetMegaSignFormData()
    {
        $res = $this->adobeSign->getMegaSignFormData('mock_mega_sign_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testUpdateMegaSignStatus()
    {
        $res = $this->adobeSign->updateMegaSignStatus('mock_mega_sign_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}