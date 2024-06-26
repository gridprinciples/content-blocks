<?php

namespace GridPrinciples\ContentBlocks;

use GridPrinciples\ContentBlocks\Facades\ContentBlocks;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonSerializable;

abstract class Block implements Arrayable, JsonSerializable
{
    public $type = null;

    public function __construct(
        public string | int | array | null $id = null,
        public array $data = [],
        public array $options = [],
    ) {
        if (is_array($id)) {
            $this->id = Arr::get($id, 'id');
            $this->data = Arr::get($id, 'data', []);
            $this->options = Arr::get($id, 'options', []);
        }

        if (! $this->id) {
            $this->id = $this->generateUniqueID();
        }

        if(! $this->type) {
            $this->type = static::determineType();
        }
        
        $this->boot();
    }

    protected function boot(): void
    {
        //
    }

    public static function make(array $attributes): static
    {
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

    public function getID(): string | int | null
    {
        return $this->id;
    }

    public static function getType(): string
    {
        return (new static)->type;
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

    public function setOptions(array $value): void
    {
        $this->options = $value;;
    }

    public function update(array $input = []): void
    {
        $this->updateOptions(Arr::get($input, 'options', []));
    }

    public function updateOptions(array $options = []): void
    {
        $this->options = array_merge($this->options, $options);
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

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
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

    protected function generateUniqueID(): string
    {
        return Str::ulid(now());
    }
}
