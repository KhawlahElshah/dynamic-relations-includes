<?php

namespace Kalshah\DynamicRelationsInclude\Tests\classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalshah\DynamicRelationsInclude\IncludeRelations;

class TestModel extends Model
{
    use IncludeRelations;

    protected $guarded = [];

    // protected $loadableRelations = [];

    // protected $loadableRelationsCount = [];

    public function relatedModels(): HasMany
    {
        return $this->hasMany(RelatedModel::class);
    }

    public function relatedModel(): BelongsTo
    {
        return $this->belongsTo(RelatedModel::class);
    }

    public function setLoadableRelations($relations)
    {
        $this->loadableRelations = $relations;
    }

    public function getWithArray()
    {
        return $this->with;
    }

    public function setLoadableRelationsCount($relations)
    {
        $this->loadableRelationsCount = $relations;
    }

    public function getWithCountArray()
    {
        return $this->withCount;
    }
}
