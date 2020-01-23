<?php

namespace app\models;

class RequestType extends BaseModel
{

    protected static $translate = true;

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Тип',
        ];
    }

}
