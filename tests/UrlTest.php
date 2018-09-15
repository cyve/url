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
		$url = new Url($url);
		
		$this->assertEquals($expect['scheme'], $url->scheme);
		$this->assertEquals($expect['username'], $url->username);
		$this->assertEquals($expect['password'], $url->password);
		$this->assertEquals($expect['host'], $url->host);
		$this->assertEquals($expect['port'], $url->port);
		$this->assertEquals($expect['scheme'], $url->scheme);
		$this->assertEquals($expect['path'], $url->path);
		$this->assertEquals($expect['query'], $url->query);
		$this->assertEquals($expect['fragment'], $url->fragment);
	}

	public function urlProvider()
	{
		yield [
			'https://username:password@domain.tld:8000/foo/bar?lorem=ipsum#fragment',
			[
				'scheme' => 'https',
				'username' => 'username',
				'password' => 'password',
				'host' => 'domain.tld',
				'port' => 8000,
				'path' => '/foo/bar',
				'query' => 'lorem=ipsum',
				'fragment' => 'fragment',
			]
		];
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidUrl()
	{
		$url = new Url('foo');
	}
}
