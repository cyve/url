<?php

namespace Cyve\Url;

class Url
{
	public $scheme;
	public $username;
	public $password;
	public $host;
	public $port;
	public $path;
	public $query;
	public $fragent;

	public function __construct(string $url)
	{
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(sprintf('Invalid URL "%s"', $url));
		}

		$parts = parse_url($url);

		$this->scheme = $parts['scheme'] ?? 'http';
		$this->username = $parts['user'] ?? null;
		$this->password = $parts['pass'] ?? null;
		$this->host = $parts['host'] ?? null;
		$this->port = $parts['port'] ?? 80;
		$this->path = $parts['path'] ?? '/';
		$this->query = new Query($parts['query'] ?? '');
		$this->fragment = $parts['fragment'] ?? null;
	}

}
