<?php

namespace app\models;

class RequestPriority extends BaseModel
{

    protected static $translate = true;

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Приоритет',
        ];
    }

}
