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

    public static function urlProvider()
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
        yield [
            'http://a.b.c.domain.tld',
            [
                'url' => 'http://a.b.c.domain.tld',
                'scheme' => 'http',
                'username' => null,
                'password' => null,
                'host' => 'a.b.c.domain.tld',
                'subDomain' => 'a.b.c',
                'domain' => 'domain.tld',
                'tld' => 'tld',
                'port' => null,
                'path' => null,
                'query' => null,
                'fragment' => null,
            ]
        ];
        yield [
            'HTTPS://USERNAME:PASSWORD@SUB.DOMAIN.TLD:8000/FOO/BAR?LOREM=IPSUM#FRAGMENT',
            [
                'url' => 'https://USERNAME:PASSWORD@sub.domain.tld:8000/FOO/BAR?LOREM=IPSUM#FRAGMENT',
                'scheme' => 'https',
                'username' => 'USERNAME',
                'password' => 'PASSWORD',
                'host' => 'sub.domain.tld',
                'subDomain' => 'sub',
                'domain' => 'domain.tld',
                'tld' => 'tld',
                'port' => 8000,
                'path' => '/FOO/BAR',
                'query' => 'LOREM=IPSUM',
                'fragment' => 'FRAGMENT',
            ]
        ];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Url('foo');
    }

    public function testPsr7()
    {
        $url = new Url('http://domain.tld');

        $this->assertEquals('https', $url->withScheme('https')->getScheme());
        $this->assertEquals('sub.domain.tld', $url->withHost('sub.domain.tld')->getHost());
        $this->assertEquals('8000', $url->withPort(8000)->getPort());
        $this->assertEquals('username:password', $url->withUserInfo('username', 'password')->getUserInfo());
        $this->assertEquals('username:password@sub.domain.tld:8000', $url->getAuthority());
        $this->assertEquals('/foo/bar', $url->withPath('/foo/bar')->getPath());
        $this->assertEquals('lorem=ipsum', $url->withQuery('lorem=ipsum')->getQuery());
        $this->assertEquals('fragment', $url->withFragment('fragment')->getFragment());
        $this->assertEquals('https://username:password@sub.domain.tld:8000/foo/bar?lorem=ipsum#fragment', (string) $url);
    }
}
