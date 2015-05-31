# Yii2-AjaxDropDown parameters

## additionalCode
_string_ Additional HTML code for the selected value row, default ''.
Any 'additional' key in **data** parameter element will replace this.
Any _{VALUE}_ and _{ID}_ tags here are automatically replaced with selected id and value of the row.

## attribute
_string_ The attribute associated with this widget.
The square brackets ('[]') are added automatically to collect tabular data input when **singleMode** parameter is set to false (default).

## buttonClass
_string_ CSS class of the button triggering the dropdown in addition to 'ajaxDropDownToggle btn dropdown-toggle btn-default'. 

## buttonLabel
_string_ HTML label of the button triggering the dropdown, default ```'<span class="caret"></span>'```.

## buttonStyle
_string_ Additional CSS style of the button triggering the dropdown.

## buttonsClass
_string_ CSS class of the div container for the buttons and dropdown menu in addition to 'ajaxDropDownButtons input-group-btn'.

## buttonsStyle
_string_ Additional CSS style of the div container for the buttons and dropdown menu.

## data
_array_ Array of preselected values arrays.
Every value array should be given with the three array keys:
- 'id'    => identification string for the value i.e. database ID number,
- 'mark'  => 0|1 flag for the emphasis of the value
- 'value' => string displayed as the value itself.

If empty 'id' is set to uniqid().
If not 0 and not 1 'mark' is set to 0.
If empty 'value' is set to 'error: missing value key in data array'.
There is the optional parameter 'additional' with HTML code to be inserted in the selected row. If given this replaces **additionalCode** for that row only. In case you want to remove the **additionalCode** only for that row set the 'additional' key to false.

## delay
_integer_ Delay between last key pressed and dropdown list opened in milliseconds, default 300. This option works only for **keyTrigger** = true.

## dropup
_boolean_ Wheter to add Bootstrap class 'dropup' to trigger dropdown menu above the button, default false.

## errorClass
_string_ CSS class of the result element displayed when AJAX failed to return data in addition to 'dropdown-header list-group-item-danger'.

## errorStyle
_string_ Additional CSS style of the result element displayed when AJAX failed to return data.

## extraButtonOptions
_array_ HTML options of the extra button between input text field and triggering button, default [].

## extraButtonLabel
_string_ HTML label for the extra button between input text field and triggering button, default ''.

## groupClass
_string_ CSS class of the div container for the input text field and div with buttons and dropdown menu in addition to 'ajaxDropDown input-group'.

## groupStyle
_string_ Additional CSS style of the div container for the input text field and div with buttons and dropdown menu.

## headerClass
_string_ CSS class of the results header element in addition to 'dropdown-header'.

## headerStyle
_string_ Additional CSS style of the results header element.

## inputClass
_string_ CSS class of the input text field in addition to 'form-control'.

## inputOptions
_array_ HTML options for the input text field.

## inputStyle
_string_ Additional CSS style of the input text field.

## jsEventsCallback
_boolean_ Wheter adding or removing results with JS should trigger onRemove and onSelect callbacks, default true.

## keyTrigger
_boolean_ Wheter pressing the key in filter field should trigger the dropdown list to open, default true.

## loadingClass
_string_ CSS class of the loading element on the results list in addition to 'ajaxDropDownLoading'.

## loadingStyle
_string_ Additional CSS style of the loading element on the results list.

## local
_array_ Array of translated strings used in widgets, default [].
Default English strings are:
- 'allRecords'        => 'All records',
- 'error'             => 'Error',
- 'minimumCharacters' => 'Type at least {NUM} character(s) to filter the results...',
- 'next'              => 'next',
- 'noRecords'         => 'No matching records found',
- 'previous'          => 'previous',
- 'recordsContaining' => 'Records containing',

{NUM} tag is automatically replaced with value of **minQuery** in the 'minimumCharacters' element.

## mainClass
_string_ CSS class of the main div container of the widget in addition to 'ajaxDropDownWidget'.

## mainStyle
_string_ Additional CSS style of the main div container of the widget.

## markBegin
_string_ HTML string of the beginning of the emphasised value on the results and preselected list, default ```'<em>'```.

## markEnd
_string_ HTML string of the ending of the emphasised value on the results and preselected list, default ```'</em>'```.

## minQuery
_integer_ Number of characters in the input text field required to send AJAX query, default 0.

