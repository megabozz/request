<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use app\models\Request;
use app\models\RequestContact;
use app\models\RequestType;
use app\models\RequestPriority;

class RequestController extends ControllerDefault
{

    public function getBreadcrumbs()
    {
        return parent::getBreadcrumbs() + [
            $this->id => Yii::t('app', 'Requests'),
        ];
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

            $validateResult = true;
            $validateResult &= $request->load(Yii::$app->request->post(), $request->formName());
            $validateResult &= $requestContact->load(Yii::$app->request->post(), $requestContact->formName());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($request) + ActiveForm::validate($requestContact);
            }

            $validateResult &= $request->validate();
            $validateResult &= $requestContact->validate();

            if ($validateResult) {

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

                    Yii::$app->session->setFlash("result", true);

                    return $this->redirect(\yii\helpers\Url::to('.'));
                } catch (\Exception $e) {
                    $t->rollback();
                    $error = $e->getMessage();
                }
            }
        }

        $requestTypes = ArrayHelper::map(['' => ''] + RequestType::find()->cache(Yii::$app->params['CACHE_TIME'])->all(), 'id', 'name');
        $requestPriorities = ArrayHelper::map(['' => ''] + RequestPriority::find()->cache(Yii::$app->params['CACHE_TIME'])->all(), 'id', 'name');

        return $this->render('request_index', [
                    'params' => [
                        'error' => $error,
                        'request' => $request,
                        'requestContact' => $requestContact,
                        'requestTypes' => $requestTypes,
                        'requestPriorities' => $requestPriorities,
                    ],
        ]);
    }

}
