<?php

namespace Salesforce;

use SalesForce;
use Utils\API;
use Utils\DebugLog;

class SalesforceTokenManager
{
    private static $tokenFilePath = __DIR__ . '/token.json';

    public static function readTokenDataFromFile()
    {
        if(file_exists(self::$tokenFilePath))
        {
            $tokenFile = json_decode(file_get_contents(self::$tokenFilePath), true);
            return $tokenFile;
        }

        file_put_contents(self::$tokenFilePath, '{}');
        $tokenFile = json_decode(file_get_contents(self::$tokenFilePath), true);

        return $tokenFile;
    }

    public static function writeTokenDataToFile($tokenData)
    {
        $data = array_merge(self::readTokenDataFromFile(), $tokenData);
        file_put_contents(self::$tokenFilePath, json_encode($data));
        $tokenData = json_decode(file_get_contents(self::$tokenFilePath), true);
        return $tokenData;
    }

    public static function getTokenFilePath()
    {
        return self::$tokenFilePath;
    }
}