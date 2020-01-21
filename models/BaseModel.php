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
class BaseModel extends ActiveRecord {
    
    public static function getDb() {
        return Yii::$app->get('db_request');
    }
    
    public function getFilter($attr){
        return;
    }

    

    public function getColumns(string $scenario){
        $old_scenario = $this->scenario;
        $this->scenario = $scenario;
        $columns = [];
        
        foreach ($this->safeAttributes() as $attr){
            $columns[$attr]['attribute'] = $attr;
            $columns[$attr]['filter'] = $this->getFilter($attr);
            
        }
        
        $this->scenario = $old_scenario;
        return $columns;
    }
    
}
