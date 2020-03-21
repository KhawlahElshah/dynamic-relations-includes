<?php

namespace Kalshah\DynamicRelationsInclude\Tests\classes;

use Illuminate\Database\Eloquent\Model;

class SubRelatedModel extends Model
{
    protected $guarded = [];

    public $timestamps = false;
}