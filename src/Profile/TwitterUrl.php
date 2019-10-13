<?php

namespace Cyve\Url\Profile;

use Assert\Assertion;

class TwitterUrl extends ProfileUrl
{
    public function __construct(string $url)
    {
        parent::__construct($url);

        Assertion::same($this->domain, 'twitter.com');
    }

    public function getCanonicalUrl(): string
    {
        if (count($this->path) === 0 && preg_match('/^!\/(.*)/i', $this->fragment, $matches)) {
            return 'https://twitter.com/'.$matches[1];
        }

        return 'https://twitter.com/'.$this->path[0];
    }
}
