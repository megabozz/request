<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * Description of Request
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class Request extends BaseModel
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
                    [['name', 'description'], 'trim', 'on' => ['create']],
                    [['name'], 'required', 'on' => ['create', 'update']],
                    [['type_id'], 'required', 'on' => ['create', 'update']],
                    [['type_id'], 'exist', 'targetClass' => RequestType::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
                    [['priority_id'], 'required', 'on' => ['create', 'update']],
                    [['priority_id'], 'exist', 'targetClass' => RequestPriority::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
                    [['description'], 'required', 'on' => ['create']],
                    [['created_at'], 'default', 'value' => new Expression('datetime("now")'), 'on' => ['create']],
                    [['status_id'], 'default', 'value' => Request::find()->where(['name' => 'NEW'])->select(['id'])->scalar(), 'on' => ['create']],
                    [['status_id'], 'exist', 'targetClass' => RequestStatus::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
                    [[
                        'name', 
                        'requestStatus.name',
                        'requestType.name',
                        'requestPriority.name',
                        'created_at',
                    ], 'safe', 'on' => ['grid']],
            
                    [['name'], 'safe', 'on' => ['search']],
//                    [['requestType.name'], 'safe', 'on' => ['search']],
                    [['created_at'], 'date', 'on' => ['search']],
            
        ]);
    }

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Наименование',
            'description' => 'Описание',
            'type_id' => 'Тип',
            'priority_id' => 'Приоритет',
            'status_id' => 'Статус',
            'created_at' => 'Дата создания',
        ];
    }

    public function getRequestContact()
    {
        return $this->hasOne(RequestContact::className(), ['id' => 'contact_id']);
    }

    public function getRequestStatus()
    {
        return $this->hasOne(RequestStatus::className(), ['id' => 'status_id']);
    }
    public function getRequestType()
    {
        return $this->hasOne(RequestType::className(), ['id' => 'type_id']);
    }
    public function getRequestPriority()
    {
        return $this->hasOne(RequestPriority::className(), ['id' => 'priority_id']);
    }
    
    
    
    public function getFilter($attr)
    {
        $f = parent::getFilter($attr);
        if($f == 'created_at'){
//            return kartik\wi;
        }
        if($f == 'requestType.name'){
            return ArrayHelper::map(RequestType::find()->all(), 'id', 'name');
        }
        
        
        return $f;
    }

}
