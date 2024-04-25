<?php

namespace GridPrinciples\ContentBlocks;

class BlockManager
{
    protected array $loadedBlocks = [];

    public function getBlocks(): array
    {
        return $this->loadedBlocks;
    }

    public function loadBlocks(string | array $namespace, string $directory = null)
    {
        if(is_array($namespace)) {
            // An array of namespaces and directories was provided
            foreach ($namespace as $ns => $dir) {
                $this->loadBlocks($ns, $dir);
            }

            return;
        }

        if(! $directory) {
            throw new \InvalidArgumentException('Directory must be provided.');
        }

        $classes = [];

        // Find matching files
        $files = glob($directory.'.php');

        foreach ($files as $file) {
            // Extract the class name from the file name
            $blockClass = $namespace.'\\'.basename($file, '.php');

            if (! class_exists($blockClass)) {
                throw new \InvalidArgumentException("Class '{$blockClass}' not found.");
            }

            // Add the class name to the list
            $classes[$blockClass::getType()] = $blockClass;
        }

        $this->loadedBlocks = array_merge($this->loadedBlocks, $classes);
    }
}
