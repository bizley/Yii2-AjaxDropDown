<?php

/**
 * @author Paweł Bizley Brzozowski
 * @version 0.1-alpha
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace bizley\ajaxdropdown;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * AjaxDropDown is the Yii2 widget for rendering the dropdown menu with the AJAX
 * data source.
 * @see https://github.com/bizley-code/Yii2-AjaxDropDown
 * @see http://www.yiiframework.com/extension/yii2-ajaxdropdown
 *
 * See README file for configuration and usage examples.
 *
 * AjaxDropDown requires Yii version 2.0.
 * @see http://www.yiiframework.com
 * @see https://github.com/yiisoft/yii2
 *
 * If you look for the Yii 1.1 version of this widget
 * @see https://github.com/bizley-code/Yii-AjaxDropDown
*/
class AjaxDropdown extends Widget
{

    /**
     * @var string Additional HTML code for the selected value row, default ''.
     * Any 'additional' key in 'data' parameter element will replace this.
     * You can use {VALUE} and {ID} tags here to be automatically replaced with 
     * selected id and value of the row.
     * @see $data
     */
    public $additionalCode = '';

    /**
     * @var string The attribute associated with this widget.
     * The square brackets ('[]') are added automatically to collect tabular 
     * data input when singleMode parameter is set to false (default).
     */
    public $attribute;

    /**
     * @var string CSS class of the button triggering the dropdown in addition 
     * to 'ajaxDropDownToggle btn dropdown-toggle btn-default'. 
     */
    public $buttonClass;

    /**
     * @var string HTML label of the button triggering the dropdown, 
     * default '<span class="caret"></span>'.
     */
    public $buttonLabel;

    /**
     * @var string Additional CSS style of the button triggering the dropdown.
     */
    public $buttonStyle;

    /**
     * @var string CSS class of the div container for the buttons and dropdown 
     * menu in addition to 'input-group-btn'.
     */
    public $buttonsClass;

    /**
     * @var string Additional CSS style of the div container for the buttons 
     * and dropdown menu.
     */
    public $buttonsStyle;

    /**
     * @var array Array of preselected values arrays.
     * Every value array should be given with the three array keys:
     * 'id'    => identification string for the value i.e. database ID number,
     * 'mark'  => 0|1 flag for the emphasis of the value
     * 'value' => string displayed as the value itself.
     * If empty 'id' is set to uniqid().
     * If not 0 and not 1 'mark' is set to 0.
     * If empty 'value' is set to 'error: missing value key in data array'.
     * There is the optional parameter 'additional' with HTML code to be 
     * inserted in the selected row. If given this replaces 'additionalCode' 
     * for that row only. In case you want to remove the 'additionalCode' only 
     * for that row set the 'additional' key to false.
     */
    public $data;

    /**
     * @var boolean Wheter to add Bootstrap class 'dropup' to trigger dropdown 
     * menu above the button, default false.
     */
    public $dropup = false;

    /**
     * @var string CSS class of the result element displayed when AJAX failed 
     * to return data in addition to 'dropdown-header list-group-item-danger'.
     */
    public $errorClass;

    /**
     * @var string Additional CSS style of the result element displayed when 
     * AJAX failed to return data.
     */
    public $errorStyle;

    /**
     * @var array HTML options of the extra button between input text field and 
     * triggering button, default [].
     * @see $options in Html::button
     */
    public $extraButtonOptions = [];

    /**
     * @var string HTML label for the extra button between input text field and 
     * triggering button, default ''.
     */
    public $extraButtonLabel = '';

    /**
     * @var string CSS class of the div container for the input text field and 
     * div with buttons and dropdown menu in addition to 
     * 'ajaxDropDown input-group'.
     */
    public $groupClass;

    /**
     * @var string Additional CSS style of the div container for the input text 
     * field and div with buttons and dropdown menu.
     */
    public $groupStyle;

    /**
     * @var string CSS class of the results header element in addition to 
     * 'dropdown-header'.
     */
    public $headerClass;

    /**
     * @var string Additional CSS style of the results header element.
     */
    public $headerStyle;

    /**
     * @var string CSS class of the hidden element on the results list.
     * Bootstrap default is 'hidden'.
     */
    public $hiddenClass;

