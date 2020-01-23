<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

class ControllerDefault extends Controller
{

    public function behaviors()
    {
        return [];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function getBreadcrumbs()
    {
        return [];
    }

    public function beforeAction($action)
    {
        $b = $this->getBreadcrumbs();

        if ($this->action->id == 'index') {
            $this->view->params['breadcrumbs'][] = [
                'label' => Yii::t('app', array_key_exists($this->id, $b) ? $b[$this->id] : $this->id),
            ];
        } else {


            $this->view->params['breadcrumbs'][] = [
                'label' => Yii::t('app', array_key_exists($this->id, $b) ? $b[$this->id] : $this->id),
                'url' => ['/' . $this->id]
            ];
            $this->view->params['breadcrumbs'][] = [
                'label' => Yii::t('app', array_key_exists($this->action->id, $b) ? $b[$this->action->id] : $this->action->id),
            ];
        }

        return parent::beforeAction($action);
    }

}
