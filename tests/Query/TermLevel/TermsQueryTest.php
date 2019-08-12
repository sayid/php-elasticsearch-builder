<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsQuery;

class TermsQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array_for_a_single_value()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->value('john');

        $expectedQuery = [
            'terms' => [
                'user' => ['john'],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_single_value_with_the_boost_factor_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedQuery = [
            'terms' => [
                'user'  => ['john'],
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_single_value_with_name_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedQuery = [
            'terms' => [
                'user'  => ['john'],
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_values()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);

        $expectedQuery = [
            'terms' => [
                'user' => ['john', 'jane'],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_values_with_the_boost_factor_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);
        $query->boost(1.5);

        $expectedQuery = [
            'terms' => [
                'user'  => ['john', 'jane'],
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_values_with_the_name_parameter()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);
        $query->name('my-query-name');

        $expectedQuery = [
            'terms' => [
                'user'  => ['john', 'jane'],
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_values_and_removes_duplicated_values()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->values(['john', 'jane']);
        $query->value('john');

        $expectedQuery = [
            'terms' => [
                'user' => ['john', 'jane'],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_the_given_terms_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->termsLookup([
            'index' => 'my_index',
            'path'  => 'color',
        ]);

        $expectedQuery = [
            'terms' => [
                'user' => [
                    'index' => 'my_index',
                    'path'  => 'color',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_an_index_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->index('my_index');

        $expectedQuery = [
            'terms' => [
                'user' => [
                    'index' => 'my_index',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_an_id_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->id('2');

        $expectedQuery = [
            'terms' => [
                'user' => [
                    'id' => '2',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_path_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->path('color');

        $expectedQuery = [
            'terms' => [
                'user' => [
                    'path' => 'color',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_routing_term_lookup()
    {
        $query = new TermsQuery();
        $query->field('user');
        $query->routing('something');

        $expectedQuery = [
            'terms' => [
                'user' => [
                    'routing' => 'something',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new TermsQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_values_are_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "values" are required!');

        $query = new TermsQuery();
        $query->field('user');

        $query->toArray();
    }
}
