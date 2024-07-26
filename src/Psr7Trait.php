<?php

namespace Cyve\Url;

use Psr\Http\Message\UriInterface;

trait Psr7Trait
{
    public function getScheme(): string
    {
        return $this->scheme ?? '';
    }

    public function getAuthority(): string
    {
        if (empty($this->host)) {
            return '';
        }

        $authority = $this->host;
        $userInfo = $this->getUserInfo();
        if (!empty($this->getUserInfo())) {
            $authority = $userInfo.'@'.$authority;
        }
        if (!empty($this->port)) {
            $authority .= ':'.$this->port;
        }

        return $authority;
    }

    public function getUserInfo(): string
    {
        return implode(':', array_filter([$this->username ?? null, $this->password ?? null]));
    }

    public function getHost(): string
    {
        return $this->host ?? '';
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }

    public function getQuery(): string
    {
        return (string) $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment ?? '';
    }

    public function withScheme(string $scheme): UriInterface
    {
        if (!in_array($scheme, ['http', 'https'])) {
            throw new \InvalidArgumentException(sprintf('`%s` is not a valid scheme (`http` or `https` allowed)', $scheme));
        }

        $this->scheme = $scheme;

        return $this;
    }

    public function withUserInfo(string $user, ?string $password = null): UriInterface
    {
        $this->username = $user;
        $this->password = $password;

        return $this;
    }

    public function withHost(string $host): UriInterface
    {
        $this->host = $host;

        $parts = explode('.', $this->host);
        $this->tld = array_pop($parts);
        $this->domain = array_pop($parts).'.'.$this->tld;
        $this->subDomain = implode('.', $parts);

        return $this;
    }

    public function withPort(?int $port): UriInterface
    {
        $this->port = $port;

        return $this;
    }

    public function withPath(string $path): UriInterface
    {
        $this->path = new Path($path);

        return $this;
    }

    public function withQuery(string $query): UriInterface
    {
        $this->query = new Query($query);

        return $this;
    }

    public function withFragment(string $fragment): UriInterface
    {
        $this->fragment = $fragment;

        return $this;
    }
}
