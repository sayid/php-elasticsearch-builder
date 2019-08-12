<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\RangeQuery;

class RangeQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->boost(1.5);

        $expectedQuery = [
            'range' => [
                'user' => [
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->name('my-query-name');

        $expectedQuery = [
            'range' => [
                'user' => [
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_less_than_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->lessThan(10);

        $expectedQuery = [
            'range' => [
                'user' => [
                    'lt' => 10,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_less_than_or_equal_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->lessThanEquals(10);

        $expectedQuery = [
            'range' => [
                'user' => [
                    'lte' => 10,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_greater_than_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->greaterThan(12);

        $expectedQuery = [
            'range' => [
                'user' => [
                    'gt' => 12,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_greater_than_or_equal_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->greaterThanEquals(12);

        $expectedQuery = [
            'range' => [
                'user' => [
                    'gte' => 12,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_format_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->format('yyyy-MM-dd');

        $expectedQuery = [
            'range' => [
                'user' => [
                    'format' => 'yyyy-MM-dd',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_relation_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->relation('INTERSECTS');

        $expectedQuery = [
            'range' => [
                'user' => [
                    'relation' => 'INTERSECTS',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_timezone_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->timezone('+01:00');

        $expectedQuery = [
            'range' => [
                'user' => [
                    'time_zone' => '+01:00',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
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
        $query = new RangeQuery();
        $query->field('user');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "_name": "my-query-name"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_less_than_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->lessThan(10);

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "lt": 10
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_less_than_or_equal_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->lessThanEquals(10);

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "lte": 10
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_greater_than_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->greaterThan(12);

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "gt": 12
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_greater_than_or_equal_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->greaterThanEquals(12);

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "gte": 12
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_format_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->format('yyyy-MM-dd');

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "format": "yyyy-MM-dd"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_relation_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->relation('INTERSECTS');

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "relation": "INTERSECTS"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_timezone_parameter()
    {
        $query = new RangeQuery();
        $query->field('user');
        $query->timezone('+01:00');

        $expectedQuery = <<<JSON
{
    "range": {
        "user": {
            "time_zone": "+01:00"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_when_setting_an_invalid_relation()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] relation is invalid!');

        $query = new RangeQuery();
        $query->field('user');
        $query->relation('foo');
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new RangeQuery();
        $query->toArray();
    }
}
