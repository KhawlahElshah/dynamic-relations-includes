<?php

namespace Kalshah\DynamicRelationsInclude\Tests;

use Kalshah\DynamicRelationsInclude\Tests\classes\TestModel;
use Kalshah\DynamicRelationsInclude\DynamicRelationsIncludeRequest;

class IncludeRelationsCountTest extends TestCase
{
    /**
     *@test
     */
    public function it_will_load_the_relation_count_if_it_is_loadable_count()
    {
        $model = new TestModel;
        $model->setLoadableRelationsCount(['relatedModel']);

        $model->loadIfLoadableRelationCount('relatedModel');

        $this->assertEquals(['relatedModel'], $model->getWithCountArray());
    }

    /**
     *@test
     */
    public function it_will_not_load_the_relation_count_if_it_is_not_loadable_count()
    {
        $model = new TestModel;
        $model->setLoadableRelationsCount(['relatedModel']);

        $model->loadIfLoadableRelationCount('anotheRelatedModel');

        $this->assertEquals([], $model->getWithArray());
    }
}