<?php


namespace KevinEm\AdobeSign;

use GuzzleHttp\Psr7\MultipartStream;
use KevinEm\AdobeSign\Exceptions\AdobeSignException;
use KevinEm\AdobeSign\Exceptions\AdobeSignInvalidAccessTokenException;
use KevinEm\AdobeSign\Exceptions\AdobeSignMissingRequiredParamException;
use KevinEm\AdobeSign\Exceptions\AdobeSignUnsupportedMediaTypeException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Tool\QueryBuilderTrait;

/**
 * Class AdobeSign
 * @package KevinEm\AdobeSign
 */
class AdobeSign
{
    use QueryBuilderTrait;

    /**
     * @var string
     */
    protected $baseUri = 'https://api.na1.echosign.com/api/rest';

    /**
     * @var string
     */
    protected $version = 'v5';

    /**
     * @var \KevinEm\OAuth2\Client\AdobeSign
     */
    protected $provider;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * AdobeSign constructor.
     * @param AbstractProvider $provider
     */
    public function __construct(AbstractProvider $provider)
    {
        $this->provider = $provider;
    }

    public function getAuthorizationUrl()
    {
        return $this->provider->getAuthorizationUrl();
    }

    public function getAccessToken($code)
    {
        return $this->provider->getAccessToken('authorization_code', compact('code'));
    }

