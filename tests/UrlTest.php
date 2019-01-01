<?php

namespace Cyve\Url\Test;

use Cyve\Url\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testUrl($url, $expect)
    {
        $objectUrl = new Url($url);

        $this->assertEquals($expect['url'], (string) $objectUrl);
        $this->assertEquals($expect['scheme'], $objectUrl->scheme);
        $this->assertEquals($expect['username'], $objectUrl->username);
        $this->assertEquals($expect['password'], $objectUrl->password);
        $this->assertEquals($expect['host'], $objectUrl->host);
        $this->assertEquals($expect['subDomain'], $objectUrl->subDomain);
        $this->assertEquals($expect['domain'], $objectUrl->domain);
        $this->assertEquals($expect['tld'], $objectUrl->tld);
        $this->assertEquals($expect['port'], $objectUrl->port);
        $this->assertEquals($expect['scheme'], $objectUrl->scheme);
        $this->assertEquals($expect['path'], (string) $objectUrl->path);
        $this->assertEquals($expect['query'], (string) $objectUrl->query);
        $this->assertEquals($expect['fragment'], $objectUrl->fragment);
    }

    public function urlProvider()
    {
        yield [
            'https://username:password@sub.domain.tld:8000/foo/bar?lorem=ipsum#fragment',
            [
                'url' => 'https://username:password@sub.domain.tld:8000/foo/bar?lorem=ipsum#fragment',
                'scheme' => 'https',
                'username' => 'username',
                'password' => 'password',
                'host' => 'sub.domain.tld',
                'subDomain' => 'sub',
                'domain' => 'domain.tld',
                'tld' => 'tld',
                'port' => 8000,
                'path' => '/foo/bar',
                'query' => 'lorem=ipsum',
                'fragment' => 'fragment',
            ]
        ];
        yield [
            'http://domain.tld',
            [
                'url' => 'http://domain.tld',
                'scheme' => 'http',
                'username' => null,
                'password' => null,
                'host' => 'domain.tld',
                'subDomain' => null,
                'domain' => 'domain.tld',
                'tld' => 'tld',
                'port' => null,
                'path' => null,
                'query' => null,
                'fragment' => null,
            ]
        ];
        yield [
            'http://domain.tld/',
            [
                'url' => 'http://domain.tld',
                'scheme' => 'http',
                'username' => null,
                'password' => null,
                'host' => 'domain.tld',
                'subDomain' => null,
                'domain' => 'domain.tld',
                'tld' => 'tld',
                'port' => null,
                'path' => null,
                'query' => null,
                'fragment' => null,
            ]
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidUrl()
    {
        new Url('foo');
    }
}
