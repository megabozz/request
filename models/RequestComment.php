<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class RequestComment extends BaseModel
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
                    [['request_id'], 'exist', 'targetClass' => Request::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
                    [['description'], 'trim', 'on' => ['create', 'update']],
                    [['description'], 'required', 'on' => ['create', 'update']],
                    [['description'], 'string', 'min' => 10, 'on' => ['create', 'update']],
                    [['created_at'], 'default', 'value' => new \yii\db\Expression('datetime("now")'), 'on' => ['create']],
                    [['created_by'], 'default', 'value' => Yii::$app->user->id, 'on' => ['create']],
                    [[
                    'createdBy.name',
                    'description',
                    'created_at',
                        ], 'safe', 'on' => ['grid']],
        ]);
    }

    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'created_by']);
    }

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'description' => 'Комментарий',
        ];
    }

}