    /**
     * @var string CSS class of the input text field in addition to 
     * 'form-control'.
     */
    public $inputClass;

    /**
     * @var string Additional CSS style of the input text field.
     */
    public $inputStyle;

    /**
     * @var string CSS class of the loading element on the results list in 
     * addition to 'ajaxDropDownLoading'.
     */
    public $loadingClass;

    /**
     * @var string Additional CSS style of the loading element on the results 
     * list.
     */
    public $loadingStyle;

    /**
     * @var array Array of translated strings used in widgets, default [].
     * @see $defaultLocal List of all default English strings.
     */
    public $local = [];

    /**
     * @var string CSS class of the main div container of the widget in 
     * addition to 'ajaxDropDownWidget'.
     */
    public $mainClass;

    /**
     * @var string Additional CSS style of the main div container of the widget.
     */
    public $mainStyle;

    /**
     * @var string HTML string of the beginning of the emphasised value on the 
     * results and preselected list, default '<em>'.
     */
    public $markBegin;

    /**
     * @var string HTML string of the ending of the emphasised value on the 
     * results and preselected list, default '</em>'.
     */
    public $markEnd;

    /**
     * @var integer Number of characters in the input text field required to 
     * send AJAX query, default 0.
     */
    public $minQuery = 0;

    /**
     * @var CModel Data model associated with this widget.
     */
    public $model;

    /**
     * @var string Widget name. This must be set if $model is not set.
     */
    public $name;

    /**
     * @var string HTML string of the beginning of the 'next' link on the 
     * results list, default '<small>'.
     */
    public $nextBegin;

    /**
     * @var string CSS class of the 'next' link on the results list in 
     * addition to 'ajaxDropDownNext pull-right btn'.
     */
    public $nextClass;

    /**
     * @var string HTML string of the ending of the 'next' link on the 
     * results list, default ' <span class="glyphicon glyphicon-chevron-right"></span></small>'.
     */
    public $nextEnd;

    /**
     * @var string Additional CSS style of the 'next' link on the results list 
     * in addition to 'clear:none;'.
     */
    public $nextStyle;

    /**
     * @var string CSS class of the result element displayed when AJAX returns 
     * no matching records in addition to 'dropdown-header'.
     */
    public $noRecordsClass;

    /**
     * @var string Additional CSS style of the result element displayed when 
     * AJAX returns no matching records.
     */
    public $noRecordsStyle;

    /**
     * @var string HTML string of the beginning of the actual page / total 
     * pages indicator, default '<span class="badge pull-right">'.
     */
    public $pagerBegin;

    /**
     * @var string HTML string of the ending of the actual page / total 
     * pages indicator, default '</span>'.
     */
    public $pagerEnd;

    /**
     * @var string HTML string of the beginning of the 'previous' link on the 
     * results list, default 
     * '<small><span class="glyphicon glyphicon-chevron-left"></span> '.
     */
    public $previousBegin;

    /**
     * @var string CSS class of the 'previous' link on the results list in 
     * addition to 'ajaxDropDownPrev pull-left btn'.
     */
    public $previousClass;

    /**
     * @var string HTML string of the ending of the 'previous' link on the 
     * results list, default '</small>'.
     */
    public $previousEnd;

    /**
     * @var string Additional CSS style of the 'previous' link on the results 
     * list in addition to 'clear:none;'.
     */
    public $previousStyle;

    /**
     * @var string HTML string of the loading results indicator, default 
     * '<div class="progress" style="width:90%;margin:0 auto"><div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width:100%">{LOADING}</div></div>'.
     */
    public $progressBar;

    /**
     * @var string CSS class of the result value element on the results list in 
     * addition to 'ajaxDropDownPages'.
     */
    public $recordClass;

    /**
     * @var string Additional CSS class of the result value element on the 
     * results list.
     */
    public $recordStyle;

    /**
     * @var string CSS class of the link removing value from preselected list 
     * in addition to 'ajaxDropDownRemove text-danger pull-right'.
     */
    public $removeClass;

    /**
     * @var string HTML label of the link removing value from preselected list, 
     * default '<span class="glyphicon glyphicon-remove"></span>'.
     */
    public $removeLabel;

