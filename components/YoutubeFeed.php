<?php namespace Depcore\YoutubeFeed\Components;

use Cms\Classes\ComponentBase;
use Depcore\YoutubeFeed\Models\YoutubeSettings;
use Madcoda\Youtube\Youtube;

/**
 * YoutubeFeed component for the Youtube Feed plugin.
 *
 * This is the main frontend component responsible for displaying a dynamic YouTube playlist feed
 * with pagination support in OctoberCMS. It loads videos from a specified YouTube playlist (typically
 * an uploads playlist) and provides a "View More" button to fetch additional items via AJAX.
 *
 * Features:
 * - Fetches and displays videos from a YouTube playlist using the YouTube Data API v3.
 * - Supports configurable number of items per page.
 * - Handles AJAX-based pagination for seamless loading of more videos.
 * - Integrates with plugin settings for API key management.
 *
 * Component Properties:
 * @property string $feedPlaylist  The YouTube playlist ID to display videos from (e.g., uploads playlist ID).
 * @property int    $perPage       Number of videos to display per page (default: 5).
 *
 * Public Properties:
 * @property array  $items         The list of video items currently loaded.
 * @property string $nextPage      The nextPageToken for YouTube API pagination.
 * @property string $playlist      The current playlist ID in use.
 *
 * Usage Example (in CMS page/layout):
 *   {% component 'youtubeFeed' feedPlaylist="UUH7xZRbt0N_ChUvud2Vr2sA" perPage=5 %}
 *
 * @see https://github.com/madcoda/php-youtube-api for YouTube API integration
 * @see Depcore\YoutubeFeed\Models\YoutubeSettings for API key configuration
 *
 * @package Depcore\YoutubeFeed
 * @author  Depcore
 */
class YoutubeFeed extends ComponentBase
{
    public $items;
    public $nextPage;
    public $playlist;

    private Youtube $youtube;

    /**
     * Returns details about the component, such as its name and description.
     *
     * @return array An associative array containing the component's name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Youtube Feed Component',
            'description' => 'Dynamically loads new items when pushing view more button'
        ];
    }

    /**
     * Defines the properties available for the YoutubeFeed component.
     *
     * This method should return an array of property definitions that can be configured
     * in the backend for this component. Each property can include options such as
     * title, description, type, default value, and validation rules.
     *
     * @return array The array of property definitions for the component.
     */
    public function defineProperties()
    {
        return [
            'feedPlaylist' => [
                'title' => 'Channel feed Playlist ID',
                'type' => 'string',
                'required' => true,
            ],
            'perPage' => [
                'title' => 'Items per page',
                'default' => 5,
                'type' => "number",
            ]
        ];
    }
    /**
     * Handles the component's execution when the page is run.
     * This method is automatically called by the OctoberCMS framework
     * when the component is initialized during the page lifecycle.
     *
     * Use this method to prepare variables, fetch data, or perform
     * any setup required before rendering the component's output.
     *
     * @return void
     */
    public function onRun()
    {
        $this->youtube = new Youtube(array('key' => YoutubeSettings::get("api_key")));

    }
    /**
     * Handles the rendering process for the YoutubeFeed component.
     *
     * This method is triggered when the component needs to be rendered.
     * It can be used to prepare data, set variables, or perform any logic
     * required before displaying the component's output.
     *
     * @return void
     */
    public function onRender()
    {
        $playlist = $this->loadItems();
        $this->items = $playlist["results"];
        $this->nextPage = $playlist['info']['nextPageToken'];
        $this->page["playlist"] = $this->property('feedPlaylist');
    }

    /**
     * Handles the AJAX request to load more YouTube feed items.
     *
     * This method is typically triggered when the user requests additional content,
     * such as clicking a "Load More" button. It processes the request, retrieves
     * the next set of YouTube feed items, and returns them for rendering.
     *
     * @return mixed The response containing additional YouTube feed items.
     */
    public function onLoadMore()
    {
        $this->onRun();

        $page = input('page');
        $playlistId = input('playlist');
        debug($page, $playlistId);
        $params = array(
            'playlistId' => $playlistId,
            'part' => 'id, snippet, contentDetails, status',
            'maxResults' => $this->property("perPage"),
            'pageToken' => $page
        );
        $playlist = $this->youtube->getPlaylistItemsByPlaylistIdAdvanced($params, true);
        $this->page['nextPage'] = $playlist['info']['nextPageToken'];
        $this->page['items'] = $playlist['results'];
        return [
            '#view-more-wrapper' => $this->page['nextPage'] != null
                ? $this->renderPartial('@view_more', ['nextPage' => $this->page['nextPage'], 'playlist' => $playlistId])
                : ''
        ];
    }

    /**
     * Loads items for the YouTube feed component.
     *
     * This method retrieves and processes YouTube feed items to be displayed
     * by the component. The specific implementation details depend on the
     * requirements of the component and the data source.
     *
     * @return void
     */
    protected function loadItems()
    {
        $params = array(
            'playlistId' => $this->property('feedPlaylist'),
            'part' => 'id, snippet, contentDetails, status',
            'maxResults' => $this->property("perPage")
        );
        return $this->youtube->getPlaylistItemsByPlaylistIdAdvanced($params, true);
    }

}
