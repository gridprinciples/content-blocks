<?php

namespace GridPrinciples\ContentBlocks;

use GridPrinciples\ContentBlocks\Facades\ContentBlocks;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class Block implements Arrayable
{
    public static ?string $type = null;

    public function __construct(
        public string | int | array $id,
        public array $data = [],
        public array $options = [],
    ) {
        if (is_array($id)) {
            $this->id = Arr::get($id, 'id');
            $this->data = Arr::get($id, 'data', []);
            $this->options = Arr::get($id, 'options', []);
        }
    }

    public static function make(array $attributes): static
    {
        if (! isset($attributes['id'])) {
            throw new \InvalidArgumentException('Content block must have an ID.');
        }

        if (isset($attributes['type']) && static::determineType() !== $attributes['type']) {
            $className = static::getLoadedClassFromType($attributes['type']);
        } else {
            $className = static::class;
        }

        return new $className(
            id: Arr::get($attributes, 'id'),
            data: Arr::get($attributes, 'data', []),
            options: Arr::get($attributes, 'options', []),
        );
    }

    public function getID(): string | int
    {
        return $this->id;
    }

    public static function getType(): string
    {
        return static::$type ?: static::determineType();
    }

    public function getData(?string $key = null, mixed $default = null): mixed
    {
        if (! $key) {
            return $this->data;
        }

        return $this->getDatum($key, $default);
    }

    public function getDatum(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key) ?? $default;
    }

    public function setData(array | string $key, mixed $value): void
    {
        if (is_array($key)) {
            $this->data = $key;

            return;
        }

        $this->setDatum($key, $value);
    }

    public function setDatum(string $key, mixed $value): void
    {
        Arr::set($this->data, $key, $value);
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->options, $key) ?? $default;
    }

    public function setOption(string $key, mixed $value): void
    {
        Arr::set($this->options, $key, $value);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getID(),
            'type' => $this->getType(),
            'data' => $this->getData(),
            'options' => $this->getOptions(),
        ];
    }

    public static function getLoadedClassFromType(string $type): string
    {
        $loadedBlocks = ContentBlocks::getBlocks();

        if (isset($loadedBlocks[$type])) {
            return $loadedBlocks[$type];
        }

        throw new \InvalidArgumentException("No class found for type '{$type}'.");
    }

    /**
     * Generate the type of the block based on the class name or provided string.
     */
    protected static function determineType(): string
    {
        return Str::of(class_basename(static::class))
            ->snake('-')
            ->replaceMatches('/(\-block|\-content\-block)$/', '');
    }
}
