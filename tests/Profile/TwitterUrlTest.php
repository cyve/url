<?php

namespace Cyve\Url\Test\Profile;

use Cyve\Url\Profile\TwitterUrl;
use PHPUnit\Framework\TestCase;

class TwitterUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test($url, $expected)
    {
        $url = new TwitterUrl($url);

        $this->assertEquals($expected, $url->getCanonicalUrl());
    }

    public function urlProvider()
    {
        yield ['https://twitter.com/lorem', 'https://twitter.com/lorem'];
        yield ['http://fr-fr.TWITTER.com/lorem/?ref=about', 'https://twitter.com/lorem'];
        yield ['http://fr-fr.twitter.com/#!/lorem', 'https://twitter.com/lorem'];
        yield ['https://twitter.com/lorem/followers', 'https://twitter.com/lorem'];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new TwitterUrl('https://www.sonducoin.fr');
    }
}
