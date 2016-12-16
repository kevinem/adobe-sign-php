# Adobe Sign PHP

https://acrobat.adobe.com/us/en/sign.html

[![Latest Stable Version](https://poser.pugx.org/kevinem/adobe-sign-php/v/stable?format=flat-square)](https://packagist.org/packages/kevinem/adobe-sign-php)
[![License](https://poser.pugx.org/kevinem/adobe-sign-php/license?format=flat-square)](https://packagist.org/packages/kevinem/adobe-sign-php)
[![Build Status](https://travis-ci.org/kevinem/adobe-sign-php.svg?branch=master)](https://travis-ci.org/kevinem/adobe-sign-php)

## Installation

To install, use composer:

```
composer require kevinem/adobe-sign-php
```

## Documentation

https://secure.na1.echosign.com/public/docs/restapi/v5

### Example Usage

```php
session_start();

$provider = new KevinEm\OAuth2\Client\AdobeSign([
    'clientId'          => 'your_client_id',
    'clientSecret'      => 'your_client_secret',
    'redirectUri'       => 'your_callback',
    'scope'             => [
          'scope1:type',
          'scope2:type'
    ]
]);

$adobeSign = new AdobeSign($provider);

if (!isset($_GET['code'])) {
    $authorizationUrl = $adobeSign->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authorizationUrl);
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    $accessToken = $adobeSign->getAccessToken($_GET['code']);
    $adobeSign->setAccessToken($accessToken->getToken());
    $adobeSign->createAgreement([
        'documentCreationInfo' => [
            'fileInfos'         => [
                'libraryDocumentId' => 'your_library_document_id'
            ],
            'name'              => 'My Document',
            'signatureType'     => 'ESIGN',
            'recipientSetInfos' => [
                'recipientSetMemberInfos' => [
                    'email' => 'test@gmail.com'
                ],
                'recipientSetRole'        => [
                    'SIGNER'
                ]
            ],
            'mergeFieldInfo'    => [
                [
                    'fieldName'    => 'Name',
                    'defaultValue' => 'John Doe'
                ]
            ],
            'signatureFlow'     => 'SENDER_SIGNATURE_NOT_REQUIRED'
        ]
    ]);
}
```

### Generate Multipart Stream for transient document upload

Thanks to @trip-somers for the [solution](https://github.com/kevinem/adobe-sign-php/issues/1).

```php
$file_path = '/path/to/local/document';

$file_stream = Psr7\FnStream::decorate(Psr7\stream_for(file_get_contents($file_path)), [
    'getMetadata' => function() use ($file_path) {
        return $file_path;
    }
]);

$multipart_stream   = new Psr7\MultipartStream([
    [
        'name'     => 'File',
        'contents' => $file_stream
    ]
]);

$transient_document = $adobeSign->uploadTransientDocument($multipart_stream);
```
## License

The MIT License (MIT)
Copyright (c) 2016 Kevin Em

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of
the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
IN THE SOFTWARE.
