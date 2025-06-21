<?php namespace Depcore\YoutubeFeed\Models;

/**
 * YoutubeSettings model for managing plugin settings.
 *
 * This model is used to store and validate settings for the Youtube Feed plugin.
 *
 * @package Depcore\YoutubeFeed
 * @author Depcore
 */
class YoutubeSettings extends \System\Models\SettingModel
{
    public $settingsCode = 'depcore_youtubefeed_settings';

    public $settingsFields = 'fields.yaml';

}
