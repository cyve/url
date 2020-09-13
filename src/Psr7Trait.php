<?php

namespace Cyve\Url;

use Assert\Assertion;

trait Psr7Trait
{
    public function getScheme()
    {
        return $this->scheme ?? '';
    }

    public function getAuthority()
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

    public function getUserInfo()
    {
        return implode(':', array_filter([$this->username ?? null, $this->password ?? null]));
    }

    public function getHost()
    {
        return $this->host ?? '';
    }

    public function getPort()
    {
        return $this->port ?? '';
    }

    public function getPath()
    {
        return (string) $this->path;
    }

    public function getQuery()
    {
        return (string) $this->query;
    }

    public function getFragment()
    {
        return $this->fragment ?? '';
    }

    public function withScheme($scheme)
    {
        Assertion::inArray($scheme, ['http', 'https']);

        $this->scheme = $scheme;

        return $this;
    }

    public function withUserInfo($user, $password = null)
    {
        $this->username = $user;
        $this->password = $password;

        return $this;
    }

    public function withHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function withPort($port)
    {
        $this->port = $port;

        return $this;
    }

    public function withPath($path)
    {
        $this->path = new Path($path);

        return $this;
    }

    public function withQuery($query)
    {
        $this->query = new Query($query);

        return $this;
    }

    public function withFragment($fragment)
    {
        $this->fragment = $fragment;

        return $this;
    }
}
