<?php


namespace KevinEm\AdobeSign\Tests;


use Mockery as m;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;

class AdobeSignTransientDocumentsTest extends BaseTestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    public function testUploadTransientDocument()
    {
        $mutipartStream = m::mock('GuzzleHttp\Psr7\MultipartStream');
        $request = m::mock('Psr\Http\Message\RequestInterface');
        $mockFs = vfsStream::setup();
        $mockFile = new vfsStreamFile('filename.png');
        $mockFs->addChild($mockFile);
        $this->provider->shouldReceive('getAuthenticatedRequest')->andReturn($request);
        $this->provider->shouldReceive('getResponse')->andReturn(['id' => 'mock_id']);
        $this->adobeSign->uploadTransientDocument($mutipartStream);
    }
}