<?php

namespace App\Constants;

class Services extends \PhalconRest\Constants\Services
{
    const CONFIG = 'config';
    const VIEW = 'view';

    const USER_SERVICE = 'userService';
    const API_SERVICE = 'apiService';
    const QUERY = 'query';
    const PHQL_QUERY_PARSER = 'phqlQueryParser';
    const URL_QUERY_PARSER= 'urlQueryParser';
}