<?php namespace Depcore\YoutubeFeed;

use Depcore\YoutubeFeed\Classes\YoutubeUtils;
use Depcore\YoutubeFeed\Components\YoutubeFeed;
use Depcore\YoutubeFeed\Models\YoutubeSettings;
use Madcoda\Youtube\Youtube;
use System\Classes\PluginBase;
use System\Controllers\Settings;

/**
 * Plugin for displaying a Youtube videos feed from multiple sources.
 *
 * @package Depcore\YoutubeFeed
 * @author Depcore
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Youtube Feed',
            'description' => 'A plugin to display a Youtube videos feed from multiple sources.',
            'author' => 'Depcore',
            'icon' => 'icon-play'
        ];
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {

        // add youtube feed tools to the settings controller
        Settings::extend(function($controller) {
            $controller->addDynamicMethod('onGetChannelPlaylist', function() use ($controller) {
                /*
                 *  pull the posted value named "input"…
                 */
                $input = post('channelLink');

                /*
                 *  do something stateless with it…
                 */
                $youtube = new Youtube(array('key' => YoutubeSettings::get("api_key")));
                $channel = YoutubeUtils::getChannelIDFromLink($youtube, $input);
                $playlist = YoutubeUtils::getUploadPlaylistId($youtube, $channel);

                /*
                 *  return an array mapping a CSS selector to new HTML.
                 */
                return [
                    '#stringOutput' => '<p>' . e($playlist) . '</p>'
                ];
            });
        });
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            YoutubeFeed::class => 'youtubeFeed',
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Youtube Feed Settings',
                'description' => 'Manage Youtube Feed settings.',
                'category' => 'CATEGORY_CMS',
                'icon' => 'icon-play',
                'class' => YoutubeSettings::class,
            ]
        ];
    }


}
