<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;

class BoolQueryTest extends TestCase
{
    /** @test */
    public function it_applies_the_filter_clause_to_the_query()
    {
        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoolQuery();
        $query->filter($termQuery);

        $expectedQuery = [
            'bool' => [
                'filter' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_applies_the_must_clause_to_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $query = new BoolQuery();
        $query->must($existsQuery);

        $expectedQuery = [
            'bool' => [
                'must' => [
                    'exists' => [
                        'field' => 'user',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_applies_the_must_not_clause_to_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $query = new BoolQuery();
        $query->mustNot($existsQuery);

        $expectedQuery = [
            'bool' => [
                'must_not' => [
                    'exists' => [
                        'field' => 'user',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_applies_the_should_clause_to_the_query()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $query = new BoolQuery();
        $query->should($existsQuery);

        $expectedQuery = [
            'bool' => [
                'should' => [
                    'exists' => [
                        'field' => 'user',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_can_combine_multiple_clauses_and_applies_them_to_the_query()
    {
        $existsQuery1 = new ExistsQuery();
        $existsQuery1->field('user');

        $existsQuery2 = new ExistsQuery();
        $existsQuery2->field('other_field');

        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $query = new BoolQuery();
        $query->must($termQuery);
        $query->must($existsQuery1);
        $query->mustNot($existsQuery2);

        $expectedQuery = [
            'bool' => [
                'must' => [
                    [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                    [
                        'exists' => [
                            'field' => 'user',
                        ],
                    ],
                ],
                'must_not' => [
                    'exists' => [
                        'field' => 'other_field',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }
}
