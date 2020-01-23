<?php

namespace app\models;

class RequestStatus extends BaseModel
{

    protected static $translate = true;

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Статус',
        ];
    }

}
