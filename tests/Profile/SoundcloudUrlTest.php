<?php

namespace Cyve\Url\Test\Profile;

use Cyve\Url\Profile\SoundcloudUrl;
use PHPUnit\Framework\TestCase;

class SoundcloudUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test($url, $expected)
    {
        $url = new SoundcloudUrl($url);

        $this->assertEquals($expected, $url->getCanonicalUrl());
    }

    public function urlProvider()
    {
        yield ['https://soundcloud.com/lorem', 'https://soundcloud.com/lorem'];
        yield ['http://fr-fr.SOUNDCLOUD.com/lorem/?ref=about', 'https://soundcloud.com/lorem'];
        yield ['https://w.soundcloud.com/player/?url=https://soundcloud.com/lorem&foo=bar', 'https://soundcloud.com/lorem'];
        yield ['https://soundcloud.com/lorem/sets/ipsum', 'https://soundcloud.com/lorem/sets/ipsum'];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new SoundcloudUrl('https://www.sonducoin.fr');
    }
}
