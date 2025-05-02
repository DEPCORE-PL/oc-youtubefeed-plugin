<?php namespace Depcore\YoutubeFeed;

use Backend;
use Depcore\YoutubeFeed\Classes\YoutubeUtils;
use Depcore\YoutubeFeed\Components\YoutubeFeed;
use Depcore\YoutubeFeed\Models\YoutubeSettings;
use Madcoda\Youtube\Youtube;
use System\Classes\PluginBase;
use System\Controllers\Settings;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'YoutubeFeed',
            'description' => 'No description provided yet...',
            'author' => 'Depcore',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
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
