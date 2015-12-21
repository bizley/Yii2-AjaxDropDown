<?php

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.3.1
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

use yii\helpers\Html;

?>

<?= Html::beginTag('div', $htmlOptionsMain) . "\n"; ?>
    <?= Html::beginTag('div', $htmlOptionsGroup) . "\n"; ?>
        <?= Html::textInput(
                !empty($defaults['inputName']) ? $defaults['inputName'] : '', 
                $singleMode ? (!empty($data[0]['value']) ? str_replace('"', '', strip_tags($data[0]['value'])) : '') : '', 
                $htmlOptionsInput
            ) . "\n"; ?>
<?php if ($singleMode): ?>
<?php if (!empty($model)): ?>
        <?= Html::activeHiddenInput(
                $model, 
                $attribute, 
                [
                    'value' => !empty($data[0]['id']) ? $data[0]['id'] : '', 
                    'id'    => false, 
                    'class' => 'singleResult'
                ]
            ) . "\n"; ?>
<?php else: ?>
        <?= Html::hiddenInput(
                $name, 
                !empty($data[0]['id']) ? $data[0]['id'] : '', 
                [
                    'id'    => false, 
                    'class' => 'singleResult'
                ]
            ) . "\n"; ?>
<?php endif; ?>
<?php endif; ?>
        <?= Html::beginTag('div', $htmlOptionsButtons) . "\n"; ?>
<?php if (!empty($extraButtonLabel) || !empty($extraButtonOptions)): ?>
            <?= Html::button(is_string($extraButtonLabel) ? $extraButtonLabel : '', $htmlOptionsExtraButton) . "\n"; ?>
<?php endif; ?>
            <?= Html::button($buttonLabel, $htmlOptionsButton) . "\n"; ?>
            <?= Html::button($removeSingleLabel, $htmlOptionsRemoveSingle) . "\n"; ?>
            <?= Html::tag('ul', '', $htmlOptionsResults) . "\n"; ?>
        <?= Html::endTag('div') . "\n"; ?>
    <?= Html::endTag('div') . "\n"; ?>
    <?= Html::beginTag('ul', $htmlOptionsSelected) . "\n"; ?>
<?php foreach ($results as $result): ?>
        <?= $this->render('result', $result); ?>
<?php endforeach; ?>
    <?= Html::endTag('ul') . "\n"; ?>
<?= Html::endTag('div') . "\n"; ?>

