<?php

namespace Cyve\Url\Test\Profile;

use Cyve\Url\Profile\BandcampUrl;
use PHPUnit\Framework\TestCase;

class BandcampUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test($url, $expected)
    {
        $url = new BandcampUrl($url);

        $this->assertEquals($expected, $url->getCanonicalUrl());
    }

    public function urlProvider()
    {
        yield ['https://lorem.bandcamp.com', 'https://lorem.bandcamp.com'];
        yield ['http://www.lorem.BANDCAMP.com/releases/?ref=about', 'https://lorem.bandcamp.com'];

        yield ['https://lorem.bandcamp.com/album/ipsum', 'https://lorem.bandcamp.com/album/ipsum'];
        yield ['https://lorem.bandcamp.com/album/ipsum/?ref=about', 'https://lorem.bandcamp.com/album/ipsum'];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new BandcampUrl('https://www.sonducoin.fr');
    }
}
