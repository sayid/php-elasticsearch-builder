<?php

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\FuzzyQuery;

class FuzzyQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');

        $expectedQuery = [
            'fuzzy' => [
                'user' => 'ki',
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_boost_factor_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->boost(1.0);

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    'boost' => 1.0,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_name_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->name('my-query-name');

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value' => 'ki',
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_fuziness_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->fuzziness(2);

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value'     => 'ki',
                    'fuzziness' => 2,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_max_expansions_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->maxExpansions(100);

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'max_expansions' => 100,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_prefix_length_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->prefixLength(1);

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value'         => 'ki',
                    'prefix_length' => 1,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_transpositions_parameter_to_true()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->transpositions(true);

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'transpositions' => true,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_transpositions_parameter_to_false()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->transpositions(false);

        $expectedQuery = [
            'fuzzy' => [
                'user' => [
                    'value'          => 'ki',
                    'transpositions' => false,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": "ki"
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_boost_factor_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->boost(1.0);

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": {
            "value": "ki",
            "boost": 1
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_name_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->name('my-query-name');

        $expectedQuery = <<<JSON
{
    "fuzzy": {
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
    public function it_builds_the_query_as_json_with_the_fuziness_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->fuzziness(2);

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": {
            "value": "ki",
            "fuzziness": 2
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_max_expansions_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->maxExpansions(100);

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": {
            "value": "ki",
            "max_expansions": 100
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_prefix_length_parameter()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->prefixLength(1);

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": {
            "value": "ki",
            "prefix_length": 1
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_transpositions_parameter_set_to_true()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->transpositions(true);

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": {
            "value": "ki",
            "transpositions": true
        }
    }
}
JSON;

        $this->assertSame($expectedQuery, $query->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_transpositions_parameter_set_to_false()
    {
        $query = new FuzzyQuery();
        $query->field('user');
        $query->value('ki');
        $query->transpositions(false);

        $expectedQuery = <<<JSON
{
    "fuzzy": {
        "user": {
            "value": "ki",
            "transpositions": false
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

        $query = new FuzzyQuery();
        $query->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_parameter_is_not_set_when_building_the_query()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "value" is required!');

        $query = new FuzzyQuery();
        $query->field('user');

        $query->toArray();
    }
}
