<?php

namespace Cyve\Url\Test\Profile;

use Cyve\Url\Profile\FacebookUrl;
use PHPUnit\Framework\TestCase;

class FacebookUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test($url, $expected)
    {
        $url = new FacebookUrl($url);

        $this->assertEquals($expected, $url->getCanonicalUrl());
    }

    public function urlProvider()
    {
        yield ['https://www.facebook.com/sonducoin', 'https://www.facebook.com/sonducoin'];
        yield ['https://www.facebook.com/le-son-du-coin-261639057280603', 'https://www.facebook.com/le-son-du-coin-261639057280603'];
        yield ['http://fr-fr.FACEBOOK.com/pages/Le-Son-du-Co%C3%AEn/261639057280603/?ref=about', 'https://www.facebook.com/le-son-du-coin-261639057280603'];

        yield ['https://www.facebook.com/pg/sonducoin/about', 'https://www.facebook.com/sonducoin'];
        yield ['https://www.facebook.com/pg/le-son-du-coin-261639057280603/about', 'https://www.facebook.com/le-son-du-coin-261639057280603'];
        yield ['https://www.facebook.com/le-son-du-coin-261639057280603/about', 'https://www.facebook.com/le-son-du-coin-261639057280603'];

        yield ['https://www.facebook.com/events/841108379243132', 'https://www.facebook.com/events/841108379243132'];
        yield ['http://fr-fr.facebook.com/events/841108379243132/?ref=about', 'https://www.facebook.com/events/841108379243132'];
        yield ['https://www.facebook.com/events/841108379243132/about', 'https://www.facebook.com/events/841108379243132'];

        yield ['https://www.facebook.com/profile.php?id=1234', 'https://www.facebook.com/profile.php?id=1234'];
        yield ['http://fr-fr.facebook.com/profile.php?id=1234&ref=about', 'https://www.facebook.com/profile.php?id=1234'];
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);

        new FacebookUrl('https://www.sonducoin.fr');
    }
}
