<?php

namespace Kalshah\DynamicRelationsInclude;

use Illuminate\Support\Str;

trait IncludeRelations
{
    public function initializeIncludeRelations()
    {
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
            $this->loadableRelations = [];
        }
    }

    public function checkLoadableRelationsCountArrayIsDefined()
    {
        if (!$this->loadableRelationsCount) {
            $this->loadableRelationsCount = [];
        }
    }

    public function loadIncludedRelations()
    {
        $includedRelations = DynamicRelationsIncludeRequest::getRequestIncludeParameter();

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
