<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of RequestType
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class RequestPriority extends BaseModel
{

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'Приоритет',
        ];
    }

}
