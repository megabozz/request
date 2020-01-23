<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

$model = $params['modelRequest'];
$dataProvider = $model->search();
$columns = $model->getFormColumns('grid');


Pjax::begin([
    'id' => 'pj-' . $model->id,
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => $columns,
]);

Pjax::end();

