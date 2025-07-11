<?php

namespace Spits\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Nmbrs extends AbstractProvider
{

    public function getBaseAuthorizationUrl()
    {
        return "https://identityservice.nmbrs.com/connect/authorize";
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return "https://identityservice.nmbrs.com/connect/token";
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return "https://developer.nmbrs.com/profile";
    }

    protected function getDefaultScopes()
    {
        return ["offline_access", "employee.employment.read", "employee.info.read", "employee.leave.read"];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            $statusCode = $response->getStatusCode();
            $error = $data['error'];
            $errorDescription = $data['error_description'];
            $errorLink = (isset($data['error_uri']) ? $data['error_uri'] : false);
            throw new IdentityProviderException(
                $statusCode . ' - ' . $errorDescription . ': ' . $error . ($errorLink ? ' (see: ' . $errorLink . ')' : ''),
                $response->getStatusCode(),
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new NmbrsResourceOwner($response);
    }
}