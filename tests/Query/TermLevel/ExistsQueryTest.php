<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;

class ExistsQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new ExistsQuery();
        $query->field('my_field');

        $expectedQuery = [
            'exists' => [
                'field' => 'my_field',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new ExistsQuery();
        $query->field('my_field');
        $query->boost(1.5);

        $expectedQuery = [
            'exists' => [
                'field' => 'my_field',
                'boost' => 1.5,
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new ExistsQuery();
        $query->field('my_field');
        $query->name('my-query-name');

        $expectedQuery = [
            'exists' => [
                'field' => 'my_field',
                '_name' => 'my-query-name',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query = new ExistsQuery();
        $query->field('my_field');

        $expectedQuery = <<<JSON
{
    "exists": {
        "field": "my_field"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new ExistsQuery();
        $query->field('my_field');
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "exists": {
        "field": "my_field",
        "boost": 1.5
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_name_factor_parameter()
    {
        $query = new ExistsQuery();
        $query->field('my_field');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "exists": {
        "field": "my_field",
        "_name": "my-query-name"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new ExistsQuery();

        $query->toArray();
    }
}
