# Adobe Sign PHP

https://acrobat.adobe.com/us/en/sign.html

This package provides Adobe Sign OAuth 2.0 support for The PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

[![Latest Stable Version](https://poser.pugx.org/kevinem/oauth2-adobesign/v/stable?format=flat-square)](https://packagist.org/packages/kevinem/oauth2-adobesign)
[![License](https://poser.pugx.org/kevinem/oauth2-adobesign/license?format=flat-square)](https://packagist.org/packages/kevinem/oauth2-adobesign)

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
