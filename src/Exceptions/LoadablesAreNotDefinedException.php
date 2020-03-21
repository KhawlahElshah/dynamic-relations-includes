<?php

namespace Kalshah\DynamicRelationsInclude\Exceptions;

use Exception;

class LoadablesAreNotDefinedException extends Exception
{
    public function __construct()
    {
        parent::__construct("The `loadableRelations` and `loadableRelationsCount` arrays must be set on the model.");
    }
}