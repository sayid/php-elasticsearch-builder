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

        $expectedQuery = [
            'constant_score' => [
                'filter' => [
                    'term' => [
                        'user' => 'john',
                    ],
                ],
            ],
        ];

        $this->assertSame($expectedQuery, $query->toArray());
    }
}