    /**
     * @var string Additional CSS style of the link removing value from 
     * preselected list.
     */
    public $removeStyle;

    /**
     * @var string CSS class of the preselected data element in addition to 
     * 'list-group-item'.
     */
    public $resultClass;

    /**
     * @var string Additional CSS style of the preselected data element.
     */
    public $resultStyle;

    /**
     * @var string CSS class of the dropdown menu with AJAX records in addition 
     * to 'ajaxDropDownMenu dropdown-menu'.
     */
    public $resultsClass;

    /**
     * @var string Additional CSS style of the dropdown menu with AJAX records 
     * in addition to 'min-width:250px;'.
     */
    public $resultsStyle;

    /**
     * @var string CSS class of the div container for the preselected data in 
     * addition to 'ajaxDropDownResults list-group'.
     */
    public $selectedClass;

    /**
     * @var string Assitional CSS style of the div container for the 
     * preselected data.
     */
    public $selectedStyle;

    /**
     * @var boolean Wheter to set widget in mode that allows only one selected 
     * value or more, default false.
     */
    public $singleMode = false;

    /**
     * @var mixed URL of the AJAX source of records. It can be string or array.
     */
    public $source;

    /**
     * @var string CSS class of the result value element holding the 'next' and 
     * 'previous' links.
     */
    public $switchClass;

    /**
     * @var string Additional CSS style of the result value element holding the 
     * 'next' and 'previous' links.
     */
    public $switchStyle;

    /**
     * @var string Name of the translate category, default 'app'.
     * @see BaseYii::t
     */
    public $translateCategory = 'app';

    /**
     * @var array Default Bootstrap classes and labels for the widget.
     */
    protected $bootstrapDefaults = [
        'buttonClass'   => ' btn dropdown-toggle btn-default',
        'buttonLabel'   => '<span class="caret"></span>',
        'buttonsClass'  => 'input-group-btn',
        'errorClass'    => 'list-group-item-danger',
        'groupClass'    => ' input-group',
        'inputClass'    => 'form-control',
        'markBegin'     => '<em>',
        'markEnd'       => '</em>',
        'nextBegin'     => '<small>',
        'nextClass'     => 'pull-right btn',
        'nextEnd'       => ' <span class="glyphicon glyphicon-chevron-right"></span></small>',
        'nextStyle'     => 'clear:none;',
        'pagerBegin'    => '<span class="badge pull-right">',
        'pagerEnd'      => '</span>',
        'previousBegin' => '<small><span class="glyphicon glyphicon-chevron-left"></span> ',
        'previousClass' => 'pull-left btn',
        'previousEnd'   => '</small>',
        'previousStyle' => 'clear:none;',
        'progressBar'   => '<div class="progress" style="width:90%;margin:0 auto"><div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width:100%">{LOADING}</div></div>',
        'removeClass'   => ' text-danger pull-right',
        'removeLabel'   => '<span class="glyphicon glyphicon-remove"></span>',
        'resultClass'   => ' list-group-item',
        'resultsClass'  => ' dropdown-menu',
        'resultsStyle'  => 'min-width:250px;',
        'selectedClass' => ' list-group',
    ];

    /**
     * @var array Default English widget texts.
     * {NUM} tag will be automatically replaced with 'minQuery' value for the 
     * 'minimumCharacters' key.
     */
    protected $defaultLocal = [
        'allRecords'        => 'All records',
        'error'             => 'Error',
        'minimumCharacters' => 'Type at least {NUM} character(s) to filter the results...',
        'next'              => 'next',
        'noRecords'         => 'No matching records found',
        'previous'          => 'previous',
        'recordsContaining' => 'Records containing',
    ];

    /**
     * @var array Default widget classes and labels.
     */
    protected $defaults = [
        'buttonClass'   => 'ajaxDropDownToggle',
        'buttonLabel'   => '...',
        'groupClass'    => 'ajaxDropDown',
        'inputName'     => 'ajaxDropDownInput',
        'mainClass'     => 'ajaxDropDownWidget',
        'removeClass'   => 'ajaxDropDownRemove',
        'removelabel'   => 'x',
        'resultClass'   => 'ajaxDropDownSelected',
        'resultsClass'  => 'ajaxDropDownMenu',
        'selectedClass' => 'ajaxDropDownResults',
    ];

