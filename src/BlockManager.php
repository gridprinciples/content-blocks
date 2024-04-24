<?php

namespace GridPrinciples\ContentBlocks;

class BlockManager
{
    protected ?array $loadedBlocks = null;

    public function getBlocks(): array
    {
        if (is_null($this->loadedBlocks)) {
            $this->loadBlocks();
        }

        return $this->loadedBlocks;
    }

    protected function loadBlocks()
    {
        $directories = config('content-blocks.load_blocks_from', []);

        $classes = [];

        foreach ($directories as $namespace => $directory) {
            // Find matching files
            $files = glob($directory.'.php');

            foreach ($files as $file) {
                // Extract the class name from the file name
                $className = $namespace.'\\'.basename($file, '.php');

                if (! class_exists($className)) {
                    throw new \InvalidArgumentException("Class '{$className}' not found.");
                }

                // Add the class name to the list
                $classes[$className::getType()] = $className;
            }
        }

        $this->loadedBlocks = $classes;
    }
}
