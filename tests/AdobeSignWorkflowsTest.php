<?php


namespace KevinEm\AdobeSign\Tests;


class AdobeSignWorkflowsTest extends BaseTestCase
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

    public function testCreateWordflowAgreement()
    {
        $res = $this->adobeSign->createWorkflowAgreement('mock_workflow_id', []);
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWorkflows()
    {
        $res = $this->adobeSign->getWorkflows();
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }

    public function testGetWorkflow()
    {
        $res = $this->adobeSign->getWorkflow('mock_workflow_id');
        $this->assertEquals($res, ['mock_response' => 'mock_response']);
    }
}