<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * Description of Log
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */

/**
 * @property integer $request_id   Request id
 * @property integer $user_id      User id
 * @property integer $created_at   Event time
 * @property string $description   Request description
 */


class RequestLog extends BaseModel 
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['request_id', 'description', 'user_id', ], 'required', 'on' => ['create']],
            [['created_at'], 'default', 'value' => new \yii\db\Expression('datetime("now")'), 'on' => ['create']],
        ]);
    }
    
    
}
