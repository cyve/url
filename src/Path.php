<?php

namespace Cyve\Url;

use ArrayAccess;
use Countable;
use Iterator;

class Path implements ArrayAccess, Countable, Iterator
{
    use Utils\ArrayAccess;
    use Utils\Countable;
	use Utils\Iterator;

	public function __construct(string $path)
	{
		$this->items = explode('/', trim($path, '/'));
	}

	public function __toString()
	{
		return '/'.implode('/', $this->items);
	}
}
