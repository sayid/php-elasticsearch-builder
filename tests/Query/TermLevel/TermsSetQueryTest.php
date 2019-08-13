<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\TermLevel;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermsSetQuery;

class TermsSetQueryTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array_for_a_single_term()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('a-value');

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['a-value'],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_single_term_with_the_boost_factor_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('a-value');
        $query->boost(1.5);

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['a-value'],
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_single_term_with_the_name_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('a-value');
        $query->name('my-query-name');

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['a-value'],
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_single_term_with_the_minimum_should_match_field_1()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('value-a');
        $query->minimumShouldMatchField('required_matches');

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms'                      => ['value-a'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_a_single_term_with_the_minimum_should_match_field_2()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->term('value-a');
        $query->minimumShouldMatchScript([
            'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
        ]);

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms'                       => ['value-a'],
                    'minimum_should_match_script' => [
                        'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_terms()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['value-a', 'value-b'],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_terms_with_the_boost_factor_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->boost(1.5);

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['value-a', 'value-b'],
                    'boost' => 1.5,
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_terms_with_the_name_parameter()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->name('my-query-name');

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms' => ['value-a', 'value-b'],
                    '_name' => 'my-query-name',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_terms_with_the_minimum_should_match_field_1()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->minimumShouldMatchField('required_matches');

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms'                      => ['value-a', 'value-b'],
                    'minimum_should_match_field' => 'required_matches',
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_for_multiple_terms_with_the_minimum_should_match_field_2()
    {
        $query = new TermsSetQuery();
        $query->field('my_field');
        $query->terms(['value-a', 'value-b']);
        $query->minimumShouldMatchScript([
            'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
        ]);

        $expectedQuery = [
            'terms_set' => [
                'my_field' => [
                    'terms'                       => ['value-a', 'value-b'],
                    'minimum_should_match_script' => [
                        'source' => "Math.min(params.num_terms, doc['required_matches'].value)",
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }
}
