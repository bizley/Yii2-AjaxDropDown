<?php

use yii\helpers\Html;

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.3.3
 * @license http://opensource.org/licenses/BSD-3-Clause
 *
 * @var array $htmlOptionsResult
 * @var string $removeLabel
 * @var array $htmlOptionsRemove
 * @var mixed $additional
 * @var string $id
 * @var string $value
 * @var string $additionalCode
 * @var bool $mark
 * @var string $markBegin
 * @var bool $markEnd
 * @var \yii\base\Model $model
 * @var string $attribute
 * @var string $arrayMode
 * @var string $name
 */

echo Html::beginTag('li', $htmlOptionsResult) . "\n";
echo Html::a($removeLabel, '#', $htmlOptionsRemove);
if ($additional !== false && !empty($additional)) {
    echo str_replace('{ID}', $id, str_replace('{VALUE}', $value, $additional));
} elseif (!empty($additionalCode)) {
    echo str_replace('{ID}', $id, str_replace('{VALUE}', $value, $additionalCode));
}
echo $mark ? $markBegin : '';
echo $value;
echo $mark ? $markEnd : '';
if (!empty($model)) {
    echo Html::activeHiddenInput($model, $attribute . $arrayMode, ['value' => $id, 'id' => false]);
} else {
    echo Html::hiddenInput($name . $arrayMode, $id, ['id' => false]);
}
echo Html::endTag('li') . "\n";
