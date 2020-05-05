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

    /**
     *@test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function it_throws_an_exception_if_attempting_to_include_relations_count_without_setting_the_loadables_relations_array()
    {
        $mock = $this->mock("alias:" . DynamicRelationsIncludeRequest::class);

        $mock->shouldReceive('requestHasIncludeCountParameter')
            ->once()
            ->andReturn(true)
            ->shouldReceive('requestHasIncludeParameter')
            ->once()
            ->andReturn(false);

        $this->app->instance(DynamicRelationsIncludeRequest::class, $mock);

        // $this->expectException(LoadablesAreNotDefinedException::class);

        $model = new TestModel();
    }
}