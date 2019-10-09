<?php

namespace Cyve\Url\Profile;

use Assert\Assertion;
use Cyve\Url\Url;

class YoutubeUrl extends Url
{
    const YOUTUBE_TYPE_VIDEO = 'youtube#video';
    const YOUTUBE_TYPE_PLAYLIST = 'youtube#playlist';
    const YOUTUBE_TYPE_CHANNEL = 'youtube#channel';
    const YOUTUBE_TYPE_USER = 'youtube#user';
    const YOUTUBE_TYPE_SEARCH_RESULT = 'youtube#searchResult';

    public $type = null;

    public function __construct(string $url)
    {
        parent::__construct($url);

        Assertion::choice($this->domain, ['youtube.com', 'youtu.be']);
    }

    public function getCanonicalUrl(): string
    {
        return $this->getInfos('canonicalUrl');
    }

    /**
     * @param string|null $key
     * @return array|string
     */
    public function getInfos(string $key = null)
    {
        // https://www.youtube.com/channel/UCpAyqgNZY--jEGmidNSDr8w
        if (strtolower($this->path[0]) === 'channel') {
            $kind = self::YOUTUBE_TYPE_CHANNEL;
            $id = $this->path[1];
            $canonicalUrl = 'https://www.youtube.com/channel/'.$id;
            $apiUri = 'channels?'.http_build_query(['id' => $id, 'part' => 'snippet,statistics']);
        }

        // https://www.youtube.com/watch?v=GN-_rbIV0jc
        elseif (strtolower($this->path[0]) === 'watch') {
            $kind = self::YOUTUBE_TYPE_VIDEO;
            $id = $this->query->get('v');
            $canonicalUrl = 'https://www.youtube.com/watch?v='.$id;
            $apiUri = 'videos?'.http_build_query(['id' => $id, 'part' => 'snippet,contentDetails']);
        }

        // https://www.youtube.com/embed/GN-_rbIV0jc
        elseif (strtolower($this->path[0]) === 'embed') {
            $kind = self::YOUTUBE_TYPE_VIDEO;
            $id = $this->path[1];
            $canonicalUrl = 'https://www.youtube.com/watch?v='.$id;
            $apiUri = 'videos?'.http_build_query(['id' => $id, 'part' => 'snippet,contentDetails']);
        }

        // https://youtu.be/GN-_rbIV0jc
        elseif (strtolower($this->domain) === 'youtu.be') {
            $kind = self::YOUTUBE_TYPE_VIDEO;
            $id = $this->path[0];
            $canonicalUrl = 'https://www.youtube.com/watch?v='.$id;
            $apiUri = 'videos?'.http_build_query(['id' => $id, 'part' => 'snippet,contentDetails']);
        }

        // https://www.youtube.com/playlist?list=UUpAyqgNZY--jEGmidNSDr8w
        elseif (strtolower($this->path[0]) === 'playlist') {
            $kind = self::YOUTUBE_TYPE_PLAYLIST;
            $id = $this->query->get('list');
            $canonicalUrl = 'https://www.youtube.com/playlist?list='.$id;
            $apiUri = 'playlists?'.http_build_query(['id' => $id, 'part' => 'snippet,contentDetails']);
        }

        // https://www.youtube.com/user/sonducoin
        elseif (strtolower($this->path[0]) === 'user') {
            $kind = self::YOUTUBE_TYPE_USER;
            $id = $this->path[1];
            $canonicalUrl = 'https://www.youtube.com/user/'.strtolower($id);
            $apiUri = '?'.http_build_query(['id' => $id, 'part' => 'snippet,statistics']);
        }

        // https://www.youtube.com/results?search_query=son%20du%20coin
        elseif (strtolower($this->path[0]) === 'results') {
            $kind = self::YOUTUBE_TYPE_SEARCH_RESULT;
            $id = null;
            $query = $this->query->get('search_query');
            $canonicalUrl = 'https://www.youtube.com/results?'.http_build_query(['search_query' => $query]);
            $apiUri = 'search?'.http_build_query(['q' => $query]);
        }

        // https://www.youtube.com/*
        else {
            $kind = null;
            $id = null;
            $canonicalUrl = 'https://www.youtube.com'.$this->path;
            $apiUri = null;
        }

        $infos = [
            'kind' => $kind,
            'id' => $id,
            'canonicalUrl' => $canonicalUrl,
            'apiUri' => $apiUri,
        ];

        if ($key) {
            return $infos[$key] ?? null;
        }

        return $infos;
    }
}
