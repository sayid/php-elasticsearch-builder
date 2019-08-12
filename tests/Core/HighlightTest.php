<?php

namespace Hypefactors\ElasticBuilder\Tests\Core;

use stdClass;
use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Core\Highlight;
use Hypefactors\ElasticBuilder\Query\Compound\BoolQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\TermLevel\ExistsQuery;

class HighlightTest extends TestCase
{
    /** @test */
    public function it_can_set_the_boundary_chars_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryChars('.,!?');

        $expected = [
            'boundary_chars' => '.,!?',
            'fields'         => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_boundary_chars_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryChars('.,!?', 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'boundary_chars' => '.,!?',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_boundary_max_scan_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryMaxScan(5);

        $expected = [
            'boundary_max_scan' => 5,
            'fields'            => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_boundary_max_scan_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->boundaryMaxScan(5, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'boundary_max_scan' => 5,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_encoder()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->encoder('html');

        $expected = [
            'encoder' => 'html',
            'fields'  => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_a_single_field()
    {
        $highlight = new Highlight();
        $highlight->field('my-field');

        $expected = [
            'fields' => [
                'my-field' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_multiple_fields()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');

        $expected = [
            'fields' => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_multiple_fields_from_an_array()
    {
        $highlight = new Highlight();
        $highlight->fields([
            'field-a',
            'field-b',
        ]);

        $expected = [
            'fields' => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_force_source_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->forceSource(true);

        $expected = [
            'force_source' => true,
            'fields'       => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_force_source_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->forceSource(true, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'force_source' => true,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_fragmenter_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmenter('simple');

        $expected = [
            'fragmenter' => 'simple',
            'fields'     => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_fragmenter_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmenter('simple', 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'fragmenter' => 'simple',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_fragment_offset_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->fragmentOffset(1);

        $expected = [
            'type'            => 'fvh',
            'fragment_offset' => 1,
            'fields'          => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_fragment_offset_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmentOffset(1, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'type'            => 'fvh',
                    'fragment_offset' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_fragment_size_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->fragmentSize(1);

        $expected = [
            'fragment_size' => 1,
            'fields'        => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_fragment_size_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->fragmentSize(1, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'fragment_size' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_highlight_query_globally()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $boolQuery = new BoolQuery();
        $boolQuery->must($termQuery);
        $boolQuery->should($existsQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('field-a');

        $highlight->highlightQuery($boolQuery);

        $expected = [
            'highlight_query' => [
                'bool' => [
                    'must' => [
                        'term' => [
                            'user' => 'john',
                        ],
                    ],
                    'should' => [
                        'exists' => [
                            'field' => 'user',
                        ],
                    ],
                    'minimum_should_match' => 0,
                ],
            ],
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_highlight_query_on_a_field()
    {
        $existsQuery = new ExistsQuery();
        $existsQuery->field('user');

        $termQuery = new TermQuery();
        $termQuery->field('user');
        $termQuery->value('john');

        $boolQuery = new BoolQuery();
        $boolQuery->must($termQuery);
        $boolQuery->should($existsQuery);
        $boolQuery->minimumShouldMatch(0);

        $highlight = new Highlight();
        $highlight->field('field-a');

        $highlight->highlightQuery($boolQuery, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'highlight_query' => [
                        'bool' => [
                            'must' => [
                                'term' => [
                                    'user' => 'john',
                                ],
                            ],
                            'should' => [
                                'exists' => [
                                    'field' => 'user',
                                ],
                            ],
                            'minimum_should_match' => 0,
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_matched_fields_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->matchedFields(['something'], 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'type'           => 'fvh',
                    'matched_fields' => [
                        'something',
                    ],
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_no_match_size_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->noMatchSize(1, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'no_match_size' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_number_of_fragments_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->numberOfFragments(1);

        $expected = [
            'number_of_fragments' => 1,
            'fields'              => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_number_of_fragments_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->numberOfFragments(1, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'number_of_fragments' => 1,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_score_order_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->scoreOrder();

        $expected = [
            'order'  => 'score',
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_score_order_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->scoreOrder('field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'order' => 'score',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_phrase_limit()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->phraseLimit(10);

        $expected = [
            'phrase_limit' => 10,
            'fields'       => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_pre_tags_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->preTags('<em>');

        $expected = [
            'pre_tags' => [
                '<em>',
            ],
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_pre_tags_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->preTags('<em>', 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'pre_tags' => [
                        '<em>',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_post_tags_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->postTags('</em>');

        $expected = [
            'post_tags' => [
                '</em>',
            ],
            'fields' => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_post_tags_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->postTags('</em>', 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'post_tags' => [
                        '</em>',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_require_field_match_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->requireFieldMatch(true);

        $expected = [
            'require_field_match' => true,
            'fields'              => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_require_field_match_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->requireFieldMatch(true, 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'require_field_match' => true,
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_tags_schema_as_styled()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->tagsSchema();

        $expected = [
            'tags_schema' => 'styled',
            'fields'      => [
                'field-a' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_type_globally()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->type('plain');

        $expected = [
            'type'   => 'plain',
            'fields' => [
                'field-a' => new stdClass(),
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function it_can_set_the_type_on_a_field()
    {
        $highlight = new Highlight();
        $highlight->field('field-a');
        $highlight->field('field-b');
        $highlight->type('plain', 'field-a');

        $expected = [
            'fields' => [
                'field-a' => [
                    'type' => 'plain',
                ],
                'field-b' => new stdClass(),
            ],
        ];

        $this->assertEquals($expected, $highlight->toArray());
    }

    /** @test */
    public function an_exception_will_be_thrown_when_setting_an_invalid_encoder()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] encoder is invalid!');

        $highlight = new Highlight();
        $highlight->encoder('foo');
    }

    /** @test */
    public function an_exception_will_be_thrown_when_setting_an_invalid_type()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] type is invalid!');

        $highlight = new Highlight();
        $highlight->type('foo');
    }

    /** @test */
    public function an_exception_will_be_thrown_when_setting_an_invalid_fragmenter()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] fragmenter is invalid!');

        $highlight = new Highlight();
        $highlight->fragmenter('foo');
    }
}
