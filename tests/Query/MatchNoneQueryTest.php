<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Queries;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\MatchNoneQuery;

class MatchNoneQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query         = new MatchNoneQuery();
        $expectedQuery = [
            'match_none' => [],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new MatchNoneQuery();
        $query->boost(1.5);

        $expectedQuery = [
            'match_none' => [
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new MatchNoneQuery();
        $query->name('my-query-name');

        $expectedQuery = [
            'match_none' => [
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query         = new MatchNoneQuery();
        $expectedQuery = <<<JSON
{
    "match_none": []
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new MatchNoneQuery();
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "match_none": {
        "boost": 1.5
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_name_parameter()
    {
        $query = new MatchNoneQuery();
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "match_none": {
        "_name": "my-query-name"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }
}
