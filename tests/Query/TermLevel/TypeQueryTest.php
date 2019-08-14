<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TypeQuery;

class TypeQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query()
    {
        $query = new TypeQuery();
        $query->type('_doc');

        $expectedArray = [
            'type' => [
                'value' => '_doc',
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_with_the_boost_factor_parameter()
    {
        $query = new TypeQuery();
        $query->type('_doc');
        $query->boost(1.5);

        $expectedArray = [
            'type' => [
                'value' => '_doc',
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_with_the_name_parameter()
    {
        $query = new TypeQuery();
        $query->type('_doc');
        $query->name('my-query-name');

        $expectedArray = [
            'type' => [
                'value' => '_doc',
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }
}
