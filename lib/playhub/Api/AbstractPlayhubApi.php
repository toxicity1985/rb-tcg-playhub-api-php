<?php

namespace Playhub\Api;

use Playhub\HttpClient\PlayhubClient;
use Playhub\Service\PlayhubApiService;

abstract class AbstractPlayhubApi
{
    private static ?PlayhubApiService $_instance = null;

    static function build(): PlayhubApiService
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PlayhubApiService(new PlayhubClient());
        }

        return self::$_instance;
    }
}
