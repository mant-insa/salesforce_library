<?php

namespace Salesforce;

use SalesForce;
use Utils\API;
use Utils\DebugLog;

class SalesforceREST
{
    /**
     * Constructor of the class, that interacts with Salesforce REST API
     *
     * @param SalesforceConfig $SFconfig Config class, that contains authentification data
     */
    public function __construct(
        private SalesforceConfig $SFconfig,
        private $ApiVersion = 'v57.0'
    ){}

    /**
     * Executes SOQL request
     *
     * @param string $query
     * @return array Result
     */
    public function executeQuery($query)
    {
        $params = [
            'q' => "$query"
        ];

        $result = API::makeRequest(
            $this->SFconfig->getDomain() . "services/data/$this->ApiVersion/query", 
            $params, 
            "GET", 
            ["Authorization: Bearer " . $this->SFconfig->getAccessToken(), 'Content-type: application/x-www-form-urlencoded']
        );
        return $result;
    }

    /**
     * Retrieves all sObject's fields and metadata
     *
     * @param string $objectApiName
     * @return array Object data
     */
    public function describeObject($objectApiName)
    {
        $objectData = API::makeRequest(
            $this->SFconfig->getDomain() . "services/data/$this->ApiVersion/sobjects/$objectApiName/describe", 
            [], 
            "GET", 
            ["Authorization: Bearer " . $this->SFconfig->getAccessToken(), 'Content-type: application/x-www-form-urlencoded']
        );

        return $objectData;
    }

    public function requestAccessTokenByAuthCode($code)
    {
        $params = array(
            'grant_type'    => "authorization_code",
            'client_id'     => $this->SFconfig->getKey(),
            'client_secret' => $this->SFconfig->getSecretKey(),
            'redirect_uri'  => $this->SFconfig->getRedirectUrl(),
            'code'          => $code,
        );

        $tokensData = API::makeRequest(
            $this->SFconfig->getDomain() . "services/oauth2/token", 
            $params, 
            "POST", 
            ['Content-type: application/x-www-form-urlencoded']
        );

        DebugLog::log($tokensData, 'tokenData', 'tokenDataLog.txt');

        if (array_key_exists('error', $tokensData)) 
        {
            throw new \Exception("Token error:" . PHP_EOL . print_r($tokensData, true));
        }

        return $tokensData;
    }

    public function refreshAccessToken()
    {
        $params = array(
            'grant_type' => "refresh_token",
            'client_id' => $this->SFconfig->getKey(),
            'client_secret' => $this->SFconfig->getSecretKey(),
            'refresh_token' => $this->SFconfig->getRefreshToken(),
        );

        $tokensData = API::makeRequest(
            $this->SFconfig->getDomain() . "services/oauth2/token", 
            $params, 
            "POST", 
            ['Content-type: application/x-www-form-urlencoded']
        );

        return $tokensData;
    }
}