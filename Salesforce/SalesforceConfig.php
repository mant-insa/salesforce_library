<?php

namespace Salesforce;

use Utils\API;
use Utils\DebugLog;

class SalesforceConfig
{

    private $accessToken;
    private $refreshToken;

    /**
     * Constructor
     *
     * @param string $myDomain Your org-specific URL WITH "/" on the end
     * @param string $key Your client key
     * @param string $secretKey  Your client secret key
     * @param string $redirectUrl Your client auth url
     */
    public function __construct(
        private string $myDomain,
        private string $key,
        private string $secretKey,
        private string $redirectUrl
    ){} 

    public function getDomain()
    {
        return $this->myDomain;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function getRefreshToken()
    {
        if(is_null($this->refreshToken))
        {
            $tokenData = SalesforceTokenManager::readTokenDataFromFile();
            if(array_key_exists('refresh_token', $tokenData))
            {
                $this->refreshToken = $tokenData['refresh_token'];
                return $this->refreshToken;
            }
            throw new \Exception("Token file \"" . SalesforceTokenManager::getTokenFilePath() . "\" doesn't contain refresh token");
        }
        return $this->refreshToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }
}