<?php

namespace Cyve\Url;

use Assert\Assertion;

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
    public $fragment;

    public function __construct(string $url)
    {
        Assertion::url($url);

        $parts = parse_url($url);

        if (isset($parts['user']) || isset($parts['pass'])) {
            @trigger_error('Using credentials in the URL is deprecated. See https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Access_using_credentials_in_the_URL', E_USER_DEPRECATED);
        }

        $this->scheme = $parts['scheme'] ?? null;
        $this->username = $parts['user'] ?? null;
        $this->password = $parts['pass'] ?? null;
        $this->host = $parts['host'] ?? null;
        $this->port = $parts['port'] ?? null;
        $this->path = new Path($parts['path'] ?? null);
        $this->query = new Query($parts['query'] ?? null);
        $this->fragment = $parts['fragment'] ?? null;

        $parts = explode('.', $this->host);
        $this->tld = array_pop($parts);
        $this->domain = array_pop($parts).'.'.$this->tld;
        $this->subDomain = implode('.', $parts);
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
