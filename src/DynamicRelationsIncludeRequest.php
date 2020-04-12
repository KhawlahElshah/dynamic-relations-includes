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
        $relations = request('include');

        if (is_string($relations)) {
            $includedRelations = explode(",", $relations);
            return $includedRelations;
        }

        return $relations;
    }

    public static function getRequestIncludeCountParameter()
    {
        $relations = request('include_count');

        if (is_string($relations)) {
            $includedRelations = explode(",", $relations);
            return $includedRelations;
        }

        return $relations;
    }
}
