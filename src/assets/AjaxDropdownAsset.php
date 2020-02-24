<?php

namespace bizley\ajaxdropdown\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the AjaxDropDown JavaScript files.
 */
class AjaxDropdownAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bizley/ajaxdropdown/src/js';
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->js[] = 'AjaxDropdown' . (YII_DEBUG ? '' : '.min') . '.js';
        parent::init();
    }
}
