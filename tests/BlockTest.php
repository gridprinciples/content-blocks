<?php

namespace GridPrinciples\ContentBlocks\Tests;

use GridPrinciples\ContentBlocks\Tests\Fake\ExampleContentBlock;
use GridPrinciples\ContentBlocks\Tests\Fake\SuperDuperBlock;

class BlockTest extends TestCase
{
    public function test_blocks_can_be_initialized(): void
    {
        $block = new ExampleContentBlock; // a Fake ID

        $this->assertNotEmpty($block->getID());
    }

    public function test_blocks_can_be_initialized_with_data_and_options(): void
    {
        $block = new ExampleContentBlock(
            data: [
                'title' => 'Hello, World!',
            ],
            options: [
                'foo' => 'bar',
            ]
        );

        $this->assertEquals('my-example', $block->getType());

        $this->assertIsArray($block->getOptions());
        $this->assertArrayHasKey('title', $block->getData());
        $this->assertEquals('Hello, World!', $block->getData('title'));

        $this->assertIsArray($block->getData());
        $this->assertArrayHasKey('foo', $block->getOptions());
        $this->assertEquals('bar', $block->getOption('foo'));
    }

    public function test_blocks_can_be_initialized_by_array(): void
    {
        $block = ExampleContentBlock::make([
            'data' => [
                'title' => 'Hello, World!',
            ],
            'options' => [
                'foo' => 'bar',
            ],
        ]);

        $this->assertEquals('my-example', $block->getType());

        $this->assertIsArray($block->getOptions());
        $this->assertArrayHasKey('title', $block->getData());
        $this->assertEquals('Hello, World!', $block->getData('title'));

        $this->assertIsArray($block->getData());
        $this->assertArrayHasKey('foo', $block->getOptions());
        $this->assertEquals('bar', $block->getOption('foo'));
    }

    public function test_type_is_determined_from_class(): void
    {
        $block = new ExampleContentBlock;

        $this->assertEquals('my-example', $block->getType());

        $block = new SuperDuperBlock;

        $this->assertEquals('super-duper', $block->getType());
    }
}
