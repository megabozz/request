<?php

//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;


//var_dump($params);exit;

//$dataProvider = new yii\data\ActiveDataProvider([
//    'query' => $params['queryRequest'],
//]);

$model = $params['modelRequest'];
$dataProvider = $model->search();
$columns = $model->getFormColumns('grid');

//var_dump($model);exit;


Pjax::begin([
    'id' => 'pj-'.$model->id,
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => $columns,
    
]);

Pjax::end();

