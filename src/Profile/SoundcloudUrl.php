<?php

namespace Cyve\Url\Profile;

use Assert\Assertion;
use Cyve\Url\Url;

class SoundcloudUrl extends Url
{
    public function __construct(string $url)
    {
        parent::__construct($url);

        Assertion::same($this->domain, 'soundcloud.com');
    }

    public function getCanonicalUrl(): string
    {
        // ex: https://w.soundcloud.com/player/?url=https://soundcloud.com/lorem&foo=bar
        if ($this->path[0] === 'player' && $url = $this->query->get('url')) {
            $url = new self($url);

            return $url->getCanonicalUrl();
        }

        return 'https://soundcloud.com'.strtolower($this->path);
    }
}
