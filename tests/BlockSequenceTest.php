<?php

namespace GridPrinciples\ContentBlocks\Tests;

use Illuminate\Support\Str;
use GridPrinciples\ContentBlocks\BlockSequence;
use GridPrinciples\ContentBlocks\Tests\Fake\ExampleContentBlock;

class BlockSequenceTest extends TestCase
{
    public function test_block_sequences_can_be_initialized(): void
    {
        $sequence = new BlockSequence([
            [
                'id' => 1,
                'type' => 'my-example',
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
                'type' => 'my-example',
            ],
            [
                'id' => 2,
                'type' => 'super-duper',
            ],
            [
                'id' => 'buster',
                'type' => 'my-example',
                'data' => ['cartography' => true],
            ]
        ]);

        $this->assertEquals(3, $sequence->count());
        $this->assertEquals(1, $sequence->first()->getID());
        $this->assertEquals('buster', $sequence->last()->getID());
        $this->assertEquals(1, $sequence->firstWhere('id', 1)->getID());
        $this->assertEquals(2, $sequence->firstWhere('id', 2)->getID());
        $this->assertNull($sequence->firstWhere('id', 3));
        $this->assertEquals(1, $sequence->where('type', 'super-duper')->count());
        $this->assertTrue($sequence->find('buster')->getData('cartography'));
        $this->assertTrue($sequence->has('buster'));
        $this->assertFalse($sequence->has('not-there'));
        $this->assertEquals(2, $sequence->forget(1)->count());
        $this->assertEquals('buster', $sequence->move('buster', 0)->first()->getID());

        $this->assertEquals('super-duper', $sequence->firstWhere('id', 2)->getType());
    }

    public function test_block_sequences_are_keyed_when_cast_to_array(): void
    {
        $uuid = Str::uuid();

        $sequence = new BlockSequence([
            [
                'id' => 1,
                'type' => 'my-example',
            ],
            [
                'id' => 42,
                'type' => 'super-duper',
            ],
            [
                'id' => $uuid,
                'type' => 'my-example',
            ],
        ]);

        $this->assertArrayHasKey(1, $sequence->toArray());
        $this->assertArrayHasKey(42, $sequence->toArray());
        $this->assertArrayHasKey($uuid, $sequence->toArray());
    }

    public function test_block_sequence_generation_makes_ulid_keys(): void
    {
        $sequence = BlockSequence::make([
            ['type' => 'my-example'],
            ['type' => 'my-example'],
            ['type' => 'my-example'],
        ]);

        $this->assertIsString($sequence->first()->getID());
        $this->assertIsString($sequence->last()->getID());
    }

    public function test_block_index_can_be_pulled_from_sequence(): void
    {
        $sequence = new BlockSequence([
            new ExampleContentBlock,
            new ExampleContentBlock,
            new ExampleContentBlock,
        ]);

        $this->assertEquals(0, $sequence->indexOf($sequence->first()));
        $this->assertEquals(2, $sequence->indexOf($sequence->last()));
    }
}
