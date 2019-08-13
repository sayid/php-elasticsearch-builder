<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\PrefixQuery;

class PrefixQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');

        $expectedQuery = [
            'prefix' => [
                'user' => 'ki',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->boost(1.5);

        $expectedQuery = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->name('my-query-name');

        $expectedQuery = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_rewrite_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->rewrite('rewrite');

        $expectedQuery = [
            'prefix' => [
                'user' => [
                    'value'   => 'ki',
                    'rewrite' => 'rewrite',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');

        $expectedQuery = <<<JSON
{
    "prefix": {
        "user": "ki"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "prefix": {
        "user": {
            "value": "ki",
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
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "prefix": {
        "user": {
            "value": "ki",
            "_name": "my-query-name"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_rewrite_parameter()
    {
        $query = new PrefixQuery();
        $query->field('user');
        $query->value('ki');
        $query->rewrite('rewrite');

        $expectedQuery = <<<JSON
{
    "prefix": {
        "user": {
            "value": "ki",
            "rewrite": "rewrite"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function exception_will_be_thrown_if_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new PrefixQuery();
        $query->toArray();
    }

    /** @test */
    public function exception_will_be_thrown_if_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new PrefixQuery();
        $query->field('user');

        $query->toArray();
    }
}
