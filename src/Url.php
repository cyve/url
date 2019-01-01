<?php

namespace Cyve\Url;

class Url
{
    public $url;
    public $scheme;
    public $username;
    public $password;
    public $host;
    public $subDomain;
    public $domain;
    public $tld;
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

        $this->scheme = $parts['scheme'] ?? null;
        $this->username = $parts['user'] ?? null;
        $this->password = $parts['pass'] ?? null;
        $this->host = $parts['host'] ?? null;
        $this->port = $parts['port'] ?? null;
        $this->path = new Path($parts['path'] ?? null);
        $this->query = new Query($parts['query'] ?? null);
        $this->fragment = $parts['fragment'] ?? null;

        $parts = explode('.', $parts['host']);
        if (count($parts) === 1) {
            $this->domain = $parts[0];
        } elseif (count($parts) === 2) {
            $this->domain = $parts[0].'.'.$parts[1];
            $this->tld = $parts[1];
        } elseif (count($parts) === 3) {
            $this->subDomain = $parts[0];
            $this->domain = $parts[1].'.'.$parts[2];
            $this->tld = $parts[2];
        }
    }

    public function __toString(): string
    {
        $url = '';

        if ($this->host) {
            if ($this->scheme) {
                $url .= $this->scheme.'://';
            }

            if ($this->username) {
                $url .= $this->username;

                if ($this->password) {
                    $url .= ':'.$this->password;
                }

                $url .= '@';
            }

            $url .= $this->host;

            if ($this->port) {
                $url .= ':'.$this->port;
            }
        }

        if ($path = (string) $this->path) {
            $url .= $path;
        }

        if ($query = (string) $this->query) {
            $url .= '?'.$query;
        }

        if ($this->fragment) {
            $url .= '#'.$this->fragment;
        }

        return $url;
    }
}