## model
_yii\base\Model_ Data model associated with this widget.

## name
_string_ Widget name. This must be set if **model** is not set.

## nextBegin
_string_ HTML string of the beginning of the 'next' link on the results list, default ```'<small>'```.

## nextClass
_string_ CSS class of the 'next' link on the results list in addition to 'ajaxDropDownNext pull-right btn'.

## nextEnd
_string_ HTML string of the ending of the 'next' link on the results list, default ```' <span class="glyphicon glyphicon-chevron-right"></span></small>'```.

## nextStyle
_string_ Additional CSS style of the 'next' link on the results list in addition to 'clear:none;'.

## noRecordsClass
_string_ CSS class of the result element displayed when AJAX returns no matching records in addition to 'dropdown-header'.

## noRecordsStyle
_string_ Additional CSS style of the result element displayed when AJAX returns no matching records.

## onRemove
_string_ JavaScript expression to be called when a result is removed from the list.<br>
Available js variables:
- _id_ - ID of the removed result,
- _selection_ - list of all selected results (after removing).

## onSelect
_string_ JavaScript expression to be called when a result is selected from the list.<br>
Available js variables:
- _id_  - ID of the selected result,
- _label_ - label of the selected result,
- _selection_ - list of all selected results (after adding).

## pagerBegin
_string_ HTML string of the beginning of the actual page / total pages indicator, default ```'<span class="badge pull-right">'```.

## pagerEnd
_string_ HTML string of the ending of the actual page / total pages indicator, default '</span>'.

## previousBegin
_string_ HTML string of the beginning of the 'previous' link on the results list, default ```'<small><span class="glyphicon glyphicon-chevron-left"></span> '```.

## previousClass
_string_ CSS class of the 'previous' link on the results list in addition to 'ajaxDropDownPrev pull-left btn'.

## previousEnd
_string_ HTML string of the ending of the 'previous' link on the results list, default ```'</small>'```.

## previousStyle
_string_ Additional CSS style of the 'previous' link on the results list in addition to 'clear:none;'.

## progressBar
_string_ HTML string of the loading results indicator, default ```'<div class="progress" style="width:90%;margin:0 auto"><div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width:100%">{LOADING}</div></div>'```.

{LOADING} tag used here is replaced with translated 'Loading' string.

## recordClass
_string_ CSS class of the result value element on the results list in addition to 'ajaxDropDownPages'.

## recordStyle
_string_ Additional CSS class of the result value element on the results list.

## removeClass
_string_ CSS class of the link removing value from preselected list in addition to 'ajaxDropDownRemove text-danger pull-right'.

## removeLabel
_string_ HTML label of the link removing value from preselected list, default ```'<span class="glyphicon glyphicon-remove"></span>'```.

## removeSingleClass
_string_ CSS class of the button removing the selection on singleMode in addition to 'ajaxDropDownSingleRemove btn dropdown-toggle btn-default'.

## removeSingleLabel
_string_ HTML label of the button removing the selection on singleMode, default ```'<span class="glyphicon glyphicon-remove text-danger"></span>'```.

## removeSingleStyle
_string_ Additional CSS style of the button removing the selection in singleMode, default 'display:none;'

## removeStyle
_string_ Additional CSS style of the link removing value from preselected list.

## resultClass
_string_ CSS class of the preselected data element in addition to 'list-group-item'.

## resultStyle
_string_ Additional CSS style of the preselected data element.

## resultsClass
_string_ CSS class of the dropdown menu with AJAX records in addition to 'ajaxDropDownMenu dropdown-menu'.

## resultsStyle
_string_ Additional CSS style of the dropdown menu with AJAX records in addition to 'min-width:250px;'.

## selectedClass
_string_ CSS class of the div container for the preselected data in addition to 'ajaxDropDownResults list-group'.

## selectedStyle
_string_ Assitional CSS style of the div container for the preselected data.

## singleMode
_boolean_ Wheter to set widget in mode that allows only one selected value or more, default false.

## singleModeBottom
_boolean_ Wheter to display singleMode result underneath the widget, default false.

## source
_string_ URL of the AJAX source of records.

## switchClass
_string_ CSS class of the result value element holding the 'next' and 'previous' links.

## switchStyle
_string_ Additional CSS style of the result value element holding the 'next' and 'previous' links.

## translateCategory
_string_ Name of the translate category, default 'app'.
