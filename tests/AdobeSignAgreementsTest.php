<?php


namespace KevinEm\AdobeSign\Tests;


use Mockery as m;

class AdobeSignAgreementsTest extends BaseTestCase
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

    public function testCreateAgreement()
    {
        $res = $this->adobeSign->createAgreement([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testCreateAlternateParticipant()
    {
        $res = $this->adobeSign->createAlternateParticipant('mock_agreement_id', 'mock_participant_set_id',
            'mock_participant_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreements()
    {
        $res = $this->adobeSign->getAgreements();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreement()
    {
        $res = $this->adobeSign->getAgreement('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementAuditTrail()
    {
        $res = $this->adobeSign->getAgreementAuditTrail('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementSigningUrls()
    {
        $res = $this->adobeSign->getAgreementSigningUrls('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementFormData()
    {
        $res = $this->adobeSign->getAgreementFormData('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementCombinedDocument()
    {
        $res = $this->adobeSign->getAgreementCombinedDocument('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementCombinedDocumentUrls()
    {
        $res = $this->adobeSign->getAgreementCombinedDocumentUrls('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementCombinedDocumentPagesInfo()
    {
        $res = $this->adobeSign->getAgreementCombinedDocumentPagesInfo('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementDocuments()
    {
        $res = $this->adobeSign->getAgreementDocuments('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementDocumentsImageUrls()
    {
        $res = $this->adobeSign->getAgreementDocumentsImageUrls('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementDocument()
    {
        $res = $this->adobeSign->getAgreementDocument('mock_agreement_id', 'mock_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementDocumentUrl()
    {
        $res = $this->adobeSign->getAgreementDocumentUrl('mock_agreement_id', 'mock_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetAgreementDocumentImageUrls()
    {
        $res = $this->adobeSign->getAgreementDocumentImageUrls('mock_agreement_id', 'mock_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testUpdateAgreementStatus()
    {
        $res = $this->adobeSign->updateAgreementStatus('mock_agreement_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testDeleteAgreement()
    {
        $res = $this->adobeSign->deleteAgreement('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testDeleteAgreementDocuments()
    {
        $res = $this->adobeSign->deleteAgreementDocuments('mock_agreement_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}