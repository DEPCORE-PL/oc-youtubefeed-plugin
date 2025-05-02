<?php namespace Depcore\YoutubeFeed\Components;

use Cms\Classes\ComponentBase;
use Depcore\YoutubeFeed\Models\YoutubeSettings;
use Madcoda\Youtube\Youtube;
use tpaySDK\Model\Identifiers\ChannelId;

/**
 * YoutubeFeed Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class YoutubeFeed extends ComponentBase
{
    public $items;
    public $nextPage;
    public $playlist;

    private Youtube $youtube;

    public function componentDetails()
    {
        return [
            'name' => 'Youtube Feed Component',
            'description' => 'Dynamically loads new items when pushing view more button'
        ];
    }

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
    public function onRun()
    {
        $this->youtube = new Youtube(array('key' => YoutubeSettings::get("api_key")));

    }
    public function onRender()
    {
        $playlist = $this->loadItems();
        $this->items = $playlist["results"];
        $this->nextPage = $playlist['info']['nextPageToken'];
        $this->page["playlist"] = $this->property('feedPlaylist');
    }

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
