<?php

namespace Kalshah\DynamicRelationsInclude\Tests\classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalshah\DynamicRelationsInclude\IncludeRelations;

class RelatedModel extends Model
{
    use IncludeRelations;

    protected $guarded = [];

    public $timestamps = false;

    protected $loadableRelations = ['subRelatedModel'];

    public function testModel(): BelongsTo
    {
        return $this->belongsTo(TestModel::class);
    }

    public function subRelatedModel(): HasMany
    {
        return $this->hasMany(SubRelatedModel::class);
    }
}