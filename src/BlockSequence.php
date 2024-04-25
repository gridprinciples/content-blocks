<?php

namespace GridPrinciples\ContentBlocks;

use Illuminate\Support\Collection;

class BlockSequence extends Collection
{
    protected function getArrayableItems($items)
    {
        if (is_null($items)) {
            return [];
        }

        foreach ($items as $k => $item) {
            if (! $item instanceof Block && ! isset($item['id'])) {
                $items[$k]['id'] = $k;
            }
        }

        return array_map(
            fn ($item) => $item instanceof Block ? $item : Block::make($item),
            parent::getArrayableItems($items)
        );
    }

    public function toArray()
    {
        return array_map(
            fn (Block $block) => $block->toArray(),
            $this->items
        );
    }
}
