<?php

namespace Depcore\YoutubeFeed\Classes;

use Madcoda\Youtube\Youtube;

/**
 * Utility class for handling YouTube-related operations within the plugin.
 *
 * This class provides static methods and helpers for interacting with the YouTube API,
 * processing YouTube data, and supporting YouTube feed functionality.
 * @package Depcore\YoutubeFeed\Classes
 * @author Depcore
 */
class YoutubeUtils
{
    /**
     * Extracts the YouTube channel API call information from a given YouTube channel URL.
     *
     * @param string $url The URL of the YouTube channel.
     * @return array|null Returns an array containing API call parameters if extraction is successful, or null on failure.
     */
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

    /**
     * Extracts the YouTube channel ID from a given YouTube channel URL.
     *
     * @param Youtube $youtube An instance of the Youtube API client or utility class.
     * @param string $url The URL of the YouTube channel.
     * @return string|null The extracted channel ID if found, or null on failure.
     */
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

    /**
     * Retrieves the upload playlist ID for a given YouTube channel.
     *
     * @param Youtube $youtube   An instance of the Youtube API client.
     * @param string  $channelId The ID of the YouTube channel.
     * @return string|null       The upload playlist ID if found, or null on failure.
     */
    public static function getUploadPlaylistId(Youtube $youtube, string $channelId){
        return $youtube->getChannelById($channelId)->contentDetails->relatedPlaylists->uploads;

    }
}
