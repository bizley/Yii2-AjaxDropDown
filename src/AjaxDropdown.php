<?php

namespace bizley\ajaxdropdown;

use bizley\ajaxdropdown\assets\AjaxDropdownAsset;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use Yii;

/**
 * AjaxDropDown is the Yii 2 widget for rendering the dropdown menu with 
 * the AJAX data source.
 * https://github.com/bizley-code/Yii2-AjaxDropDown
 * http://www.yiiframework.com/extension/yii2-ajaxdropdown
 *
 * See README file for configuration and usage examples.
 *
 * AjaxDropDown requires Yii version 2.0.
 * http://www.yiiframework.com
 * https://github.com/yiisoft/yii2
 *
 * For Yii 1.1 version of this widget see
 * https://github.com/bizley-code/Yii-AjaxDropDown
 * 
 * @author Paweł Bizley Brzozowski
 * @version 1.3.2
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class AjaxDropdown extends Widget
{

    /**
     * @var string Additional HTML code for the selected value row, default ''.
     * Any 'additional' key in $data parameter element will replace this.
     * Any {VALUE} and {ID} tags here are automatically replaced with selected 
     * id and value of the row.
     * @see $data
     */
    public $additionalCode = '';

    /**
     * @var string The attribute associated with this widget.
     * The square brackets ('[]') are added automatically to collect tabular 
     * data input when $singleMode parameter is set to false (default).
     */
    public $attribute;

    /**
     * @var string CSS class of the button triggering the dropdown in addition 
     * to 'ajaxDropDownToggle btn dropdown-toggle btn-default'. 
     */
    public $buttonClass;

    /**
     * @var string HTML label of the button triggering the dropdown, default 
     * '<span class="caret"></span>'.
     */
    public $buttonLabel;

    /**
     * @var string Additional CSS style of the button triggering the dropdown.
     */
    public $buttonStyle;

    /**
     * @var string CSS class of the div container for the buttons and dropdown 
     * menu in addition to 'ajaxDropDownButtons input-group-btn'.
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
     * inserted in the selected row. If given this replaces $additionalCode 
     * for that row only. In case you want to remove the $additionalCode only 
     * for that row set the 'additional' key to false.
     */
    public $data;

    /**
     * @var integer Delay between last key pressed and dropdown list opened 
     * in milliseconds, default 300. This option works only for 
     * $keyTrigger = true.
     * @since 1.2
     */
    public $delay = 300;

    /**
     * @var boolean Whether to add Bootstrap class 'dropup' to trigger dropdown 
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
     * @see Html::button()
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
     * @var string CSS class of the input text field in addition to 
     * 'form-control'.
     */
    public $inputClass;
    
    /**
     * @var array HTML options for the input text field.
     * @since 1.2.1
     */
    public $inputOptions;

    /**
     * @var string Additional CSS style of the input text field.
     */
    public $inputStyle;

    /**
     * @var boolean Whether adding or removing results with JS should trigger 
     * onRemove and onSelect callbacks, default true.
     * @since 1.3
     */
    public $jsEventsCallback = true;
    
    /**
     * @var boolean Whether pressing the key in filter field should trigger the 
     * dropdown list to open, default true.
     * @since 1.2
     */
    public $keyTrigger = true;

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
     * @see $defaultLocal
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
     * @var \yii\base\Model Data model associated with this widget.
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
     * results list, default 
     * ' <span class="glyphicon glyphicon-chevron-right"></span></small>'.
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
     * @var string JavaScript expression to be called when a result is removed 
     * from the list.
     * Available js variables:
     * id        - ID of the removed result,
     * selection - list of all selected results (after removing).
     * @since 1.2
     */
    public $onRemove = '';

    /**
     * @var string JavaScript expression to be called when a result is selected 
     * from the list.
     * Available js variables:
     * id        - ID of the selected result,
     * label     - label of the selected result,
     * selection - list of all selected results (after adding).
     * @since 1.2
     */
    public $onSelect = '';

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
     * {LOADING} tag used here is replaced with translated 'Loading' string.
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
     * @var string CSS class of the button removing the selection on singleMode
     * in addition to 'ajaxDropDownSingleRemove btn dropdown-toggle btn-default'.
     * @since 1.2
     */
    public $removeSingleClass;

    /**
     * @var string HTML label of the button removing the selection on 
     * singleMode, default 
     * '<span class="glyphicon glyphicon-remove text-danger"></span>'.
     * @since 1.2
     */
    public $removeSingleLabel;

    /**
     * @var string Additional CSS style of the button removing the selection in 
     * singleMode, default 'display:none;'
     * @since 1.2
     */
    public $removeSingleStyle;

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
     * @var boolean Whether to set widget in mode that allows only one selected 
     * value or more, default false.
     */
    public $singleMode = false;

    /**
     * @var boolean Whether to display singleMode result underneath the widget 
     * or in the filter input field, default false.
     * @since 1.2
     */
    public $singleModeBottom = false;

    /**
     * @var string URL of the AJAX source of records.
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
     * @see Yii::t()
     */
    public $translateCategory = 'app';

    /**
     * @var array Default Bootstrap classes and labels for the widget.
     */
    protected $bootstrapDefaults = [
        'buttonClass'       => ' btn dropdown-toggle btn-default',
        'buttonLabel'       => '<span class="caret"></span>',
        'buttonsClass'      => ' input-group-btn',
        'errorClass'        => 'list-group-item-danger',
        'groupClass'        => ' input-group',
        'inputClass'        => 'form-control',
        'markBegin'         => '<em>',
        'markEnd'           => '</em>',
        'nextBegin'         => '<small>',
        'nextClass'         => 'pull-right btn',
        'nextEnd'           => ' <span class="glyphicon glyphicon-chevron-right"></span></small>',
        'nextStyle'         => 'clear:none;',
        'pagerBegin'        => '<span class="badge pull-right">',
        'pagerEnd'          => '</span>',
        'previousBegin'     => '<small><span class="glyphicon glyphicon-chevron-left"></span> ',
        'previousClass'     => 'pull-left btn',
        'previousEnd'       => '</small>',
        'previousStyle'     => 'clear:none;',
        'progressBar'       => '<div class="progress" style="width:90%;margin:0 auto"><div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width:100%">{LOADING}</div></div>',
        'removeClass'       => ' text-danger pull-right',
        'removeLabel'       => '<span class="glyphicon glyphicon-remove"></span>',
        'removeSingleClass' => ' btn dropdown-toggle btn-default',
        'removeSingleLabel' => '<span class="glyphicon glyphicon-remove text-danger"></span>',
        'resultClass'       => ' list-group-item',
        'resultsClass'      => ' dropdown-menu',
        'resultsStyle'      => 'min-width:250px;',
        'selectedClass'     => ' list-group',
    ];

    /**
     * @var array Default English widget texts.
     * {NUM} tag is automatically replaced with value of $minQuery in the 
     * 'minimumCharacters' element.
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
        'buttonClass'       => 'ajaxDropDownToggle',
        'buttonsClass'      => 'ajaxDropDownButtons',
        'groupClass'        => 'ajaxDropDown',
        'inputName'         => 'ajaxDropDownInput',
        'mainClass'         => 'ajaxDropDownWidget',
        'removeClass'       => 'ajaxDropDownRemove',
        'removelabel'       => 'x',
        'removeSingleClass' => 'ajaxDropDownSingleRemove',
        'removeSingleLabel' => 'x',
        'removeSingleStyle' => 'display:none;',
        'resultClass'       => 'ajaxDropDownSelected',
        'resultsClass'      => 'ajaxDropDownMenu',
        'selectedClass'     => 'ajaxDropDownResults',
    ];

    /**
     * Sets dropdown triggering button label.
     * @return string
     */
    protected function buttonLabel()
    {
        if (!empty($this->buttonLabel) && is_string($this->buttonLabel)) {
            return $this->buttonLabel;
        }
        return $this->bootstrapDefaults['buttonLabel'];
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
     * @param boolean $hide Whether this button should be hidden
     * @return array
     */
    protected function htmlOptionsButton($hide = false)
    {
        return $this->htmlOptionsSet('button', [
                'type'        => 'button',
                'data-toggle' => 'dropdown',
                'data-page'   => 1
            ], $hide ? 'display:none;' : '');
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
        return array_merge(
                ['type' => 'button'],
                !empty($this->extraButtonOptions) && is_array($this->extraButtonOptions) ? $this->extraButtonOptions : []
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

        return [
            'class' => $class ?: null,
            'style' => $style ?: null,
        ];
    }

    /**
     * Sets input text field HTML options.
     * @param boolean $disabled Whether this field should be disabled
     * @return array
     */
    protected function htmlOptionsInput($disabled = false)
    {
        $options = ['id' => false];
        if (!empty($this->inputOptions) && is_array($this->inputOptions)) {
            $options = $this->inputOptions;
        }
        if ($disabled) {
            $options['disabled'] = true;
        }
        return $this->htmlOptionsSet('input', $options);
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
     * @param string $id ID of the widget
     * @return array
     */
    protected function htmlOptionsRemove($id)
    {
        return $this->htmlOptionsSet('remove', ['data-id' => $id]);
    }
    
    /**
     * Sets dropdown triggering button HTML options.
     * @param boolean $show Whether this button should be shown
     * @return array
     * @since 1.2
     */
    protected function htmlOptionsRemoveSingle($show = false)
    {
        return $this->htmlOptionsSet(
                'removeSingle',
                ['type' => 'button'], 
                $show ? 'display:inline-block;' : ''
            );
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

        return [
            'class' => $class ?: null,
            'style' => $style ?: null,
        ];
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
     * @param string $appendStyle Additional CSS style
     * @return array
     */
    protected function htmlOptionsSet($name, $additional = [], $appendStyle = '')
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
        if ($appendStyle != '') {
            if (!empty($return['style'])) {
                $return['style'] .= (substr(trim($return['style']), -1) != ';' ? ';' : '') . $appendStyle;
            } else {
                $return['style'] = $appendStyle;
            }
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
        if (!empty($this->$name) && is_string($this->$name)) {
            return $this->$name;
        }
        return !empty($this->bootstrapDefaults[$name]) ? $this->bootstrapDefaults[$name] : '';
    }

    /**
     * Sets boolean JS option for chosen element.
     * @param string $name
     * @return bool
     * @since 1.2
     */
    protected function prepareOptionBool($name)
    {
        return $this->$name ? true : false;
    }

    /**
     * Sets delay JS option.
     * @return integer
     */
    protected function prepareOptionDelay()
    {
        $value = 0;
        if (is_numeric($this->delay) && $this->delay > 0) {
            $value = (int)$this->delay;
        }
        return $value;
    }
    
    /**
     * Sets translations JS option.
     * @return string
     */
    protected function prepareOptionLocal()
    {
        $local = $this->defaultLocal;
        foreach ($local as $key => $value) {
            if (!empty($this->local[$key]) && is_string($this->local[$key])) {
                $value = $this->local[$key];
            }
            $local[$key] = Yii::t($this->translateCategory, $value);
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
            } else {
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
        return is_numeric($this->minQuery) && $this->minQuery > 0 ? (int)$this->minQuery : 0;
    }

    /**
     * Sets progress bar JS option.
     * @return string
     */
    protected function prepareOptionProgressBar()
    {
        if (!empty($this->progressBar) && is_string($this->progressBar)) {
            return strtr($this->progressBar, ['{LOADING}' => Yii::t($this->translateCategory, 'Loading')]);
        }
        return !empty($this->bootstrapDefaults['progressBar']) ? strtr($this->bootstrapDefaults['progressBar'], ['{LOADING}' => Yii::t($this->translateCategory, 'Loading')]) : '';
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
            'dely' => $this->prepareOptionDelay(),
            'ercl' => $this->prepareOption('errorClass'),
            'erst' => $this->prepareOption('errorStyle'),
            'hecl' => $this->prepareOption('headerClass'),
            'hest' => $this->prepareOption('headerStyle'),
            'jsev' => $this->prepareOptionBool('jsEventsCallback'),
            'keyt' => $this->prepareOptionBool('keyTrigger'),
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
            'onrm' => $this->onRemove,
            'onsl' => $this->onSelect,
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
            'smbt' => $this->prepareOptionBool('singleModeBottom'),
            'smod' => $this->prepareOptionBool('singleMode'),
            'swcl' => $this->prepareOption('switchClass'),
            'swst' => $this->prepareOption('switchStyle'),
            'url'  => $this->source,
        ];
    }

    /**
     * Registers assets and calls JS plugin.
     * @param string $id ID of the widget
     * @param string $name Name of the widget
     */
    public function registerScript($id, $name)
    {
        $view = $this->getView();
        AjaxDropdownAsset::register($view);
        $options = Json::encode($this->prepareOptions($name));
        $view->registerJs("jQuery('#$id').ajaxDropDown($options);");
    }
    
    /**
     * Sets dropdown triggering button label.
     * @return string
     * @since 1.2
     */
    protected function removeSingleLabel()
    {
        if (!empty($this->removeSingleLabel) && is_string($this->removeSingleLabel)) {
            return $this->removeSingleLabel;
        }
        return $this->bootstrapDefaults['removeSingleLabel'];
    }

    /**
     * Resolves name and ID.
     * @return array
     * @throws \yii\base\Exception
     */
    protected function resolveNameID()
    {
        if ($this->name !== null) {
            $name = $this->name;
            $id   = $this->name;
        } elseif ($this->hasModel()) {
            $name = Html::getInputName($this->model, $this->attribute);
            $id   = Html::getInputId($this->model, $this->attribute);
        } else {
            throw new \yii\base\Exception('Class must specify "model" and "attribute" or "name" property values.');
        }
        return [$name, $id];
    }
    
    /**
     * Renders the preselected data values.
     * @return array
     */
    protected function results()
    {
        $results = [];
        
        if (is_array($this->data)) {
            if ($this->singleMode) {
                if ($this->singleModeBottom) {
                    if (isset($this->data[0])) {
                        return [$this->singleResult($this->data[0], $this->singleMode)];
                    }
                }
            } else {
                foreach ($this->data as $data) {
                    $results[] = $this->singleResult($data, $this->singleMode);
                }
            }
        }
        
        return $results;
    }
    
    /**
     * Renders the widget.
     * @return string
     */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        $id .= '_' . (!empty($this->defaults['mainClass']) ? $this->defaults['mainClass'] : '');
        $this->registerScript($id, $name);
        
        $singleMode = false;
        if ($this->singleMode && !$this->singleModeBottom && $this->additionalCode == '') {
            if (is_array($this->data) && isset($this->data[0])) {
                $singleMode = true;
            }
        }
        
        return $this->render('field', [
            'attribute'               => $this->attribute,
            'buttonLabel'             => $this->buttonLabel(),
            'data'                    => $this->data,
            'defaults'                => $this->defaults,
            'extraButtonLabel'        => $this->extraButtonLabel,
            'extraButtonOptions'      => $this->extraButtonOptions,
            'htmlOptionsButton'       => $this->htmlOptionsButton($singleMode),
            'htmlOptionsButtons'      => $this->htmlOptionsButtons(),
            'htmlOptionsExtraButton'  => $this->htmlOptionsExtraButton(),
            'htmlOptionsGroup'        => $this->htmlOptionsGroup(),
            'htmlOptionsInput'        => $this->htmlOptionsInput($singleMode),
            'htmlOptionsMain'         => $this->htmlOptionsMain($id),
            'htmlOptionsRemoveSingle' => $this->htmlOptionsRemoveSingle($singleMode),
            'htmlOptionsResults'      => $this->htmlOptionsResults(),
            'htmlOptionsSelected'     => $this->htmlOptionsSelected(),
            'model'                   => $this->model,
            'name'                    => $this->name,
            'removeSingleLabel'       => $this->removeSingleLabel(),
            'results'                 => $this->results(),
            'singleMode'              => $singleMode,          
        ]);
    }
    
    /**
     * Renders single preselected value result.
     * @param array $data Preselected value data array
     * @param boolean $singleMode Whether to render hidden output field as 
     * single one or as part of tabular data collection
     * @return array
     */
    protected function singleResult($data = [], $singleMode = false)
    {
        $result = $data;
        if (empty($result['id'])) {
            $result['id'] = uniqid();
        }
        if (empty($result['mark']) || !in_array($result['mark'], [0, 1])) {
            $result['mark'] = 0;
        }
        if (empty($result['value']) || !is_string($result['value'])) {
            $result['value'] = 'error: missing value key in data array';
        }
        if (isset($result['additional']) && $result['additional'] !== false) {
            if (empty($result['additional']) || !is_string($result['additional'])) {
                $result['additional'] = '';
            }
        } else {
            $result['additional'] = '';
        }
        if (!empty($this->removeLabel) && is_string($this->removeLabel)) {
            $result['removeLabel'] = $this->removeLabel;
        } else {
            $result['removeLabel'] = $this->bootstrapDefaults['removeLabel'];
        }

        $result['arrayMode'] = '[]';
        if ($singleMode) {
            $result['arrayMode'] = '';
        }

        $result['htmlOptionsResult'] = $this->htmlOptionsResult($result['id']);
        $result['htmlOptionsRemove'] = $this->htmlOptionsRemove($result['id']);
        
        $result['markBegin'] = $this->prepareOption('markBegin');
        $result['markEnd']   = $this->prepareOption('markEnd');
        
        $result['model']     = $this->model;
        $result['attribute'] = $this->attribute;
        $result['name']      = $this->name;        
        
        return $result;
    }
}
