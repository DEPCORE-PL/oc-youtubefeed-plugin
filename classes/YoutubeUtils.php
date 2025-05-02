<?php

namespace Depcore\YoutubeFeed\Classes;

use Madcoda\Youtube\Youtube;

class YoutubeUtils
{
    public static function getChannelApiCallFromUrl($url)
    {
        // Direct /channel/UCxxxxx — no API needed
        if (preg_match('/youtube\.com\/channel\/(UC[\w-]+)/', $url, $matches)) {
            return [
                'type' => 'direct',
                'channelId' => $matches[1]
            ];
        }

        // Match /user/, /c/, or /@handle
        if (preg_match('/youtube\.com\/(?:user|c|@)([^\/\?\&]+)/', $url, $matches)) {
            $identifier = $matches[1];

            // If it's /user/, use channels endpoint
            if (strpos($url, '/user/') !== false) {
                return [
                    'endpoint' => 'https://www.googleapis.com/youtube/v3/channels',
                    'params' => [
                        'part' => 'id',
                        'forUsername' => $identifier
                    ]
                ];
            }

            // If it's /c/ or /@, use search endpoint
            return [
                'endpoint' => 'https://www.googleapis.com/youtube/v3/search',
                'params' => [
                    'part' => 'snippet',
                    'type' => 'channel',
                    'q' => $identifier,
                    'maxResults' => 1
                ]
            ];
        }

        return null; // Invalid or unsupported URL format
    }

    public static function getChannelIDFromLink(Youtube $youtube, string $url){
        $info = self::getChannelApiCallFromUrl($url);
        if (isset($info['type']) && $info['type'] === 'direct') {
            $channelId = $info['channelId'];
        } else {
            $response = $youtube->api_get($info['endpoint'], $info['params']);
            $data = json_decode($response, true);

            if (isset($data['items'][0]['snippet']['channelId'])) {
                $channelId = $data['items'][0]['snippet']['channelId'];
            } elseif (isset($data['items'][0]['id'])) {
                $channelId = $data['items'][0]['id'];
            } else {
                $channelId = null;
            }
        }

        return $channelId ?? 'Channel ID not found';
    }
    public static function getUploadPlaylistId(Youtube $youtube, string $channelId){
        return $youtube->getChannelById($channelId)->contentDetails->relatedPlaylists->uploads;

    }
}
