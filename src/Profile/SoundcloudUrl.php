<?php

namespace Cyve\Url\Profile;

use Assert\Assertion;

class SoundcloudUrl extends ProfileUrl
{
    public function __construct(string $url)
    {
        parent::__construct($url);

        Assertion::same($this->domain, 'soundcloud.com');
    }

    public function getCanonicalUrl(): string
    {
        // ex: https://w.soundcloud.com/player/?url=https://api.soundcloud.com/track/123456789
        if ($this->path[0] === 'player' && $this->query->get('url')) {
            return (string) $this;
        }

        return 'https://soundcloud.com'.strtolower($this->path);
    }
}
