<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\FullText;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\FullText\MatchPhraseQuery;

class MatchPhraseQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');

        $expectedQuery = [
            'match_phrase' => [
                'message' => 'this is a test',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->boost(1.5);

        $expectedQuery = [
            'match_phrase' => [
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
        $query = new MatchPhraseQuery();
        $query->field('message');
        $query->query('this is a test');
        $query->name('my-query-name');

        $expectedQuery = [
            'match_phrase' => [
                'message' => [
                    'query' => 'this is a test',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new MatchPhraseQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_query_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "query" is required!');

        $query = new MatchPhraseQuery();
        $query->field('message');

        $query->toArray();
    }
}
