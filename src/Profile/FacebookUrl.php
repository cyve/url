<?php

namespace Cyve\Url\Profile;

use Assert\Assertion;

class FacebookUrl extends ProfileUrl
{
    public function __construct(string $url)
    {
        parent::__construct($url);

        Assertion::same($this->domain, 'facebook.com');
    }

    public function getCanonicalUrl(): string
    {
        // https://www.facebook.com/events/123456789
        if (strtolower($this->path[0]) === 'events') {
            return 'https://www.facebook.com/events/'.$this->path[1];
        }

        // https://www.facebook.com/pages/offshore-rock/123456789
        if (strtolower($this->path[0]) === 'pages') {
            return 'https://www.facebook.com/'.$this->transliterate($this->path[1]).'-'.$this->path[2];
        }

        // https://www.facebook.com/pg/offshore/about
        if (strtolower($this->path[0]) === 'pg') {
            return 'https://www.facebook.com/'.$this->transliterate($this->path[1]);
        }

        // https://www.facebook.com/offshore-rock-123456789
        elseif (preg_match('/^([^\/]+)-(\d+)/i', $this->path[0], $matches)) {
            return 'https://www.facebook.com/'.$this->transliterate($matches[1]).'-'.$matches[2];
        }

        // https://www.facebook.com/profile.php?id=123456789
        if (strtolower($this->path[0]) === 'profile.php' && $this->query->get('id')) {
            return 'https://www.facebook.com/profile.php?id='.$this->query->get('id');
        }

        return 'https://www.facebook.com'.$this->transliterate($this->path);
    }

    /**
     * @param string $str
     * @return string
     */
    private function transliterate(string $str): string
    {
        return \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC; Lower();')->transliterate(urldecode($str)); // Remove accents
    }
}
