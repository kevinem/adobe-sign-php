<?php


namespace KevinEm\AdobeSign\Tests;


use KevinEm\AdobeSign\AdobeSign;
use Mockery as m;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * @var AdobeSign
     */
    protected $adobeSign;

    /**
     * @var m\MockInterface
     */
    protected $provider;

    /**
     * @var m\MockInterface
     */
    protected $request;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->request = m::mock('Psr\Http\Message\RequestInterface');
        $this->provider = m::mock('KevinEm\OAuth2\Client\AdobeSign');
        $this->adobeSign = new AdobeSign($this->provider);
    }

    public function testSetBaseUri()
    {
        $this->adobeSign->setAccessToken('mock_access_token')->setBaseUri('mock_uri');
        $this->provider->shouldReceive('getAuthenticatedRequest')->with(
            'GET',
            "mock_uri/v5/base_uris",
            'mock_access_token'
        )->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->with($this->request);
        $this->adobeSign->getBaseUris();
    }

    public function testSetVersion()
    {
        $this->adobeSign->setAccessToken('mock_access_token')->setVersion('mock_version');
        $this->provider->shouldReceive('getAuthenticatedRequest')->with(
            'GET',
            "https://api.na1.echosign.com/api/rest/mock_version/base_uris",
            'mock_access_token'
        )->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->with($this->request);
        $this->adobeSign->getBaseUris();
    }
}