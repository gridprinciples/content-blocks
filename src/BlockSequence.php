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

        $items = parent::getArrayableItems($items);

        foreach ($items as $k => $item) {
            if(is_array($item) && ! isset($item['id'])) {
                $item['id'] = $k;
            }

            if (is_array($item) && isset($item['type'])) {
                $items[$k] = Block::make($item);
            }
        }

        return array_values($items);
    }

    public function toArray()
    {
        $blocks = $this->keyById(array_map(
            fn (Block $block) => $block->toArray(),
            $this->items
        ), fn ($item) => $item['id']);

        // Remove the ID field, since it's redundant.
        foreach ($blocks as $k => $block) {
            unset($blocks[$k]['id']);
        }

        return $blocks;
    }

    // Key the result by the ID generated within the class.
    // Thanks, https://gist.github.com/abiusx/4ed90007ca693802cc7a56446cfd9394
    protected function keyById(array $items, \Closure $callback): array
    {
        if(empty($items)) {
            return [];
        }

        return array_reduce($items, function ($carry, $val) use ($callback) {
            $key = call_user_func($callback, $val);
            $carry[$key] = $val;
            return $carry;
        });
    }
}