    const ADD_NEW_LINE = "\n";
    const ADD_TAB      = "\t";

    /**
     * Sets dropdown triggering button label.
     * @return string
     */
    protected function buttonLabel()
    {
        if (!empty($this->buttonLabel) && is_string($this->buttonLabel)) {
            return $this->buttonLabel;
        }
        else {
            return $this->bootstrapDefaults['buttonLabel'];
        }
        return !empty($this->defaults['buttonLabel']) ? $this->defaults['buttonLabel'] : '';
    }

    /**
     * Checks whether this widget is associated with a data model.
     * @return boolean
     */
    protected function hasModel()
    {
        return $this->model instanceof \yii\base\Model && $this->attribute !== null;
    }

    /**
     * Sets dropdown triggering button HTML options.
     * @return array
     */
    protected function htmlOptionsButton()
    {
        return $this->htmlOptionsSet('button', [
                    'type'        => 'button',
                    'data-toggle' => 'dropdown',
                    'data-page'   => 1
        ]);
    }

    /**
     * Sets div container for the buttons and dropdown menu HTML options.
     * @return array
     */
    protected function htmlOptionsButtons()
    {
        return $this->htmlOptionsSet('buttons');
    }

    /**
     * Sets extra button HTML options.
     * @return array
     */
    protected function htmlOptionsExtraButton()
    {
        $options = !empty($this->extraButtonOptions) && is_array($this->extraButtonOptions) ? $this->extraButtonOptions : [];
        return array_merge(
                ['type' => 'button'], $options
        );
    }

    /**
     * Sets div container for input text field and buttons with dropdown menu 
     * HTML options.
     * @return array
     */
    protected function htmlOptionsGroup()
    {
        $class = !empty($this->defaults['groupClass']) ? $this->defaults['groupClass'] : '';
        $style = !empty($this->defaults['groupStyle']) ? $this->defaults['groupStyle'] : '';

        if (!empty($this->bootstrapDefaults['groupClass'])) {
            $class .= $this->bootstrapDefaults['groupClass'];
            if ($this->dropup) {
                $class .= ' dropup';
            }
        }
        if (!empty($this->bootstrapDefaults['groupStyle'])) {
            $style .= $this->bootstrapDefaults['groupStyle'];
        }

        if (!empty($this->groupClass) && is_string($this->groupClass)) {
            $class .= ' ' . $this->groupClass;
        }

        if (!empty($this->groupStyle) && is_string($this->groupStyle)) {
            $style .= ' ' . $this->groupStyle;
        }

        $return = [
            'class' => $class ? : null,
            'style' => $style ? : null,
        ];

        return $return;
    }

    /**
     * Sets input text field HTML options.
     * @return array
     */
    protected function htmlOptionsInput()
    {
        return $this->htmlOptionsSet('input', ['id' => false]);
    }

    /**
     * Sets main widget div container HTML options.
     * @param string $id ID of the widget
     * @return array
     */
    protected function htmlOptionsMain($id)
    {
        return $this->htmlOptionsSet('main', ['id' => $id]);
    }

    /**
     * Sets removing preselected value link HTML options.
     * @return array
     */
    protected function htmlOptionsRemove($id)
    {
        return $this->htmlOptionsSet('remove', ['data-id' => $id]);
    }

    /**
     * Sets preselected value HTML options.
     * @param string $value Identificator of the result row
     * @return array
     */
    protected function htmlOptionsResult($value = '')
    {
        $class = !empty($this->defaults['resultClass']) ? $this->defaults['resultClass'] . $value : '';
        $style = !empty($this->defaults['resultStyle']) ? $this->defaults['resultStyle'] : '';

        if (!empty($this->bootstrapDefaults['resultClass'])) {
            $class .= $this->bootstrapDefaults['resultClass'];
        }
        if (!empty($this->bootstrapDefaults['resultStyle'])) {
            $style .= $this->bootstrapDefaults['resultStyle'];
        }

        if (!empty($this->resultClass) && is_string($this->resultClass)) {
            $class .= ' ' . $this->resultClass;
        }

        if (!empty($this->resultStyle) && is_string($this->resultStyle)) {
            $style .= ' ' . $this->resultStyle;
        }

        $return = [
            'class' => $class ? : null,
            'style' => $style ? : null,
        ];

        return $return;
    }

