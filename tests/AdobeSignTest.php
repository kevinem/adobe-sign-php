<?php


namespace KevinEm\AdobeSign\Tests;


use Mockery as m;

class AdobeSignTest extends BaseTestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    public function testGetProviderNotNull()
    {
        $this->assertNotNull($this->adobeSign->getProvider());
    }

    public function testGetAuthorizationUrl()
    {
        $this->provider->shouldReceive('getAuthorizationUrl')->andReturn('mock_authorization_url');
        $url = $this->adobeSign->getAuthorizationUrl();
        $this->assertEquals($url, 'mock_authorization_url');
    }

    public function testGetAccessToken()
    {
        $this->provider->shouldReceive('getAccessToken')->andReturn('mock_access_token');
        $accessToken = $this->adobeSign->getAccessToken('mock_code');
        $this->assertEquals($accessToken, 'mock_access_token');
    }

    public function testAdobeSignInvalidAccessTokenException()
    {
        $this->expectException('KevinEm\AdobeSign\Exceptions\AdobeSignInvalidAccessTokenException');

        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->andReturn([
            'code'    => 'INVALID_ACCESS_TOKEN',
            'message' => 'mock_message'
        ]);
        $this->adobeSign->getBaseUris();
    }

    public function testAdobeSignUnsupportedMediaTypeException()
    {
        $this->expectException('KevinEm\AdobeSign\Exceptions\AdobeSignUnsupportedMediaTypeException');

        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->andReturn([
            'code'    => 'UNSUPPORTED_MEDIA_TYPE',
            'message' => 'mock_message'
        ]);
        $this->adobeSign->getBaseUris();
    }

    public function testAdobeSignMissingRequiredParamException()
    {
        $this->expectException('KevinEm\AdobeSign\Exceptions\AdobeSignMissingRequiredParamException');

        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->andReturn([
            'code'    => 'MISSING_REQUIRED_PARAM',
            'message' => 'mock_message'
        ]);
        $this->adobeSign->getBaseUris();
    }

    public function testAdobeSignException()
    {
        $this->expectException('KevinEm\AdobeSign\Exceptions\AdobeSignException');

        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->andReturn([
            'code'    => 'mock_code',
            'message' => 'mock_message'
        ]);
        $this->adobeSign->getBaseUris();
    }

    public function testGetBaseUris()
    {
        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($this->request);
        $this->provider->shouldReceive('getResponse')->andReturn(['base_uri' => 'response']);
        $res = $this->adobeSign->getBaseUris();
        $this->assertEquals($res, ['base_uri' => 'response']);
    }

    public function testRefreshAccessToken()
    {
        $accessToken = [
            'access_token' => 'mock_access_token'
        ];

        $this->provider->shouldReceive('getAccessToken')->andReturn($accessToken);
        $token = $this->adobeSign->refreshAccessToken('mock_refresh_token');
        $this->assertEquals($token, $accessToken);
    }

    public function testSetAccessToken()
    {
        $this->adobeSign->setAccessToken('mock_access_token');
    }
}