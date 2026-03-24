<?php

if (!function_exists('apiResponse')) {
    function apiResponse()
    {
        return app()->make('apiResponse');
    }
}
