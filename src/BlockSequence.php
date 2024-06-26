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
            if(is_string($k)) {
                $item['id'] = $k;
            }

            if (is_array($item) && isset($item['type'])) {
                $items[$k] = Block::make($item);
            }
        }

        return array_values($items);
    }

    public function find($id)
    {
        return $this->firstWhere('id', $id);
    }

    public function has($id)
    {
        return $this->find($id) !== null;
    }

    public function forget($id)
    {
        $block = $this->find($id);

        if ($block === null) {
            return $this;
        }

        $this->items = array_values(array_filter($this->items, fn ($item) => $item->id !== $id));

        return $this;
    }

    public function move($id, int $position)
    {
        $block = $this->find($id);

        if ($block === null) {
            return $this;
        }

        $this->forget($id);
        $this->splice($position, 0, [$block]);

        return $this;
    }

    public function indexOf(string | int | Block | null $block): int
    {
        if ($block instanceof Block) {
            return $this->indexOf($block->getID());
        }

        if (is_string($block) || is_int($block)) {
            return array_search($block, array_map(fn ($item) => $item->id, $this->items));
        }

        return -1;
    }

    public function getBlockAfter($id)
    {
        $index = $this->indexOf($id);

        if ($index === -1) {
            return null;
        }

        return $this->items[$index + 1] ?? null;
    }

    public function getBlockBefore($id)
    {
        $index = $this->indexOf($id);

        if ($index === -1) {
            return null;
        }

        return $this->items[$index - 1] ?? null;
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

    public function updateBlock($id, array $data)
    {
        $block = $this->find($id);

        if ($block === null) {
            return $this;
        }

        $block->update($data);

        return $this;
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
