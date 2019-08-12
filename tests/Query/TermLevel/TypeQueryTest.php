<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TypeQuery;

class TypeQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new TypeQuery();
        $query->type('_doc');

        $expectedQuery = [
            'type' => [
                'value' => '_doc',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new TypeQuery();
        $query->type('_doc');
        $query->boost(1.5);

        $expectedQuery = [
            'type' => [
                'value' => '_doc',
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new TypeQuery();
        $query->type('_doc');
        $query->name('my-query-name');

        $expectedQuery = [
            'type' => [
                'value' => '_doc',
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }
}
