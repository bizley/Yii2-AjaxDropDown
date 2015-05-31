# Yii2-AjaxDropDown Examples

## Data source example

    use common\models\User;
    use yii\data\ActiveDataProvider;
    use yii\helpers\Json;

    public function actionDatasource()
    {
        $request = Yii::$app->request;
        $results = ['data' => [], 'page' => 1, 'total' => 0];
        $query   = $request->post('query');
        $page    = $request->post('page', 1);
        
        $currentPage = 0;
        if (!empty($page) && is_numeric($page) && $page > 0) {
            $currentPage = $page - 1;
        }
        
        if (empty($query)) {
            $queryObject = User::find();
        }
        else {
            $queryObject = User::find()->where(['like', 'email', $query]);
        }        
        $provider = new ActiveDataProvider([
            'query' => $queryObject,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $provider->getPagination()->setPage($currentPage);

        foreach ($provider->getModels() as $data) {
            $results['data'][] = [
                'id'    => $data->id,
                'mark'  => 0,
                'value' => $data->email,
            ];
        }
        
        $results['page']  = $provider->getPagination()->getPage() + 1;
        $results['total'] = $provider->getPagination()->getPageCount();

        return Json::encode($results);
    }

## Basic widget setup

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
    ]);

## Active Record widget setup

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'model' => $model,
        'attribute' => $attribute,
        'source' => Url::to(['datasource']),
    ]);

## Field widget implementation

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo $form->field($model, $attribute)->widget(AjaxDropdown::classname(), ['source' => Url::to(['data'])]);

## Drop up mode

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'dropup' => true // default is false, list shows above the button now
    ]);

## Single selection mode

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'singleMode' => true // default is false, every selection replaces the previous one instead of being append
    ]);

## Extra button

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'extraButtonLabel' => '<span class="glyphicon glyphicon-plus"></span>', // label on the button
        'extraButtonOptions' => ['class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#modalAddUser'] // options for the button
    ]);

## Additional code

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'additionalCode' => '<span class="pull-right"><input type="checkbox" name="User[field][]" value="{ID}" checked></span>' // this code appears for every selected row
    ]);

## Preselected (and post-validated) data

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'data' => [ // these values appear as preselected
            [
                'id' => 1,
                'mark' => 0,
                'value' => 'record one'
            ],
            [
                'id' => 3,
                'mark' => 1,
                'value' => 'record three'
            ],
        ]
    ]);

Use the same parameter to send selected rows for post-validate state in case you want to "save" user's selection.

## Additional code different for each preselected data

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'data' => [
            [
                'id' => 1,
                'mark' => 0,
                'value' => 'record one',
                'additional' => '<span class="pull-right"><input type="checkbox" name="User[field][]" value="{ID}" checked></span>'
            ],
            [
                'id' => 3,
                'mark' => 1,
                'value' => 'record three',
                'additional' => '<span class="pull-right">Fubar</span>'
            ],
        ]
    ]);

## General additional code with one preselected data row exception

    use bizley\ajaxdropdown\AjaxDropdown;
    use yii\helpers\Url;
    
    echo AjaxDropdown::widget([
        'name' => 'WidgetTest',
        'source' => Url::to(['datasource']),
        'additionalCode' => '<span class="pull-right"><input type="checkbox" name="User[field][]" value="{ID}" checked></span>'
        'data' => [
            [
                'id' => 1,
                'mark' => 0,
                'value' => 'record one',
                'additional' => false
            ],
            [
                'id' => 3,
                'mark' => 1,
                'value' => 'record three',
            ],
        ]
    ]);

## Adding two results with JS using a button

    use use yii\web\View;

    $this->registerJs("jQuery('#addResults').click(function(){ jQuery('#model-field_id_ajaxDropDownWidget').trigger('add', [{id:1,value:\"new results 1\"}, {id:2,value:\"new result 2\",mark:1}]); })", View::POS_READY, 'addResult');

    <button class="btn btn-danger" id="addResults">Add AjaxDropDown Results in field_id</button>
