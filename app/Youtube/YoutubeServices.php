<?php

namespace App\Youtube;

use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeServices
{
    private $key = null;
    public function __construct(string $key)
    {
        $this->key = $key;
    }
    public function handleYoutubeVideoDuration(string $video_url): int
    {
        preg_match('/embed\/(.+)/', $video_url, $matches);
        $id = $matches[1];
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key={$this->key}&id={$id}&part=ContentDetails");
        $duration = json_decode($response)->items[0]->contentDetails->duration;
        $duration = new DateInterval($duration);
        return $duration->i * 60 + $duration->s + $duration->h * 60 * 60;
    }
}
