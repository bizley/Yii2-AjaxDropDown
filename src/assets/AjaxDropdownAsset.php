<?php

namespace bizley\ajaxdropdown\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the AjaxDropDown javascript files.
 * @author Paweł Bizley Brzozowski
 * @version 1.3.2
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class AjaxDropdownAsset extends AssetBundle
{

    public $sourcePath = '@vendor/bizley/ajaxdropdown/src/js';
    public $depends    = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->js[] = 'AjaxDropdown' . (YII_DEBUG ? '' : '.min') . '.js';
        parent::init();
    }
}
