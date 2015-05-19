<?php
namespace thiagoaugustus\weekypicker;

use yii\web\AssetBundle;

class WeekyPickerwidgetAssets extends AssetBundle {

    public $sourcePath = '@vendor/thiagoaugustus/weekypicker/src/assets/';

    public $css = [
        'css/weekypicker.css'
    ];

    public $js = [
        'js/weekypicker.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}