<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\FullText\MatchQuery;

class MatchQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');

        $expectedQuery = [
            'match' => [
                'message' => 'this is a test',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query' => 'this is a test',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query' => 'this is a test',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_cut_off_frequency_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->cutOffFrequency(0.001);

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query'            => 'this is a test',
                    'cutoff_frequency' => 0.001,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_fuziness_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->fuzziness(2);

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query'     => 'this is a test',
                    'fuzziness' => 2,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_lenient()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->lenient(true);

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query'   => 'this is a test',
                    'lenient' => true,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_max_expansinons_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->maxExpansions(5);

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query'          => 'this is a test',
                    'max_expansions' => 5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_prefix_length_parameter()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->prefixLength(5);

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query'         => 'this is a test',
                    'prefix_length' => 5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_operator()
    {
        $query = new MatchQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->operator('and');

        $expectedQuery = [
            'match' => [
                'message' => [
                    'query'    => 'this is a test',
                    'operator' => 'and',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function an_exception_will_be_thrown_when_passing_an_invalid_operator()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] operator is invalid.');

        $query = new MatchQuery();
        $query->operator('foo');
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchQuery();
        $query->field('message');

        $query->toArray();
    }
}
