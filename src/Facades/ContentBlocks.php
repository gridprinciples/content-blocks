<?php

namespace GridPrinciples\ContentBlocks\Facades;

use GridPrinciples\ContentBlocks\BlockManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getBlocks()
 * @method static void routePages(string|null $prefix = null)
 *
 * @see \GridPrinciples\ContentBlocks\BlockManager
 */
class ContentBlocks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BlockManager::class;
    }
}