    /**
     * Sets dropdown menu HTML options.
     * @return array
     */
    protected function htmlOptionsResults()
    {
        return $this->htmlOptionsSet('results', ['role' => 'menu']);
    }

    /**
     * Sets div container for preselected values HTML options.
     * @return array
     */
    protected function htmlOptionsSelected()
    {
        return $this->htmlOptionsSet('selected');
    }

    /**
     * Sets HTML options for chosen element.
     * @param string $name Name of the element
     * @param array $additional Additional HTML options
     * @return array
     */
    protected function htmlOptionsSet($name, $additional = [])
    {
        $class = !empty($this->defaults[$name . 'Class']) ? $this->defaults[$name . 'Class'] : '';
        $style = !empty($this->defaults[$name . 'Style']) ? $this->defaults[$name . 'Style'] : '';

        if (!empty($this->bootstrapDefaults[$name . 'Class'])) {
            $class .= $this->bootstrapDefaults[$name . 'Class'];
        }
        if (!empty($this->bootstrapDefaults[$name . 'Style'])) {
            $style .= $this->bootstrapDefaults[$name . 'Style'];
        }

        if (!empty($this->{$name . 'Class'}) && is_string($this->{$name . 'Class'})) {
            $class .= ' ' . $this->{$name . 'Class'};
        }

        if (!empty($this->{$name . 'Style'}) && is_string($this->{$name . 'Style'})) {
            $style .= ' ' . $this->{$name . 'Style'};
        }

        $return = [
            'class' => $class ? : null,
            'style' => $style ? : null,
        ];

        if (count($additional)) {
            $return = array_merge($return, $additional);
        }

        return $return;
    }

    /**
     * Sets JS option for chosen element.
     * @param string $name Name of the option
     * @return string
     */
    protected function prepareOption($name)
    {
        $option = '';
        if (!empty($this->$name) && is_string($this->$name)) {
            $option = $this->$name;
        }
        else {
            $option = !empty($this->bootstrapDefaults[$name]) ? $this->bootstrapDefaults[$name] : '';
        }

        return $option;
    }

    /**
     * Sets translations JS option.
     * @return string
     */
    protected function prepareOptionLocal()
    {
        $local = !empty($this->defaultLocal) ? $this->defaultLocal : [];
        if (!empty($this->local) && is_array($this->local)) {
            foreach ($this->local as $key => $value) {
                if (!empty($value) && is_string($value)) {
                    $local[$key] = \Yii::t($this->translateCategory, $value);
                }
            }
        }

        $shortlocal = [];
        $shortNames = [
            'allRecords'        => 'allr',
            'error'             => 'erro',
            'minimumCharacters' => 'mcha',
            'next'              => 'next',
            'noRecords'         => 'nrec',
            'previous'          => 'prev',
            'recordsContaining' => 'rcon',
        ];
        foreach ($local as $key => $value) {
            if (isset($shortNames[$key])) {
                $shortlocal[$shortNames[$key]] = $value;
            }
            else {
                $shortlocal[$key] = $value;
            }
        }

        return $shortlocal;
    }

    /**
     * Sets minimum query length JS option.
     * @return integer
     */
    protected function prepareOptionMinQuery()
    {
        return is_numeric($this->minQuery) && $this->minQuery > 0 ? $this->minQuery : 0;
    }

    /**
     * Sets progress bar JS option.
     * @return string
     */
    protected function prepareOptionProgressBar()
    {
        $progressBar = '';
        if (!empty($this->progressBar) && is_string($this->progressBar)) {
            $progressBar = $this->progressBar;
        }
        else {
            $progressBar = !empty($this->bootstrapDefaults['progressBar']) ? strtr($this->bootstrapDefaults['progressBar'], ['{LOADING}' => \Yii::t($this->translateCategory, 'Loading')]) : '';
        }
        return $progressBar;
    }

