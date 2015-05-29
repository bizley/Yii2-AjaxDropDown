<?php

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.2.1.2
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace bizley\ajaxdropdown\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the AjaxDropDown javascript files.
 */
class AjaxDropdownAsset extends AssetBundle
{

    public $sourcePath = '@vendor/bizley/ajaxdropdown/src/js';
    public $js         = ['AjaxDropdown.min.js'];
    public $depends    = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
