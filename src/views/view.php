<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

use yii\helpers\Html;
use yii\bootstrap4\Modal;

/**
 * @var $this \yii\web\View
 * @var $imageId string
 * @var $imageUrl string
 * @var $cropperOptions array
 * @var $modalId string
 */

$img_src = '/img/demo/profile.jpg';
$img_src = '#';


?>
    <div class="cropper-wrapper clearfix">
        <div class="cropper-preview">
            <div class="cropper-preview-img">
                <?= Html::img(
                    $imageUrl,
                    [
                        'width' => $cropperOptions['preview']['width'],
                        'height' => $cropperOptions['preview']['height'],
                        'alt' => 'cropper image preview'
                    ]
                ) ?>
            </div>
            <div class="cropper-preview-buttons">
                <?php
                echo Html::button(
                    'Change',
                    [
                        'class' => 'btn btn-primary',
                        'type' => 'button',
                        'data-toggle' => 'modal',
                        'data-target' => $modalId
                    ]
                );
                ?>
            </div>
        </div>
    </div>
<?php
Modal::begin([
    'id'     => $modalId,
    'class'  => 'modal fade',
    'title' => 'Cropping the Image',
    'footer' => 'Низ окна',
    'size' => Modal::SIZE_LARGE
]);

//
?>
    <input type="file" name="image" id="image" />
    <div class="image_container">
        <img id="blah" src="#" alt="your image" />
    </div>
    <div id="cropped_result"></div>        // Cropped image to display (only if u want)
    <button id="crop_button">Crop</button> // Will trigger crop event
<?php

Modal::end();

/* passing variables to JS */
$passVariables = <<<JS
const sabirovCropperImageId = '#'+'$imageId';
JS;
Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
