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
use yii\helpers\ArrayHelper;
use app\models\Request;

class RequestadminController extends ControllerDefault
{

    public function init()
    {
        Yii::$app->user->loginUrl = $this->uniqueId . '/login';
        parent::init();
    }
    
    public function behaviors()
    {
        $b = ArrayHelper::merge(parent::behaviors(), [
                    'access' => [
                        'class' => AccessControl::className(),
                        'except' => [
                            'login'
                        ],
//                        'only' => ['logout'],
                        'rules' => [
                            [
                                'actions' => ['index', 'logout'],
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

        return $this->render($this->action->id, [
                    'params' => [
                        'modelRequest' => $modelRequest,
                    ],
        ]);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('/default/login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    

}
