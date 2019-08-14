<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\Compound\BoostingQuery;

class BoostingQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array_with_the_positive_parameter()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->positive($termQuery);

        $expectedArray = [
            'boosting' => [
                'positive' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_negative_parameter()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->negative($termQuery);

        $expectedArray = [
            'boosting' => [
                'negative' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_positive_and_negative_parameters()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoostingQuery();
        $query->positive($termQuery);
        $query->negative($termQuery);

        $expectedArray = [
            'boosting' => [
                'positive' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
                'negative' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_negative_boost_parameter()
    {
        $query = new BoostingQuery();
        $query->negativeBoost(2);

        $expectedArray = [
            'boosting' => [
                'negative_boost' => 2,
            ],
        ];

        $this->assertSame($expectedArray, $query->toArray());
    }
}
