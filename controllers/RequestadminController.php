<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
//use yii\web\Controller;
use yii\web\Response;
use yii\helpers\ArrayHelper;
//use app\models\LoginForm;
//use app\models\ContactForm;
use kartik\form\ActiveForm;
use app\models\Request;
use app\models\RequestContact;
use app\models\RequestType;
use app\models\RequestPriority;

/**
 * Description of RequestController
 *
 * @author vgaltsev@OFFICE.INTERTORG
 */
class RequestadminController extends ControllerDefault
{

    public function behaviors()
    {
        $b = ArrayHelper::merge(parent::behaviors(), [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['logout'],
                        'rules' => [
                            [
                                'actions' => ['index'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
//                    'logout' => ['post'],
                        ],
                    ],
        ]);
        return $b;
    }

    public function actionIndex()
    {
        $modelRequest = new Request(['scenario' => 'search']);
        $modelRequest->load(Yii::$app->request->get(), $modelRequest->formName());
//        $modelRequestAttributes = [];
//        foreach ($modelRequest->attributes as $k => $v) {
//            $k = $modelRequest->formName() . '.' . $k;
//            $modelRequestAttributes[$k] = $v;
//        }
//        $queryRequest = $modelRequest->find()
//                ->alias($modelRequest->formName())
//                ->joinWith(['requestContact contact'])
//                ->joinWith(['requestType type'])
////                ->andFilterCompare($modelRequestAttributes)
//        ;

//        if(Yii::$app->request->isPjax){
//        return $this->renderAjax($this->action->id, [
//                    'params' => [
//                        'modelRequest' => $modelRequest,
////                        'queryRequest' => $queryRequest,
//                    ],
//        ]);
//            
//        }
        
        
        return $this->render($this->action->id, [
                    'params' => [
                        'modelRequest' => $modelRequest,
//                        'queryRequest' => $queryRequest,
                    ],
        ]);
    }

}
