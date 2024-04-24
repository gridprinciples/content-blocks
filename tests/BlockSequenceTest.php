<?php

namespace GridPrinciples\ContentBlocks\Tests;

use GridPrinciples\ContentBlocks\BlockSequence;
use GridPrinciples\ContentBlocks\Tests\Fake\ExampleContentBlock;

class BlockSequenceTest extends TestCase
{
    public function test_block_sequences_can_be_initialized(): void
    {
        $sequence = new BlockSequence([
            [
                'id' => 1,
                'type' => 'example',
            ],
        ]);

        $this->assertIsArray($sequence->all());
        $this->assertNotEmpty($sequence->all());
        $this->assertEquals(ExampleContentBlock::class, get_class($sequence->first()));
    }

    public function test_block_sequences_can_use_collection_methods(): void
    {
        $sequence = new BlockSequence([
            [
                'id' => 1,
                'type' => 'example',
            ],
            [
                'id' => 2,
                'type' => 'super-duper',
            ],
        ]);

        $this->assertEquals(2, $sequence->count());
        $this->assertEquals(1, $sequence->first()->getID());
        $this->assertEquals('super-duper', $sequence->firstWhere('id', 2)->getType());
    }
}
