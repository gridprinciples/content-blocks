<?php

namespace GridPrinciples\ContentBlocks\Facades;

use GridPrinciples\ContentBlocks\BlockManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getBlocks()
 *
 * @see \GridPrinciples\ContentBlocks\ContentBlocks
 */
class ContentBlocks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BlockManager::class;
    }
}
