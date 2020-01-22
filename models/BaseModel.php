<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Description of RequestBase
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class BaseModel extends ActiveRecord
{
    protected static $translate = false;
    

    public static function getDb()
    {
        return Yii::$app->get('db_request');
    }

    public function getFormFilters()
    {
        return[
        ];
    }

    public function getFormColumns(string $scenario)
    {
        $old_scenario = $this->scenario;
        $this->scenario = $scenario;
        $columns = [];
        $filters = $this->getFormFilters();

        foreach ($this->safeAttributes() as $attr) {
            $columns[$attr]['attribute'] = $attr;
            $columns[$attr]['filter'] = array_key_exists($attr, $filters) ? $filters[$attr] : false;
//            $columns[$attr]['filter'] = [1,2,3];
        }

//        var_dump($columns);exit;
        $this->scenario = $old_scenario;
        return $columns;
    }

    public function search(ActiveQuery $query = null)
    {
        $dp = new \yii\data\ActiveDataProvider([
            'query' => $query ? $query : $this->find(),
        ]);
        return $dp;
    }

    public function __get($name)
    {
        $v = parent::__get($name);
        if (static::$translate) {
            if (array_key_exists($name, $this->attributeLabels())) {
//            $classname = Yii::getAlias('@app/messages/'.str_replace('\\', '.', $this->className()).'.php');
//            var_dump($classname);
//            if(file_exists($classname)){
                $v = \Yii::t(str_replace('\\', '.', $this->className()), $v);
//            }
            }
        }
        return $v;
    }

}