    /**
     * Sets JS options.
     * @param string $name Name of the widget
     * @return array
     */
    protected function prepareOptions($name)
    {
        return [
            'addc' => $this->additionalCode,
            'ercl' => $this->prepareOption('errorClass'),
            'erst' => $this->prepareOption('errorStyle'),
            'hecl' => $this->prepareOption('headerClass'),
            'hest' => $this->prepareOption('headerStyle'),
            'loca' => $this->prepareOptionLocal(),
            'locl' => $this->prepareOption('loadingClass'),
            'lost' => $this->prepareOption('loadingStyle'),
            'mabe' => $this->prepareOption('markBegin'),
            'maen' => $this->prepareOption('markEnd'),
            'minq' => $this->prepareOptionMinQuery(),
            'name' => $name,
            'nebe' => $this->prepareOption('nextBegin'),
            'necl' => $this->prepareOption('nextClass'),
            'neen' => $this->prepareOption('nextEnd'),
            'nest' => $this->prepareOption('nextStyle'),
            'nrcl' => $this->prepareOption('noRecordsClass'),
            'nrst' => $this->prepareOption('noRecordsStyle'),
            'pabe' => $this->prepareOption('pagerBegin'),
            'paen' => $this->prepareOption('pagerEnd'),
            'prbe' => $this->prepareOption('previousBegin'),
            'prcl' => $this->prepareOption('previousClass'),
            'pren' => $this->prepareOption('previousEnd'),
            'prst' => $this->prepareOption('previousStyle'),
            'prba' => $this->prepareOptionProgressBar(),
            'recl' => $this->prepareOption('recordClass'),
            'rest' => $this->prepareOption('recordStyle'),
            'rmcl' => $this->prepareOption('removeClass'),
            'rmla' => $this->prepareOption('removeLabel'),
            'rmst' => $this->prepareOption('removeStyle'),
            'rscl' => $this->prepareOption('resultClass'),
            'rsst' => $this->prepareOption('resultStyle'),
            'smod' => $this->singleMode,
            'swcl' => $this->prepareOption('switchClass'),
            'swst' => $this->prepareOption('switchStyle'),
            'url'  => $this->source,
        ];
    }

    protected function resolveNameID()
    {
        if ($this->name !== null) {
            $name = $this->name;
            $id   = $this->name;
        }
        elseif ($this->hasModel()) {
            $name = Html::getInputName($this->model, $this->attribute);
            $id   = Html::getInputId($this->model, $this->attribute);
        }
        else {
            throw new \yii\base\Exception('class must specify "model" and "attribute" or "name" property values.');
        }

        return [$name, $id];
    }

    public function registerScript($id, $name)
    {
        $view    = $this->getView();
        AjaxDropdownAsset::register($view);
        $options = Json::encode($this->prepareOptions($name));
        $view->registerJs(implode(PHP_EOL, [';', "jQuery('#$id').ajaxDropDown($options);"]));
    }

    /**
     * Renders new line characters.
     * @param integer $copy Number of repeats, default 1
     * @return string
     */
    protected function renderNewLine($copy = 1)
    {
        echo \str_repeat(self::ADD_NEW_LINE, $copy);
    }

