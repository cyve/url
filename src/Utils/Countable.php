<?php

namespace Cyve\Url\Utils;

trait Countable
{
    private array $items = [];

    public function count(): int
    {
        return count($this->items);
    }
}
