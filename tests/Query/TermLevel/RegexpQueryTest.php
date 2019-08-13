<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\RegexpQuery;

class RegexpQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');

        $expectedQuery = [
            'regexp' => [
                'name.first' => 's.*',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->boost(1.5);

        $expectedQuery = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->name('my-query-name');

        $expectedQuery = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_flags_parameter_from_a_string()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->flags('INTERSECTION|COMPLEMENT|EMPTY');

        $expectedQuery = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'flags' => 'INTERSECTION|COMPLEMENT|EMPTY',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_an_array_with_the_flags_parameter_from_an_array()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->flags(['INTERSECTION', 'COMPLEMENT', 'EMPTY']);

        $expectedQuery = [
            'regexp' => [
                'name.first' => [
                    'value' => 's.*',
                    'flags' => 'INTERSECTION|COMPLEMENT|EMPTY',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_max_determinized_states_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->maxDeterminizedStates(5);

        $expectedQuery = [
            'regexp' => [
                'name.first' => [
                    'value'                   => 's.*',
                    'max_determinized_states' => 5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_rewrite_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->rewrite('rewrite');

        $expectedQuery = [
            'regexp' => [
                'name.first' => [
                    'value'   => 's.*',
                    'rewrite' => 'rewrite',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": "s.*"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->boost(1.5);

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": {
            "value": "s.*",
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
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": {
            "value": "s.*",
            "_name": "my-query-name"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_json_as_an_with_the_flags_parameter_from_a_string()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->flags('INTERSECTION|COMPLEMENT|EMPTY');

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": {
            "value": "s.*",
            "flags": "INTERSECTION|COMPLEMENT|EMPTY"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_flags_parameter_from_an_array()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->flags(['INTERSECTION', 'COMPLEMENT', 'EMPTY']);

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": {
            "value": "s.*",
            "flags": "INTERSECTION|COMPLEMENT|EMPTY"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_max_determinized_states_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->maxDeterminizedStates(5);

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": {
            "value": "s.*",
            "max_determinized_states": 5
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_rewrite_parameter()
    {
        $query = new RegexpQuery();
        $query->field('name.first');
        $query->value('s.*');
        $query->rewrite('rewrite');

        $expectedQuery = <<<JSON
{
    "regexp": {
        "name.first": {
            "value": "s.*",
            "rewrite": "rewrite"
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_if_there_are_invalid_flags()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The given flags are invalid: FOO, BAR');

        $query = new RegexpQuery();
        $query->flags(['foo', 'COMPLEMENT', 'bAr']);
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_field_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "field" is required!');

        $query = new RegexpQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_value_is_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new RegexpQuery();
        $query->field('name.first');

        $query->toArray();
    }
}
