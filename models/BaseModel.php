<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

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

    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'created_at' => Yii::t('app','Date creation'),
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
        }

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
                $v = \Yii::t(str_replace('\\', '.', $this->className()), $v);
            }
        }
        return $v;
    }

}
