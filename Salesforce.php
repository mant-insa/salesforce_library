<?php

use Salesforce\SalesforceConfig;
use Salesforce\SalesforceREST;
use Salesforce\SalesforceTokenManager;

class Salesforce
{
    private SalesforceREST $SFrestApi;

    public function __construct(private SalesforceConfig $SFconfig)
    {
        $this->SFrestApi = new SalesforceREST($SFconfig);
    }

    public function getAuthorizationUrl()
    {
        $domain = $this->SFconfig->getDomain();
        $clientId = $this->SFconfig->getKey();
        $redirectUrl = $this->SFconfig->getRedirectUrl();
        $url = "$domain/services/oauth2/authorize?client_id=$clientId&redirect_uri=$redirectUrl&response_type=code";
        return '<a href="' . $url . '">Нажмите здесь, чтобы авторизоваться</a>';
    }

    public function startWebserverAuthFlow($params, $toAuth = false)
    {
        if (isset($params['code'])) 
        {
            $tokensData = $this->SFrestApi->requestAccessTokenByAuthCode($params['code']);
            SalesforceTokenManager::writeTokenDataToFile($tokensData);
            die('Авторизация завершена');
        } 

        if($toAuth)
        {
            $tokensData = $this->SFrestApi->refreshAccessToken();
            SalesforceTokenManager::writeTokenDataToFile($tokensData);
            $this->SFconfig->setAccessToken($tokensData['access_token']);
        }
        else
        {
            die($this->getAuthorizationUrl());
        }
    }
}