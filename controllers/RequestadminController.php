<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Request;
use app\models\RequestType;
use app\models\RequestPriority;
use app\models\RequestStatus;
use app\models\RequestComment;

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
                                'actions' => [
                                    'index',
                                    'logout',
                                    'update',
                                    'view',
                                ],
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

    public function getBreadcrumbs()
    {
        return parent::getBreadcrumbs() + [
            $this->id => Yii::t('app', 'Admin requests'),
        ];
    }

    public function actionIndex()
    {


        Url::remember();
        $modelRequest = new Request(['scenario' => 'search']);
        $modelRequest->load(Yii::$app->request->get(), $modelRequest->formName());

        return $this->render($this->action->id, [
                    'params' => [
                        'modelRequest' => $modelRequest,
                    ],
        ]);
    }

    public function actionUpdate($id)
    {
        $modelRequest = Request::find()
                ->where(['id' => $id])
                ->one();
        if (!$modelRequest) {
            throw new \yii\web\NotFoundHttpException();
        }
        $modelComment = new RequestComment(['scenario' => 'create']);
        if (Yii::$app->request->isPost) {

            if ($modelComment->load(Yii::$app->request->post(), $modelComment->formName())) {
                if ($modelComment->validate()) {
                    $t = $modelComment->getDb()->beginTransaction();
                    $modelComment->request_id = $modelRequest->id;
                    $modelComment->save();
                    $t->commit();
                    $modelComment->description = null;
                    Yii::$app->request->getCsrfToken(true);
                }
            } else {

                $modelRequest->scenario = 'update';
                if (!$modelRequest->load(Yii::$app->request->post(), $modelRequest->formName())) {
                    throw new \yii\web\BadRequestHttpException();
                }

                if ($modelRequest->validate()) {
                    $modelRequest->save();
                    return $this->redirect(Url::previous());
                }
            }
        }

        $requestTypes = ArrayHelper::map(['' => ''] + RequestType::find()->cache(Yii::$app->params['CACHE_TIME'])->all(), 'id', 'name');
        $requestPriorities = ArrayHelper::map(['' => ''] + RequestPriority::find()->cache(Yii::$app->params['CACHE_TIME'])->all(), 'id', 'name');
        $requestStatuses = ArrayHelper::map(['' => ''] + RequestStatus::find()->cache(Yii::$app->params['CACHE_TIME'])->all(), 'id', 'name');

        return $this->render($this->action->id, [
                    'params' => [
                        'modelRequest' => $modelRequest,
                        'requestTypes' => $requestTypes,
                        'requestPriorities' => $requestPriorities,
                        'requestStatuses' => $requestStatuses,
                        'modelComment' => $modelComment,
                    ],
        ]);
    }

    public function actionView($id)
    {
        $modelRequest = Request::find()
                ->where(['id' => $id])
                ->one();
        if (!$modelRequest) {
            throw new \yii\web\NotFoundHttpException();
        }
        $modelComment = new RequestComment(['scenario' => 'create']);
        if (Yii::$app->request->isPost) {

            if ($modelComment->load(Yii::$app->request->post(), $modelComment->formName())) {
                if ($modelComment->validate()) {
                    $t = $modelComment->getDb()->beginTransaction();
                    $modelComment->request_id = $modelRequest->id;
                    $modelComment->save();
                    $t->commit();
                    $modelComment->description = null;
                    Yii::$app->request->getCsrfToken(true);
                }
            }
        }

        return $this->render($this->action->id, [
                    'params' => [
                        'modelRequest' => $modelRequest,
                        'modelComment' => $modelComment,
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
        return $this->render('/default/login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
