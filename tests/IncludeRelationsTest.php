<?php

namespace Kalshah\DynamicRelationsInclude\Tests;

use Kalshah\DynamicRelationsInclude\Tests\classes\TestModel;
use Kalshah\DynamicRelationsInclude\Exceptions\LoadablesAreNotDefinedException;

class IncludeRelationsTest extends TestCase
{
    /**
     *@test
     */
    function it_knows_it_relation_exsits_on_the_model()
    {
        $model = new TestModel;
        $model->setLoadableRelations(['relatedModel']);

        $this->assertTrue($model->loadIfLoadableRelation('relatedModel'));
        $this->assertFalse($model->loadIfLoadableRelation('anotherRelatedModel'));
        $this->assertEquals(['relatedModel'], $model->getWithArray());
    }

    /**
     *@test
     */
    function it_converts_relation_to_camel_case_and_check_if_it_exsits()
    {
        $model = new TestModel;
        $model->setLoadableRelations(['related_model']);

        $this->assertTrue($model->loadIfLoadableRelation('related_model'));
        $this->assertFalse($model->loadIfLoadableRelation('another_related_model'));
        $this->assertEquals(['related_model'], $model->getWithArray());
    }

    /**
     *@test
     @TODO:: enable this
     */
    public function it_checks_for_sub_relations()
    {
        $model = new TestModel;
        $model->setLoadableRelations(['relatedModel.subRelatedModel']);

        $this->assertTrue($model->loadIfLoadableRelation('relatedModel.subRelatedModel'));
        $this->assertFalse($model->loadIfLoadableRelation('relatedModel.anotherSubRelatedModel'));
        $this->assertEquals(['relatedModel.subRelatedModel'], $model->getWithArray());
    }

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
     */
    public function it_throws_an_exception_if_attempting_to_include_relations_without_setting_the_loadables_relations_array()
    {
        $this->call('get', '/example', [
            'include' => ['related_model']
        ]);

        $this->expectException(LoadablesAreNotDefinedException::class);

        $model = new TestModel();
    }
}
