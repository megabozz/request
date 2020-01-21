<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * Description of RequestContact
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class RequestContact extends BaseModel
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
                    [['name', 'phone', 'email'], 'trim', 'on' => ['create', 'update']],
                    [['name'], 'required', 'on' => ['create', 'update']],
                    [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'on' => ['create', 'update']],
                    [['email'], 'email', 'on' => ['create', 'update']],
                    [['email','phone'], 'required', 'when' => function(){
                        return (empty($this->email) && empty($this->phone));
                    }, 'on' => ['create']],
        ]);
    }
    
//    public function mycheck(){
////        return false;
//    var_dump(11111);exit;
//                            $this->addError('phone', 'Необходимо заполнить {email} или {phone}');
////                            var_dump(11111);exit;
//                        if(empty($this->email) && empty($this->phone)){
//                            $this->addError('email', 'Необходимо заполнить {email} или {phone}');
//                        }
//    }

        public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'E-mail',
        ];
    }
    

}
