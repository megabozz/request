<?php

use kartik\grid\GridView;

//var_dump($params);exit;

$dataProvider = new yii\data\ActiveDataProvider([
    'query' => $params['queryRequest'],
]);

$model = $params['modelRequest'];
$columns = $model->getColumns('grid');

//var_dump($model);exit;


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => $columns,
    
]);



