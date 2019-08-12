<?php

namespace Hypefactors\ElasticBuilder\Tests\Queries;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\MatchAllQuery;

class MatchAllQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query         = new MatchAllQuery();
        $expectedQuery = [
            'match_all' => [],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new MatchAllQuery();
        $query->boost(1.5);

        $expectedQuery = [
            'match_all' => [
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new MatchAllQuery();
        $query->name('my-query-name');

        $expectedQuery = [
            'match_all' => [
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query         = new MatchAllQuery();
        $expectedQuery = <<<JSON
{
    "match_all": []
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new MatchAllQuery();
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "match_all": {
        "boost": 1.5
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_name_parameter()
    {
        $query = new MatchAllQuery();
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "match_all": {
        "_name": "my-query-name"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }
}
