<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * Description of Request
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class Request extends RequestBase
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'required', 'on' => ['create', 'update']],
            [['type_id'], 'required', 'on' => ['create', 'update']],
            [['type_id'], 'exist', 'targetClass' => RequestType::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
            [['priority_id'], 'required', 'on' => ['create', 'update']],
            [['priority_id'], 'exist', 'targetClass' => RequestPriority::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
            
        ]);
    }

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Наименование',
            'type_id' => 'Тип',
            'priority_id' => 'Приоритет'
        ];
    }
    
}
