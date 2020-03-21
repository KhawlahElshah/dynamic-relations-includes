<?php

namespace Kalshah\DynamicRelationsInclude;

use Illuminate\Support\Str;
use Kalshah\DynamicRelationsInclude\Exceptions\LoadablesAreNotDefinedException;

trait IncludeRelations
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (DynamicRelationsIncludeRequest::requestHasIncludeParameter()) {
            $this->checkLoadableRelationsArrayIsDefined();

            $includedRelations = DynamicRelationsIncludeRequest::getRequestIncludeParameter();

            array_map(function ($relation) {
                if ($this->checkExactRelationExists($relation)) {
                    $this->loadIfLoadableRelation($relation);
                }

                if ($this->checkCamelCaseRelationExists($relation)) {
                    $this->loadIfLoadableRelation(Str::camel($relation));
                }

                if ($this->checkSubRelationExists($relation)) {
                    $this->loadIfLoadableRelation($relation);
                }
            }, $includedRelations);
        }

        if (DynamicRelationsIncludeRequest::requestHasIncludeCountParameter()) {
            $this->checkLoadableRelationsCountArrayIsDefined();

            $includedRelationsCount = DynamicRelationsIncludeRequest::getRequestIncludeCountParameter();

            array_map(function ($relation) {
                if ($this->checkExactRelationExists($relation)) {
                    $this->loadIfLoadableRelationCount($relation);
                }

                if ($this->checkCamelCaseRelationExists($relation)) {
                    $this->loadIfLoadableRelationCount(Str::camel($relation));
                }

                if ($this->checkSubRelationExists($relation)) {
                    $this->loadIfLoadableRelationCount($relation);
                }
            }, $includedRelationsCount);
        }
    }

    public function checkLoadableRelationsArrayIsDefined()
    {
        if (!$this->loadableRelations) {
            throw new LoadablesAreNotDefinedException;
        }
    }

    public function checkLoadableRelationsCountArrayIsDefined()
    {
        if (!$this->loadableRelationsCount) {
            throw new LoadablesAreNotDefinedException;
        }
    }

    public function loadIfLoadableRelation($relation)
    {
        if (in_array($relation, $this->loadableRelations)) {
            $this->with[] = $relation;
        }
    }

    public function loadIfLoadableRelationCount($relationCount)
    {
        if (in_array($relationCount, $this->loadableRelationsCount)) {
            $this->withCount[] = $relationCount;
        }
    }

    public function checkExactRelationExists($relation)
    {
        return !!method_exists($this, $relation);
    }

    public function checkCamelCaseRelationExists($relation)
    {
        return !!method_exists($this, Str::camel($relation));
    }

    public function checkSubRelationExists($relation)
    {
        $relations = explode('.', $relation);

        if (is_array($relations) && count($relations) > 1) {
            if (method_exists($this, $relations[0])) {
                $modelName = ucfirst(Str::singular($relations[0]));

                return !!method_exists("App\\{$modelName}", $relations[1]);
            }
        }
    }
}