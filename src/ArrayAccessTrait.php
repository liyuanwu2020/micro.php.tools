<?php

namespace Mszlu\Tools;

trait ArrayAccessTrait
{
    public function __construct($data = [])
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function toArray(): array
    {
        return (array)$this;
    }

    public function __get($key): mixed
    {
        return $this->{$key} ?? null;
    }

    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->{$offset});
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->{$offset} ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->{$offset});
    }
}