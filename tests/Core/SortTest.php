<?php

namespace Hypefactors\ElasticBuilder\Tests\Core;

use stdClass;
use RuntimeException;
use PHPUnit\Framework\TestCase;
use Hypefactors\ElasticBuilder\Core\Sort;

class SortTest extends TestCase
{
    /** @test */
    public function it_test_1()
    {
        $sort = new Sort();
        $sort->field('my-field');

        $expected = [
            'my-field' => new stdClass(),
        ];

        $this->assertEquals($expected, $sort->toArray());
    }

    /** @test */
    public function test_2()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');

        $expected = [
            'my-field' => 'desc',
        ];

        $this->assertEquals($expected, $sort->toArray());
    }

    /** @test */
    public function test_3()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->mode('avg');

        $expected = [
            'my-field' => [
                'mode' => 'avg',
            ],
        ];

        $this->assertEquals($expected, $sort->toArray());
    }

    /** @test */
    public function test_4()
    {
        $sort = new Sort();
        $sort->field('my-field');
        $sort->order('desc');
        $sort->mode('avg');

        $expected = [
            'my-field' => [
                'order' => 'desc',
                'mode'  => 'avg',
            ],
        ];

        $this->assertEquals($expected, $sort->toArray());
    }

    /** @test */
    public function an_exception_will_be_thrown_when_setting_an_invalid_order()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] order is invalid!');

        $sort = new Sort();
        $sort->order('foo');
    }

    /** @test */
    public function an_exception_will_be_thrown_when_setting_an_invalid_mode()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [foo] mode is invalid!');

        $sort = new Sort();
        $sort->mode('foo');
    }
}
