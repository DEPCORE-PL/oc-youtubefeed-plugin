<?php namespace Depcore\YoutubeFeed\Models;

use Model;

/**
 * YoutubeSettings Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class YoutubeSettings extends \System\Models\SettingModel
{
    use \October\Rain\Database\Traits\Validation;

    public $settingsCode = 'depcore_youtubefeed_settings';

    public $settingsFields = 'fields.yaml';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