    public function refreshAccessToken($refreshToken)
    {
        return $this->provider->getAccessToken('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    protected function parseResponse($res)
    {
        if (isset($res['code'])) {
            if ($res['code'] == 'INVALID_ACCESS_TOKEN') {
                throw new AdobeSignInvalidAccessTokenException($res['code'] . ': ' . $res['message']);
            } elseif ($res['code'] == 'UNSUPPORTED_MEDIA_TYPE') {
                throw new AdobeSignUnsupportedMediaTypeException($res['code'] . ': ' . $res['message']);
            } elseif ($res['code'] == 'MISSING_REQUIRED_PARAM') {
                throw new AdobeSignMissingRequiredParamException($res['code'] . ': ' . $res['message']);
            } else {
                throw new AdobeSignException($res['code'] . ': ' . $res['message']);
            }
        }

        return $res;
    }

    /*
     * Base Uris
     */

    public function getBaseUris()
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/base_uris",
            $this->accessToken
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * TransientDocuments
     */

    public function uploadTransientDocument(MultipartStream $multipartStream, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/transientDocuments",
            $this->accessToken, [
                'headers' => $headers,
                'body'    => $multipartStream
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Agreements
     */

    public function createAgreement(array $agreementCreationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/agreements",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($agreementCreationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function createAlternateParticipant(
        $agreementId,
        $participantSetId,
        $participantId,
        array $alternateParticipantInfo,
        array $headers = []
    ) {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/agreements/$agreementId/participantSets/$participantSetId/participants/$participantId/alternateParticipants",
            $this->accessToken, [
                'headers' => $headers,
                'body'    => $alternateParticipantInfo
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreements(array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreement($agreementId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementAuditTrail($agreementId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/auditTrail",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementSigningUrls($agreementId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/signingUrls",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementFormData($agreementId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/formData",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementCombinedDocument($agreementId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/combinedDocument?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementCombinedDocumentUrls($agreementId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/combinedDocument/url?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementCombinedDocumentPagesInfo($agreementId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/combinedDocument/pagesInfo?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementDocuments($agreementId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/documents?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementDocumentsImageUrls($agreementId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/documents/imageUrls?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementDocument($agreementId, $documentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/documents/$documentId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementDocumentUrl($agreementId, $documentId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/documents/$documentId/url?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementDocumentImageUrls($agreementId, $documentId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/agreements/$agreementId/documents/$documentId/imageUrls?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function updateAgreementStatus($agreementId, array $agreementStatusUpdateInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/agreements/$agreementId/status",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($agreementStatusUpdateInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function deleteAgreement($agreementId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'DELETE',
            "$this->baseUri/$this->version/agreements/$agreementId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function deleteAgreementDocuments($agreementId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'DELETE',
            "$this->baseUri/$this->version/agreements/$agreementId/documents",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Reminders
     */

    public function sendReminder(array $reminderCreationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/reminders",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($reminderCreationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Users
     */

    public function createUser(array $userCreationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/users",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($userCreationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getUsers(array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/users?$query",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getUser($userId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/users/$userId",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function updateUser($userId, array $userModificationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/users/$userId",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($userModificationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function updateUserStatus($userId, array $userStatusUpdateInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/users/$userId/status",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($userStatusUpdateInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Library Documents
     */

    public function createLibraryDocument(array $libraryCreationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/libraryDocuments",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($libraryCreationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getLibraryDocuments(array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/libraryDocuments",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getLibraryDocument($libraryDocumentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/libraryDocuments/$libraryDocumentId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getLibraryDocumentAuditTrail($libraryDocumentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/libraryDocuments/$libraryDocumentId/auditTrail",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getLibraryDocumentCombinedDocument($libraryDocumentId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/libraryDocuments/$libraryDocumentId/combinedDocument?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getLibraryDocumentDocuments($libraryDocumentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/libraryDocuments/$libraryDocumentId/documents",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getLibraryDocumentDocument($libraryDocumentId, $documentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/libraryDocuments/$libraryDocumentId/documents/$documentId",
            $this->accessToken
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function deleteLibraryDocument($libraryDocumentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'DELETE',
            "$this->baseUri/$this->version/libraryDocuments/$libraryDocumentId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Widgets
     */

    public function createWidget(array $widgetCreationRequest, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/widgets",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($widgetCreationRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgets(array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidget($widgetId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgetAuditTrail($widgetId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId/auditTrail",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgetCombinedDocument($widgetId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId/combinedDocument?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgetFormData($widgetId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId/formData",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgetAgreements($widgetId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId/formData",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgetDocuments($widgetId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId/documents?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWidgetDocument($widgetId, $documentId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/widgets/$widgetId/documents/$documentId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function personalizeWidget($widgetId, array $widgetPersonalizationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/widgets/$widgetId/personalize",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($widgetPersonalizationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function updateWidgetStatus($widgetId, array $widgetStatusUpdateInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/widgets/$widgetId/status",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($widgetStatusUpdateInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Views
     */

    public function getAgreementAssetsViewUrl(array $agreementAssetRequest, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/views/agreementAssets",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($agreementAssetRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getAgreementAssetListViewUrl(array $agreementAssetListRequest, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/views/agreementAssetList",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($agreementAssetListRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getSettingsViewUrl(array $targetViewRequest, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/views/settings",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($targetViewRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Search
     */

    public function createSearchForAgreementAssetEvents(array $agreementAssetEventRequest, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/search/agreementAssetEvents",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($agreementAssetEventRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getSearchForAgreementAssetEvents($searchId, array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/search/agreementAssetEvents/$searchId?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Workflows
     */

    public function createWorkflowAgreement(
        $workflowId,
        array $customWorkflowAgreementCreationRequest,
        array $headers = []
    ) {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/workflows/$workflowId/agreements",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($customWorkflowAgreementCreationRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWorkflows(array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/workflows?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getWorkflow($workflowId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/workflows/$workflowId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * Groups
     */

    public function createGroup(array $groupCreationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/groups",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($groupCreationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getGroups(array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/groups",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getGroup($groupId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/groups/$groupId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getGroupUsers($groupId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/groups/$groupId/users",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function updateGroup($groupId, array $groupModificationInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/groups/$groupId",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($groupModificationInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function deleteGroup($groupId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'DELETE',
            "$this->baseUri/$this->version/groups/$groupId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    /*
     * MegaSigns
     */

    public function sendMegaSignAgreement(array $megaSignCreationRequest, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'POST',
            "$this->baseUri/$this->version/megaSigns",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($megaSignCreationRequest)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getMegaSigns(array $query = [], array $headers = [])
    {
        $query = $this->buildQueryString($query);

        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/megaSigns?$query",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getMegaSign($megaSignId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/megaSigns/$megaSignId",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getMegaSignAgreements($megaSignId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/megaSigns/$megaSignId/agreements",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function getMegaSignFormData($megaSignId, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            "$this->baseUri/$this->version/megaSigns/$megaSignId/formData",
            $this->accessToken, [
                'headers' => $headers
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }

    public function updateMegaSignStatus($megaSignId, array $megaSignStatusUpdateInfo, array $headers = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            'PUT',
            "$this->baseUri/$this->version/megaSigns/$megaSignId/status",
            $this->accessToken, [
                'headers' => array_merge([
                    'Content-Type' => 'application/json'
                ], $headers),
                'body'    => json_encode($megaSignStatusUpdateInfo)
            ]
        );

        $res = $this->provider->getResponse($request);

        return $this->parseResponse($res);
    }
}