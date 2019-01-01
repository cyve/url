<?php

namespace Cyve\Url;

class Query
{
    private $items = [];

    public function __construct(string $query = null)
    {
        if ($query && $query !== '?') {
            parse_str($query, $this->items);
        }
    }

    public function __toString(): string
    {
        return http_build_query($this->items);
    }

    public function get(string $key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    public function set(string $key, $value)
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function all()
    {
        return $this->items;
    }
}
