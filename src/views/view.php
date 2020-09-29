<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \yii\db\ActiveRecord
 * @var $attribute string
 * @var $imageId string
 * @var $previewImageUrl string
 * @var $extensionOptions array
 * @var $modalId string
 * @var $inputImageId string id of image input field
 * @var $cropperOptions string json options for cropperjs
 * @var $cropButtonId string id of Crop button
 * @var $previewImageId string
 * @var $thisId string
 */

echo Html::activeHiddenInput($model, $attribute);
?>
    <div class="cropper-wrapper clearfix">
        <div class="cropper-preview">
            <div class="cropper-preview-img">
                <?= Html::img(
                    $previewImageUrl,
                    [
                        'id' => $previewImageId,
                        'width' => $extensionOptions['preview']['width'],
                        'height' => $extensionOptions['preview']['height'],
                        'alt' => 'cropper image preview'
                    ]
                ) ?>
            </div>
            <div class="cropper-preview-picture d-none">
                <?php
                echo Html::tag(
                    'div',
                    Html::img('#', [
                        'id' => $imageId,
                        'class' => 'sabirov-cropper-image',
                        'alt' => 'Upload a picture',
                    ])
                );

                echo Html::tag(
                    'div',
                    $extensionOptions['cropperWarningText'],
                    [
                        'class' => 'alert alert-warning cropper-warning'
                    ]
                );
                ?>
            </div>
            <div class="cropper-preview-buttons">
                <div class="input-group cropper-browse-group">
                    <span class="input-group-btn cropper-input-group-btn">
                        <label for="<?= $inputImageId ?>" class="btn btn-primary btn-file">
                            <?= $extensionOptions['browseButtonText'] ?>
                        </label>
                        <input type="file" id="<?= $inputImageId ?>" class="d-none">
                        <input type="hidden" name="LawyersPhoto[crop_info]" value="" id="LawyersPhoto__crop_info">
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php

/* add java script */
$js = <<<JS
(function ($) {
    let cropper;
    const cropperOptions = '$cropperOptions';
    const cropperOptionsObj = JSON.parse(cropperOptions);
    const inputImageId = '#'+'$inputImageId';
    const modalId = '#' + '$modalId';
    const imageId = '#'+'$imageId';
    const cropButtonId = '#'+'$cropButtonId';
    const previewImageId = '#' + '$previewImageId';
    const thisId = '#'+'$thisId';

    $(inputImageId).on('change', function () {
        readURL(this);
    });

    $(modalId).on("hidden.bs.modal", function () {
        if (typeof (cropper) !== 'undefined') {
            cropper.destroy();
        }

        $(imageId).attr('src', null);
        $('.cropper-warning').hide();
    });

    const readURL = function (input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (event) {
                $(imageId).attr('src', event.target.result);
                initCropper();
            };

            reader.readAsDataURL(input.files[0]);
        }
    };

    const initCropper = function () {
        if (typeof (cropper) !== 'undefined') {
            cropper.destroy();
        }

        const image = $(imageId)[0];

        /* initialize Cropper */
        cropper = new Cropper(
            image,
            cropperOptionsObj
        );

        $('.cropper-warning').show();
        $('.cropper-preview-picture').removeClass('d-none');
        $('.cropper-preview-img').addClass('d-none');

        /* perform crop for submiting form */
        window.lawyerCroperFinish = function () {
            const imgUrl = cropper.getCroppedCanvas().toDataURL();
            $(previewImageId).attr('src', imgUrl);
            $('input#LawyersPhoto__crop_info').val(JSON.stringify(cropper.getData()));

            cropper.getCroppedCanvas().toBlob((blob) => {
                let reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    const base64data = reader.result;
                    $(thisId).val(base64data);
                }
            });
        };
    }
})(jQuery);
JS;

Yii::$app->view->registerJs($js, $this::POS_LOAD, 'sabirov-cropper-' . $thisId);
