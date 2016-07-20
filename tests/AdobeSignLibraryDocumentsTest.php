<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignLibraryDocumentsTest extends BaseTestCase
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

    public function testCreateLibraryDocument()
    {
        $res = $this->adobeSign->createLibraryDocument([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetLibraryDocuments()
    {
        $res = $this->adobeSign->getLibraryDocuments();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetLibraryDocument()
    {
        $res = $this->adobeSign->getLibraryDocument('mock_library_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetLibraryDocumentAuditTrail()
    {
        $res = $this->adobeSign->getLibraryDocumentAuditTrail('mock_library_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetLibraryDocumentCombinedDocument()
    {
        $res = $this->adobeSign->getLibraryDocumentCombinedDocument('mock_library_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetLibraryDocumentDocuments()
    {
        $res = $this->adobeSign->getLibraryDocumentDocuments('mock_library_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetLibraryDocumentDocument()
    {
        $res = $this->adobeSign->getLibraryDocumentDocument('mock_library_document_id', 'mock_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testDeleteLibraryDocument()
    {
        $res = $this->adobeSign->deleteLibraryDocument('mock_library_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}