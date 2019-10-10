<?php

namespace Cyve\Url\Profile;

use Cyve\Url\Url;

class ProfileUrl extends Url
{
    public static function create(string $url): Url
    {
        if (stripos($url, 'bandcamp.com')) {
            return new BandcampUrl($url);
        } else if (stripos($url, 'facebook.com')) {
            return new FacebookUrl($url);
        } else if (stripos($url, 'soundcloud.com')) {
            return new SoundcloudUrl($url);
        } else if (stripos($url, 'twitter.com')) {
            return new TwitterUrl($url);
        } else if (stripos($url, 'youtube.com') || stripos($url, 'youtu.be')) {
            return new YoutubeUrl($url);
        } else {
            return new static($url);
        }
    }

    public function getCanonicalUrl(): string
    {
        return (string) $this;
    }

    public function getProvider(): ?string
    {
        switch ($this->domain) {
            case 'bandcamp.com':
                return 'bandcamp';
            case 'facebook.com':
                return 'facebook';
            case 'soundcloud.com':
                return 'soundcloud';
            case 'twitter.com':
                return 'twitter';
            case 'youtube.com':
            case 'youtu.be':
                return 'youtube';
            default:
                return null;
        }
    }
}
