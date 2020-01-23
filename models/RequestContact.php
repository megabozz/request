<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class RequestContact extends BaseModel
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
                    [['name', 'phone', 'email'], 'trim', 'on' => ['create', 'update']],
                    [['name'], 'required', 'on' => ['create', 'update']],
                    [['name'], 'string', 'min' => 10, 'on' => ['create', 'update']],
                    [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'on' => ['create', 'update']],
                    [['email'], 'email', 'on' => ['create', 'update']],
                    [['email'], 'required', 'when' => function() {
                            return (empty($this->phone));
                        }, 'on' => ['create']],
                    [['phone'], 'required', 'when' => function() {
                            return (empty($this->email));
                        }, 'on' => ['create']],
        ]);
    }

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'E-mail',
        ];
    }

}
