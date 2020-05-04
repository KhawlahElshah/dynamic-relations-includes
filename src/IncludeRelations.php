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

            $this->loadIncludedRelations();
        }

        if (DynamicRelationsIncludeRequest::requestHasIncludeCountParameter()) {

            $this->checkLoadableRelationsCountArrayIsDefined();

            $this->loadIncludedRelationsCount();
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

    public function loadIncludedRelations()
    {
        $includedRelations = DynamicRelationsIncludeRequest::getRequestIncludeParameter();

        if (is_array($includedRelations) && count($includedRelations) == 1 && $includedRelations[0] == 'all') {
            $this->loadAllRelations();
            return;
        }

        if (is_array($includedRelations)) {
            array_map(function ($relation) {
                if ($this->loadIfLoadableRelation($relation)) {
                    return;
                }

                if ($this->loadIfLoadableRelation(Str::camel($relation))) {
                    return;
                }
            }, $includedRelations);
        }
    }

    public function loadIncludedRelationsCount()
    {
        $includedRelationsCount = DynamicRelationsIncludeRequest::getRequestIncludeCountParameter();

        if (is_array($includedRelationsCount)) {
            array_map(function ($relation) {
                if ($this->loadIfLoadableRelationCount($relation)) {
                    return;
                }

                if ($this->loadIfLoadableRelationCount(Str::camel($relation))) {
                    return;
                }
            }, $includedRelationsCount);
        }
    }

    public function loadAllRelations()
    {
        if (is_array($this->loadableRelations)) {
            foreach ($this->loadableRelations as $relation) {
                $this->with[] = $relation;
            }
        }

        return true;
    }

    public function loadIfLoadableRelation($relation)
    {
        if (in_array($relation, $this->loadableRelations)) {
            $this->with[] = $relation;
            return true;
        }

        return false;
    }

    public function loadIfLoadableRelationCount($relationCount)
    {
        if (in_array($relationCount, $this->loadableRelationsCount)) {
            $this->withCount[] = $relationCount;
            return true;
        }
        return false;
    }
}
