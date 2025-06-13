<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class YouTubeService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.googleapis.com/youtube/v3/',
        ]);
        $this->apiKey = config('services.youtube.key');
    }

    public function searchVideos($query, $maxResults = 5)
    {
        try {
            $response = $this->client->get('search', [
                'query' => [
                    'part' => 'snippet',
                    'q' => $query . ' kpop',
                    'type' => 'video',
                    'maxResults' => $maxResults,
                    'key' => $this->apiKey,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('YouTube API error: ' . $e->getMessage());
            return null;
        }
    }

    public function getVideoDetails($videoId)
    {
        try {
            $response = $this->client->get('videos', [
                'query' => [
                    'part' => 'snippet,contentDetails',
                    'id' => $videoId,
                    'key' => $this->apiKey,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('YouTube API error: ' . $e->getMessage());
            return null;
        }
    }
}