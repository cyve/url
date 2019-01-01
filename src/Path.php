<?php

namespace Cyve\Url;

class Path implements \ArrayAccess, \Countable, \Iterator
{
    use Utils\ArrayAccess;
    use Utils\Countable;
    use Utils\Iterator;

    public function __construct(string $path = null)
    {
        if ($path && $path !== '/') {
            $this->items = explode('/', trim($path, '/'));
        }
    }

    public function __toString(): string
    {
        return count($this->items) ? '/'.implode('/', $this->items) : '';
    }
}
