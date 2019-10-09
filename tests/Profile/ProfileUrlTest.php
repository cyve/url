<?php

namespace Cyve\Url\Test\Profile;

use Cyve\Url\Profile\BandcampUrl;
use Cyve\Url\Profile\FacebookUrl;
use Cyve\Url\Profile\ProfileUrl;
use Cyve\Url\Profile\SoundcloudUrl;
use Cyve\Url\Profile\TwitterUrl;
use Cyve\Url\Profile\YoutubeUrl;
use Cyve\Url\Url;
use PHPUnit\Framework\TestCase;

class ProfileUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testCreate($url, $expectedType)
    {
        $this->assertInstanceOf($expectedType, ProfileUrl::create($url));
    }

    public function urlProvider()
    {
        yield ['https://bandcamp.com', BandcampUrl::class];
        yield ['https://facebook.com', FacebookUrl::class];
        yield ['https://soundcloud.com', SoundcloudUrl::class];
        yield ['https://twitter.com', TwitterUrl::class];
        yield ['https://youtube.com', YoutubeUrl::class];
        yield ['https://www.sonducoin.fr', Url::class];
    }
}
