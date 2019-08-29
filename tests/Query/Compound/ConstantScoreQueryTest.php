<?php

declare(strict_types=1);

namespace Hypefactors\ElasticBuilder\Tests\Query\Compound;

use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Query\TermLevel\TermQuery;
use Hypefactors\ElasticBuilder\Query\Compound\ConstantScoreQuery;

class ConstantScoreQueryTest extends TestCase
{
    /** @test */
    public function query()
    {
        $termQuery = (new TermQuery())->field('user')->value('john');

        $query = new ConstantScoreQuery();
        $query->filter($termQuery);

        $expectedArray = [
            'constant_score' => [
                'filter' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $expectedJson = <<<JSON
{
    "constant_score": {
        "filter": {
            "term": {
                "user": "john"
            }
        }
    }
}
JSON;

        $this->assertSame($expectedArray, $query->toArray());
        $this->assertSame($expectedJson, $query->toJson(JSON_PRETTY_PRINT));
    }
}
