<?php

namespace Cyve\Url;

class Query
{
	private $parameters = [];

	public function __construct(string $query)
	{
		parse_str($query, $this->parameters);
	}

	public function __toString()
	{
		return http_build_query($this->parameters);
	}

	public function get(string $key, $default = null)
	{
		return $this->parameters[$key] ?? $default;
	}

	public function set(string $key, $value)
	{
		$this->parameters[$key] = $value;

		return $this;
	}

	public function all()
	{
		return $this->parameters;
	}
}
