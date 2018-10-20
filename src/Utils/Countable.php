<?php

namespace Cyve\Url\Utils;

trait Countable
{
    private $items = [];

    public function count()
    {
        return count($this->items);
    }
}
