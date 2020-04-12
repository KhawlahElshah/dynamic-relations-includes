<?php

namespace Kalshah\DynamicRelationsInclude\Tests;

use Kalshah\DynamicRelationsInclude\DynamicRelationsIncludeRequest;

class DynamicRelationsIncludeRequestTest extends TestCase
{
    /**
     *@test
     */
    function it_knows_if_it_has_include_parameter()
    {
        $this->call('get', '/example', [
            'include' => ['related_model']
        ]);

        $this->assertTrue(DynamicRelationsIncludeRequest::requestHasIncludeParameter());
    }

    /**
     *@test
     */
    function it_knows_if_it_has_include_count_parameter()
    {
        $this->call('get', '/example', [
            'include_count' => ['related_model']
        ]);

        $this->assertTrue(DynamicRelationsIncludeRequest::requestHasIncludeCountParameter());
    }

    /**
     *@test
     */
    function it_returns_relations_array_properly_when_sending_include_parameter()
    {
        $this->call('get', '/example', [
            'include' => ['related_model', 'another_related_model']
        ]);

        $this->assertIsArray(DynamicRelationsIncludeRequest::getRequestIncludeParameter());
        $this->assertCount(2, DynamicRelationsIncludeRequest::getRequestIncludeParameter());
    }

    /**
     *@test
     */
    function it_returns_relations_array_properly_when_sending_include_count_parameter()
    {
        $this->call('get', '/example', [
            'include_count' => ['related_model', 'another_related_model']
        ]);

        $this->assertIsArray(DynamicRelationsIncludeRequest::getRequestIncludeCountParameter());
        $this->assertCount(2, DynamicRelationsIncludeRequest::getRequestIncludeCountParameter());
    }

    /**
     *@test
     */
    function it_returns_relations_as_array_if_include_parameter_was_string()
    {
        $this->call('get', '/example', [
            'include' => 'related_model,another_related_model'
        ]);

        $this->assertIsArray(DynamicRelationsIncludeRequest::getRequestIncludeParameter());
        $this->assertCount(2, DynamicRelationsIncludeRequest::getRequestIncludeParameter());
    }

    /**
     *@test
     */
    function it_returns_relations_as_array_if_include_count_parameter_was_string()
    {
        $this->call('get', '/example', [
            'include_count' => 'related_model,another_related_model'
        ]);

        $this->assertIsArray(DynamicRelationsIncludeRequest::getRequestIncludeCountParameter());
        $this->assertCount(2, DynamicRelationsIncludeRequest::getRequestIncludeCountParameter());
    }
}
