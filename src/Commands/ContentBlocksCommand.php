<?php

namespace GridPrinciples\ContentBlocks\Commands;

use Illuminate\Console\Command;

class ContentBlocksCommand extends Command
{
    public $signature = 'content-blocks';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
