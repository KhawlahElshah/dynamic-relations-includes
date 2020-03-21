<?php

namespace Kalshah\DynamicRelationsInclude\Tests;

use Illuminate\Support\Facades\App;
use Kalshah\DynamicRelationsInclude\Tests\classes\TestModel;
use Kalshah\DynamicRelationsInclude\DynamicRelationsIncludeRequest;
use Kalshah\DynamicRelationsInclude\Exceptions\LoadablesAreNotDefinedException;

class IncludeRelationsTest extends TestCase
{
    /**
     *@test
     */
    function it_knows_it_relation_exsits_on_the_model()
    {
        $model = new TestModel;

        $this->assertTrue($model->checkExactRelationExists('relatedModel'));
        $this->assertFalse($model->checkExactRelationExists('anotherRelatedModel'));
    }

    /**
     *@test
     */
    function it_converts_relation_to_camel_case_and_check_if_it_exsits()
    {
        $model = new TestModel;

        $this->assertTrue($model->checkCamelCaseRelationExists('related_model'));
        $this->assertFalse($model->checkCamelCaseRelationExists('another_related_model'));
    }

    /**
     *@test
     @TODO:: enable this
     */
    // public function it_checks_for_sub_relations()
    // {
    //     $model = new TestModel;
    //     $model->setLoadableRelations(['relatedModel.subRelatedModel']);

    //     $this->assertTrue($model->checkSubRelationExists('relatedModel.subRelatedModel'));
    //     $this->assertFalse($model->checkSubRelationExists('relatedModel.anotherSubRelatedModel'));
    // }

    /**
     *@test
     */
    public function it_will_load_the_relation_if_it_is_loadable()
    {
        $model = new TestModel;
        $model->setLoadableRelations(['relatedModel']);

        $model->loadIfLoadableRelation('relatedModel');

        $this->assertEquals(['relatedModel'], $model->getWithArray());
    }

    /**
     *@test
     */
    public function it_will_not_load_the_relation_if_it_is_not_loadable()
    {
        $model = new TestModel;
        $model->setLoadableRelations(['relatedModel']);

        $model->loadIfLoadableRelation('anotheRelatedModel');

        $this->assertEquals([], $model->getWithArray());
    }

    /**
     *@test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function it_throws_an_exception_if_attempting_to_include_relations_without_setting_the_loadables_relations_array()
    {
        $mock = $this->mock("alias:" . DynamicRelationsIncludeRequest::class);

        $mock->shouldReceive('requestHasIncludeParameter')
            ->once()
            ->andReturn(true);

        $this->app->instance(DynamicRelationsIncludeRequest::class, $mock);

        $this->expectException(LoadablesAreNotDefinedException::class);

        $model = new TestModel();
    }
}