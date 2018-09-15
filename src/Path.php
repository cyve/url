<?php

namespace Cyve\Url;

use ArrayAccess;
use Countable;
use Iterator;

class Path implements ArrayAccess, Countable, Iterator
{
	private $items = [];
	private $position = 0;

	public function __construct(string $path)
	{
		$this->items = explode('/', trim($path, '/'));
	}

	public function __toString()
	{
		return '/'.implode('/', $this->items);
	}

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    public function count()
    {
        return count($this->items);
    }
}
