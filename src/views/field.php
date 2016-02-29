<?php

/**
 * @author Paweł Bizley Brzozowski
 * @version 1.3.2
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

use yii\helpers\Html;

echo Html::beginTag('div', $htmlOptionsMain) . "\n";
    echo Html::beginTag('div', $htmlOptionsGroup) . "\n";
        echo Html::textInput(
                !empty($defaults['inputName']) ? $defaults['inputName'] : '', 
                $singleMode ? (!empty($data[0]['value']) ? str_replace('"', '', strip_tags($data[0]['value'])) : '') : '', 
                $htmlOptionsInput
            ) . "\n";
if ($singleMode):
if (!empty($model)):
        echo Html::activeHiddenInput(
                $model, 
                $attribute, 
                [
                    'value' => !empty($data[0]['id']) ? $data[0]['id'] : '', 
                    'id'    => false, 
                    'class' => 'singleResult'
                ]
            ) . "\n";
else:
        echo Html::hiddenInput(
                $name, 
                !empty($data[0]['id']) ? $data[0]['id'] : '', 
                [
                    'id'    => false, 
                    'class' => 'singleResult'
                ]
            ) . "\n";
endif;
endif;
        echo Html::beginTag('div', $htmlOptionsButtons) . "\n";
if (!empty($extraButtonLabel) || !empty($extraButtonOptions)):
            echo Html::button(is_string($extraButtonLabel) ? $extraButtonLabel : '', $htmlOptionsExtraButton) . "\n";
endif;
            echo Html::button($buttonLabel, $htmlOptionsButton) . "\n";
            echo Html::button($removeSingleLabel, $htmlOptionsRemoveSingle) . "\n";
            echo Html::tag('ul', '', $htmlOptionsResults) . "\n";
        echo Html::endTag('div') . "\n";
    echo Html::endTag('div') . "\n";
    echo Html::beginTag('ul', $htmlOptionsSelected) . "\n";
foreach ($results as $result):
        echo $this->render('result', $result);
endforeach;
    echo Html::endTag('ul') . "\n";
echo Html::endTag('div') . "\n";
