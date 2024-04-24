<?php

namespace GridPrinciples\ContentBlocks;

use Illuminate\Support\Collection;

class BlockSequence extends Collection
{
    protected function getArrayableItems($items)
    {
        return array_map(
            fn ($item) => $item instanceof Block ? $item : Block::make($item),
            parent::getArrayableItems($items)
        );
    }
}