    /**
     * Renders single preselected value result.
     * @param boolean $active Wheter this widget is associated with a data 
     * model
     * @param array $data Preselected value data array
     * @param boolean $singleMode Wheter to render hidden output field as 
     * single one or as part of tabular data collection
     */
    protected function renderResult($active, $data = [], $singleMode = false)
    {
        if (empty($data['id'])) {
            $data['id'] = uniqid();
        }
        if (empty($data['mark']) || !in_array($data['mark'], [0, 1])) {
            $data['mark'] = 0;
        }
        if (empty($data['value']) || !is_string($data['value'])) {
            $data['value'] = 'error: missing value key in data array';
        }
        if (isset($data['additional']) && $data['additional'] !== false) {
            if (empty($data['additional']) || !is_string($data['additional'])) {
                $data['additional'] = '';
            }
        }
        else {
            $data['additional'] = '';
        }

        if (!empty($this->removeLabel) && is_string($this->removeLabel)) {
            $removeLabel = $this->removeLabel;
        }
        else {
            $removeLabel = $this->bootstrapDefaults['removeLabel'];
        }

        $arrayMode = '[]';
        if ($singleMode) {
            $arrayMode = '';
        }

        echo $this->renderTab(2);
        echo Html::beginTag('li', $this->htmlOptionsResult($data['id']));
        echo Html::a($removeLabel, '#', $this->htmlOptionsRemove($data['id']));
        if ($data['additional'] !== false && !empty($data['additional'])) {
            echo str_replace('{ID}', $data['id'], str_replace('{VALUE}', $data['value'], $data['additional']));
        }
        elseif (!empty($this->additionalCode)) {
            echo str_replace('{ID}', $data['id'], str_replace('{VALUE}', $data['value'], $this->additionalCode));
        }
        if ($data['mark']) {
            echo $this->prepareOption('markBegin');
        }
        echo $data['value'];
        if ($data['mark']) {
            echo $this->prepareOption('markEnd');
        }
        if ($active) {
            echo Html::activeHiddenInput($this->model, $this->attribute . $arrayMode, ['value' => $data['id'], 'id' => false]);
        }
        else {
            echo Html::hiddenInput($this->name . $arrayMode, $data['id'], ['id' => false]);
        }
        echo Html::endTag('li');
        echo $this->renderNewLine();
    }

    /**
     * Renders the preselected data values.
     * @param boolean $active Wheter this widget is associated with a data 
     * model
     */
    protected function renderResults($active = true)
    {
        if (is_array($this->data)) {

            if ($this->singleMode) {
                if (isset($this->data[0])) {
                    $this->renderResult($active, $this->data[0], $this->singleMode);
                }
            }
            else {
                foreach ($this->data as $data) {
                    $this->renderResult($active, $data, $this->singleMode);
                }
            }
        }
    }

    /**
     * Renders tab characters.
     * @param integer $copy Number of repeats, default 1
     * @return string
     */
    protected function renderTab($copy = 1)
    {
        echo \str_repeat(self::ADD_TAB, $copy);
    }

    /**
     * Renders the widget
     * @param string $id ID of the widget
     */
    protected function renderWidget($id)
    {
        echo $this->renderNewLine();
        echo Html::beginTag('div', $this->htmlOptionsMain($id));
        echo $this->renderNewLine();
        echo $this->renderTab();
        echo Html::beginTag('div', $this->htmlOptionsGroup());
        echo $this->renderNewLine();
        echo $this->renderTab(2);
        echo Html::textInput(!empty($this->defaults['inputName']) ? $this->defaults['inputName'] : '', '', $this->htmlOptionsInput());
        echo $this->renderNewLine();
        echo $this->renderTab(2);
        echo Html::beginTag('div', $this->htmlOptionsButtons());
        echo $this->renderNewLine();
        if (!empty($this->extraButtonLabel) || !empty($this->extraButtonOptions)) {
            echo $this->renderTab(3);
            echo Html::button(is_string($this->extraButtonLabel) ? $this->extraButtonLabel : '', $this->htmlOptionsExtraButton());
            echo $this->renderNewLine();
        }
        echo $this->renderTab(3);
        echo Html::button($this->buttonLabel(), $this->htmlOptionsButton());
        echo $this->renderNewLine();
        echo $this->renderTab(3);
        echo Html::beginTag('ul', $this->htmlOptionsResults());
        echo Html::endTag('ul');
        echo $this->renderNewLine();
        echo $this->renderTab(2);
        echo Html::endTag('div');
        echo $this->renderNewLine();
        echo $this->renderTab();
        echo Html::endTag('div');
        echo $this->renderNewLine();
        echo $this->renderTab();
        echo Html::beginTag('ul', $this->htmlOptionsSelected());
        echo $this->renderNewLine();
        $this->renderResults($this->data);
        echo $this->renderTab();
        echo Html::endTag('ul');
        echo $this->renderNewLine();
        echo Html::endTag('div');
        echo $this->renderNewLine();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        $id .= '_' . (!empty($this->defaults['mainClass']) ? $this->defaults['mainClass'] : '');
        $this->renderWidget($id);
        $this->registerScript($id, $name);
    }

}