<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

namespace dmbozhok\cropper;

use yii\web\AssetBundle;

class InitCropperAsset extends AssetBundle
{
    public $sourcePath = '@vendor/dmbozhok/yii2-bootstrap4-cropper/src/assets/';
    public $css = [
        'css/cropper.css'
    ];
    public $js = [];
    public $depends = [
        'dmbozhok\cropper\CropperAsset',
        'yii\web\JqueryAsset'
    ];
}
