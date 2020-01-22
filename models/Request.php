<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\helpers\Html;

/**
 * Description of Request
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class Request extends BaseModel
{

    public $requestTypeId;
    public $requestStatusId;
    public $requestPriorityId;

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
                    [['status_id'], 'default', 'value' => RequestStatus::find()->cache(Yii::$app->params['CACHE_TIME'])->where(['name' => 'NEW'])->select(['id'])->scalar(), 'on' => ['create']],
                    [['status_id'], 'exist', 'targetClass' => RequestStatus::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
                    [[
                    'name',
                    'requestStatus.name',
                    'requestType.name',
                    'requestPriority.name',
                    'created_at',
                        ], 'safe', 'on' => ['grid']],
                    [[
                    'name',
                    'created_at',
                    'requestTypeId',
                    'requestStatusId',
                    'requestPriorityId',
                        ], 'safe', 'on' => ['search']],
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

//    public function getRequestTypeId()
//    {
//        return $this->requestTypeId;
//    }
//
//    public function setRequestTypeId($v)
//    {
//        $this->requestTypeId = $v;
//    }

    public function search(ActiveQuery $query = null)
    {
        $dp = parent::search($query);
//        $q = new ActiveQuery;
        $q = $dp->query;
        $q->alias('request');
        $q->joinWith(['requestType type']);
        $q->joinWith(['requestStatus status']);
        $q->joinWith(['requestPriority priority']);

        $q->andFilterWhere(['type.id' => $this->requestTypeId]);
        $q->andFilterWhere(['status.id' => $this->requestStatusId]);
        $q->andFilterWhere(['priority.id' => $this->requestPriorityId]);
        $q->andfilterWhere(['like', 'request.name', $this->name]);

        $dp->sort->attributes['requestStatus.name'] = [
            'asc' => ['status.name' => SORT_ASC],
            'desc' => ['status.name' => SORT_DESC],
        ];
        $dp->sort->attributes['requestType.name'] = [
            'asc' => ['type.name' => SORT_ASC],
            'desc' => ['type.name' => SORT_DESC],
        ];
        $dp->sort->attributes['requestPriority.name'] = [
            'asc' => ['priority.name' => SORT_ASC],
            'desc' => ['priority.name' => SORT_DESC],
        ];




        return $dp;
    }

    public function getFormFilters()
    {
        $f = parent::getFormFilters() + [
            'name' => true,
            'requestType.name' => Html::activeDropDownList($this, 'requestTypeId', ArrayHelper::map(RequestType::find()->cache(Yii::$app->params['CACHE_TIME'])
                                    ->select(['id', 'name'])->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            'requestStatus.name' => Html::activeDropDownList($this, 'requestStatusId', ArrayHelper::map(RequestStatus::find()->cache(Yii::$app->params['CACHE_TIME'])
                                    ->select(['id', 'name'])->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            'requestPriority.name' => Html::activeDropDownList($this, 'requestPriorityId', ArrayHelper::map(RequestPriority::find()->cache(Yii::$app->params['CACHE_TIME'])
                                    ->select(['id', 'name'])->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
        ];

//        if($f == 'created_at'){
////            return kartik\wi;
//        }
//        if($f == 'requestType.name'){
//            return ArrayHelper::map(RequestType::find()->all(), 'id', 'name');
//        }


        return $f;
    }

}
