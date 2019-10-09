<?php

namespace Cyve\Url\Test\Profile;

use Cyve\Url\Profile\YoutubeUrl;
use PHPUnit\Framework\TestCase;

class YoutubeUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test($url, $canonical, $kind)
    {
        $url = new YoutubeUrl($url);

        $this->assertEquals($canonical, $url->getCanonicalUrl());
        $this->assertEquals($kind, $url->getInfos('kind'));
    }

    public function urlProvider()
    {
        yield ['https://www.youtube.com/watch?v=GN-_rbIV0jc', 'https://www.youtube.com/watch?v=GN-_rbIV0jc', 'youtube#video'];
        yield ['http://fr-fr.YOUTUBE.com/watch/?v=GN-_rbIV0jc&t=10s', 'https://www.youtube.com/watch?v=GN-_rbIV0jc', 'youtube#video'];
        yield ['https://youtu.be/GN-_rbIV0jc', 'https://www.youtube.com/watch?v=GN-_rbIV0jc', 'youtube#video'];
        yield ['https://youtu.be/GN-_rbIV0jc/?t=10s', 'https://www.youtube.com/watch?v=GN-_rbIV0jc', 'youtube#video'];
        yield ['https://www.youtube.com/embed/GN-_rbIV0jc', 'https://www.youtube.com/watch?v=GN-_rbIV0jc', 'youtube#video'];
        yield ['https://www.youtube.com/embed/GN-_rbIV0jc/?t=10s', 'https://www.youtube.com/watch?v=GN-_rbIV0jc', 'youtube#video'];

        yield ['https://www.youtube.com/channel/UCpAyqgNZY--jEGmidNSDr8w', 'https://www.youtube.com/channel/UCpAyqgNZY--jEGmidNSDr8w', 'youtube#channel'];
        yield ['http://fr-fr.YOUTUBE.com/channel/UCpAyqgNZY--jEGmidNSDr8w?ref=about', 'https://www.youtube.com/channel/UCpAyqgNZY--jEGmidNSDr8w', 'youtube#channel'];

        yield ['https://www.youtube.com/playlist?list=UUpAyqgNZY--jEGmidNSDr8w', 'https://www.youtube.com/playlist?list=UUpAyqgNZY--jEGmidNSDr8w', 'youtube#playlist'];
        yield ['http://fr-fr.YOUTUBE.com/playlist?list=UUpAyqgNZY--jEGmidNSDr8w&ref=about', 'https://www.youtube.com/playlist?list=UUpAyqgNZY--jEGmidNSDr8w', 'youtube#playlist'];

        yield ['https://www.youtube.com/user/sonducoin', 'https://www.youtube.com/user/sonducoin', 'youtube#user'];
        yield ['http://fr-fr.YOUTUBE.com/user/SonDuCoin', 'https://www.youtube.com/user/sonducoin', 'youtube#user'];
        yield ['https://www.youtube.com/user/sonducoin/videos/', 'https://www.youtube.com/user/sonducoin', 'youtube#user'];
        yield ['https://www.youtube.com/user/sonducoinvideos', 'https://www.youtube.com/user/sonducoinvideos', 'youtube#user'];

        yield ['https://www.youtube.com/sonducoin', 'https://www.youtube.com/sonducoin', null];
        yield ['http://fr-fr.YOUTUBE.com/sonducoin?ref=about', 'https://www.youtube.com/sonducoin', null];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new YoutubeUrl('https://www.sonducoin.fr');
    }
}
