<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;

class TermQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');

        $expectedQuery = [
            'term' => [
                'user' => 'john',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedQuery = [
            'term' => [
                'user' => [
                    'value' => 'john',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedQuery = [
            'term' => [
                'user' => [
                    'value' => 'john',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');

        $expectedQuery = <<<JSON
{
    "term": {
        "user": "john"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "term": {
        "user": {
            "value": "john",
            "boost": 1.5
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_name_parameter()
    {
        $query = new TermQuery();
        $query->field('user');
        $query->value('john');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "term": {
        "user": {
            "value": "john",
            "_name": "my-query-name"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new TermQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new TermQuery();
        $query->field('user');

        $query->toArray();
    }
}
