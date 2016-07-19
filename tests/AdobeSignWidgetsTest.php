<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignWidgetsTest extends BaseTestCase
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

    public function testCreateWidget()
    {
        $res = $this->adobeSign->createWidget([]);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgets()
    {
        $res = $this->adobeSign->getWidgets();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidget()
    {
        $res = $this->adobeSign->getWidget('mock_widget_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgetAuditTrail()
    {
        $res = $this->adobeSign->getWidgetAuditTrail('mock_widget_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgetCombinedDocument()
    {
        $res = $this->adobeSign->getWidgetCombinedDocument('mock_widget_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgetFormData()
    {
        $res = $this->adobeSign->getWidgetFormData('mock_widget_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgetAgreements()
    {
        $res = $this->adobeSign->getWidgetAgreements('mock_widget_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgetDocuments()
    {
        $res = $this->adobeSign->getWidgetDocuments('mock_widget_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWidgetDocument()
    {
        $res = $this->adobeSign->getWidgetDocument('mock_widget_id', 'mock_document_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testPersonalizeWidget()
    {
        $res = $this->adobeSign->personalizeWidget('mock_widget_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testUpdateWidgetStatus()
    {
        $res = $this->adobeSign->updateWidgetStatus('mock_widget_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}