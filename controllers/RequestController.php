<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
//use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\web\Response;
//use yii\filters\VerbFilter;
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
class RequestController extends ControllerDefault
{

    public function behaviors()
    {
        $b = parent::behaviors();


        return $b;
    }

    public function actionIndex()
    {

        return $this->actionCreate();
    }

    public function actionCreate()
    {
        $error = '';
        $request = new Request(['scenario' => 'create']);
        $requestContact = new RequestContact(['scenario' => 'create']);

        if (\Yii::$app->request->isPost) {

            $checkFormResult = true;
            $checkFormResult &= $request->load(Yii::$app->request->post(), $request->formName());
            $checkFormResult &= $requestContact->load(Yii::$app->request->post(), $requestContact->formName());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($request) + ActiveForm::validate($requestContact);
            }

            $checkFormResult &= $request->validate();
            $checkFormResult &= $requestContact->validate();

            if ($checkFormResult) {

                $t = Yii::$app->db_request->beginTransaction();

                try {

                    $requestContactFind = RequestContact::find()
                            ->filterWhere($requestContact->attributes)
                            ->one();

                    if ($requestContactFind) {
                        $requestContact = $requestContactFind;
                    } else {
                        $requestContact->save();
                    }

                    $request->contact_id = $requestContact->id;

                    $request->save();

                    $t->commit();

                    return $this->redirect(\yii\helpers\Url::to('.'));
                } catch (\Exception $e) {
                    $t->rollback();
                    $error = $e->getMessage();
                }
            }
        }

        $requestTypes = ArrayHelper::map(['' => ''] + RequestType::find()->asArray()->all(), 'id', 'name');
        $requestPriorities = ArrayHelper::map(['' => ''] + RequestPriority::find()->asArray()->all(), 'id', 'name');

        return $this->render('request_index', [
                    'error' => $error,
                    'request' => $request,
                    'requestContact' => $requestContact,
                    'requestTypes' => $requestTypes,
                    'requestPriorities' => $requestPriorities,
        ]);
    }

}
