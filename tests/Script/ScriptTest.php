<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Script;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Script\Script;

class ScriptTest extends TestCase
{
    /** @test */
    public function it_builds_the_query_as_array_with_the_source_parameter()
    {
        $script = new Script();
        $script->source('script source');

        $expected = [
            'source' => 'script source',
        ];

        $this->assertSame($expected, $script->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_id_parameter()
    {
        $script = new Script();
        $script->id('my id');

        $expected = [
            'id' => 'my id',
        ];

        $this->assertSame($expected, $script->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_language_parameter()
    {
        $script = new Script();
        $script->source('script source');
        $script->language('painless');

        $expected = [
            'source' => 'script source',
            'lang'   => 'painless',
        ];

        $this->assertSame($expected, $script->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_array_with_the_parameters_parameter()
    {
        $script = new Script();
        $script->source('script source');
        $script->parameters([
            'multiplier' => 2,
        ]);

        $expected = [
            'source'     => 'script source',
                'params' => [
                'multiplier' => 2,
            ],
        ];

        $this->assertSame($expected, $script->toArray());
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_source_parameter()
    {
        $script = new Script();
        $script->source('script source');

        $expected = <<<JSON
{
    "source": "script source"
}
JSON;

        $this->assertSame($expected, $script->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_id_parameter()
    {
        $script = new Script();
        $script->id('my id');

        $expected = <<<JSON
{
    "id": "my id"
}
JSON;

        $this->assertSame($expected, $script->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_language_parameter()
    {
        $script = new Script();
        $script->source('script source');
        $script->language('painless');

        $expected = <<<JSON
{
    "source": "script source",
    "lang": "painless"
}
JSON;

        $this->assertSame($expected, $script->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_builds_the_query_as_json_with_the_parameters_parameter()
    {
        $script = new Script();
        $script->source('script source');
        $script->parameters([
            'multiplier' => 2,
        ]);

        $expected = <<<JSON
{
    "source": "script source",
    "params": {
        "multiplier": 2
    }
}
JSON;

        $this->assertSame($expected, $script->toJson(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function an_exception_will_be_thrown_if_the_source_or_id_are_not_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "source" or "id" is required!');

        $script = new Script();

        $script->toArray();
    }

    /** @test */
    public function an_exception_will_be_thrown_if_both_source_ad_id_are_set_when_building_the_query()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Passing both "source" and "id" at the same time is not allowed.');

        $script = new Script();
        $script->id('my id');
        $script->source('script source');

        $script->toArray();
    }
}
