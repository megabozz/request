<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\helpers\Html;

class Request extends BaseModel
{

    public $requestTypeId;
    public $requestStatusId;
    public $requestPriorityId;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
                    [['name', 'description'], 'trim', 'on' => ['create']],
                    [['name'], 'required', 'on' => ['create']],
                    [['name'], 'string', 'min' => 5, 'on' => ['create']],
                    [['type_id'], 'required', 'on' => ['create', 'update']],
                    [['type_id'], 'exist', 'targetClass' => RequestType::className(), 'targetAttribute' => 'id', 'skipOnEmpty' => false, 'on' => ['create', 'update']],
                    [['priority_id'], 'required', 'on' => ['create', 'update']],
                    [['priority_id'], 'exist', 'targetClass' => RequestPriority::className(), 'targetAttribute' => 'id', 'skipOnEmpty' => false, 'on' => ['create', 'update']],
                    [['description'], 'required', 'on' => ['create']],
                    [['description'], 'string', 'min' => 10, 'on' => ['create']],
                    [['created_at'], 'default', 'value' => new Expression('datetime("now")'), 'on' => ['create']],
                    [['status_id'], 'required', 'on' => ['update']],
                    [['status_id'], 'default', 'value' => RequestStatus::find()->cache(Yii::$app->params['CACHE_TIME'])->where(['name' => 'NEW'])->select(['id'])->scalar(), 'on' => ['create']],
                    [['status_id'], 'exist', 'targetClass' => RequestStatus::className(), 'targetAttribute' => 'id', 'skipOnEmpty' => false, 'on' => ['create', 'update']],
                    [['status_id'], 'integer', 'on' => ['update']],
                    [['work_time_estimated'], 'filter', 'filter' => function($v) {
                            if (!is_array($v)) {
                                $v1 = explode(":", preg_replace('/[^0-9\:]/', "", $v));
                                if (count($v1) == 2) {
                                    return $v1[0] * 60 + $v1[1];
                                }
                            }
                            return $v;
                        }, 'on' => ['update']],
                    [['work_time_estimated'], 'integer', 'on' => ['update']],
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

    public function afterFind()
    {
        parent::afterFind();

        $v = $this->work_time_estimated;
        if (is_numeric($v)) {
            $v = sprintf("%02d:%02d", $v / 60, $v % 60);
        }
        $this->work_time_estimated = $v;
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
            'work_time_estimated' => 'Время обработки',
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

    public function getRequestComments()
    {
        return $this->hasMany(RequestComment::className(), ['request_id' => 'id']);
    }

    public function search(ActiveQuery $query = null)
    {
        $dp = parent::search($query);
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

        return $f;
    }

    public function getFormColumns(string $scenario)
    {
        $c = parent::getFormColumns($scenario);

        $c['actions'] = [
            'class' => \yii\grid\ActionColumn::className(),
            'template' => '{view} {update}',
        ];


        return $c;
    }

}
