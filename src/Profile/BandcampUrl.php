<?php

namespace Cyve\Url\Profile;

use Assert\Assertion;
use Cyve\Url\Url;

class BandcampUrl extends Url
{
    public function __construct(string $url)
    {
        parent::__construct($url);

        Assertion::same($this->domain, 'bandcamp.com');
    }

    public function getCanonicalUrl(): string
    {
        $this->subDomain = str_replace('www.', '', $this->subDomain);

        if ($this->path[0] === 'releases' || $this->path[0] === 'music') {
            unset($this->path[0]);
        }

        return 'https://'.$this->subDomain.'.bandcamp.com'.$this->path;
    }
}
