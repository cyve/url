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
        yield ['https://soundcloud.com/lorem/sets/ipsum', 'https://soundcloud.com/lorem/sets/ipsum'];
        yield ['https://w.soundcloud.com/player/?url=https://api.soundcloud.com/track/123456789', 'https://w.soundcloud.com/player?url=https%3A%2F%2Fapi.soundcloud.com%2Ftrack%2F123456789'];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new SoundcloudUrl('https://www.sonducoin.fr');
    }
}
