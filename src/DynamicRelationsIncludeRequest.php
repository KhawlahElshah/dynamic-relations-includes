<?php

namespace Kalshah\DynamicRelationsInclude;

use Illuminate\Http\Request;

class DynamicRelationsIncludeRequest extends Request
{
    public static function requestHasIncludeParameter()
    {
        return request()->has('include');
    }

    public static function requestHasIncludeCountParameter()
    {
        return request()->has('include_count');
    }

    public static function getRequestIncludeParameter()
    {
        return request('include');
    }

    public static function getRequestIncludeCountParameter()
    {
        return request('include_count');
    }
}