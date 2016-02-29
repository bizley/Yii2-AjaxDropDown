<?php

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.3.2
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

use yii\helpers\Html;

echo Html::beginTag('li', $htmlOptionsResult) . "\n";
    echo Html::a($removeLabel, '#', $htmlOptionsRemove);
if ($additional !== false && !empty($additional)):
    echo str_replace('{ID}', $id, str_replace('{VALUE}', $value, $additional));
elseif (!empty($additionalCode)):
    echo str_replace('{ID}', $id, str_replace('{VALUE}', $value, $additionalCode));
endif;
    echo $mark ? $markBegin : '';
        echo $value;
    echo $mark ? $markEnd : '';
if (!empty($model)):
    echo Html::activeHiddenInput($model, $attribute . $arrayMode, ['value' => $id, 'id' => false]);
else:
    echo Html::hiddenInput($name . $arrayMode, $id, ['id' => false]);
endif;
echo Html::endTag('li') . "\n";
