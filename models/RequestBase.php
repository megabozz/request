<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * Description of RequestBase
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class RequestBase extends ActiveRecord {
    
    public static function getDb() {
        return Yii::$app->get('db_request');
    }
    
}
