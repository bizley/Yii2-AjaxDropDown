<?php

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.3.1
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

use yii\helpers\Html;

?>
<?= Html::beginTag('li', $htmlOptionsResult) . "\n"; ?>
    <?= Html::a($removeLabel, '#', $htmlOptionsRemove); ?>
<?php if ($additional !== false && !empty($additional)): ?>
    <?= str_replace('{ID}', $id, str_replace('{VALUE}', $value, $additional)); ?>
<?php elseif (!empty($additionalCode)): ?>
    <?= str_replace('{ID}', $id, str_replace('{VALUE}', $value, $additionalCode)); ?>
<?php endif; ?>
<?php if ($mark): ?><?= $markBegin; ?><?php endif; ?>
        <?= $value; ?>
<?php if ($mark): ?><?= $markEnd; ?><?php endif; ?>
<?php if (!empty($model)): ?>
    <?= Html::activeHiddenInput($model, $attribute . $arrayMode, ['value' => $id, 'id' => false]); ?>
<?php else: ?>
    <?= Html::hiddenInput($name . $arrayMode, $id, ['id' => false]); ?>
<?php endif; ?>
<?= Html::endTag('li') . "\n"; ?>
