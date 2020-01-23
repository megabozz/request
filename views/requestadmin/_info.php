<?php
/* @var $this yii\web\View */
/* @var $requestContact \app\models\RequestContact */

use kartik\form\ActiveForm;
use kartik\builder\Form;

extract($params);
?>
<div id="RequestForm">
    <div  class="form-group">

        <?php
        $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'formConfig' => ['labelSpan' => 4,
                        'deviceSize' => ActiveForm::SIZE_SMALL],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'enableClientScript' => false,
        ]);
        ?>

        <fieldset>
            <legend><?= Yii::t('app', 'REQUEST') ?></legend>
            <div class="input-group-">
                <?php
                echo Form::widget([
                    'model' => $modelRequest->requestContact,
                    'form' => $form,
                    'attributes' => [
                        'name' => ['type' => Form::INPUT_STATIC],
                    ],
                ]);
                echo Form::widget([
                    'model' => $modelRequest->requestContact,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'phone' => ['type' => Form::INPUT_STATIC],
                        'email' => ['type' => Form::INPUT_STATIC],
                    ],
                ]);
                ?>
            </div>
            <?php
            echo Form::widget([
                'model' => $modelRequest,
                'form' => $form,
                'attributes' => [
                    'name' => ['type' => Form::INPUT_STATIC],
                ],
            ]);
            echo Form::widget([
                'model' => $modelRequest,
                'form' => $form,
                'columns' => 2,
                'attributes' => [
                    'type_id' => ['type' => Form::INPUT_STATIC, 'staticValue' => $modelRequest->requestType ? $modelRequest->requestType->name : null],
                    'priority_id' => ['type' => Form::INPUT_STATIC, 'staticValue' => $modelRequest->requestPriority ? $modelRequest->requestPriority->name : null],
                    'status_id' => ['type' => Form::INPUT_STATIC, 'staticValue' => $modelRequest->requestStatus ? $modelRequest->requestStatus->name : null],
                ],
            ]);
            echo Form::widget([
                'model' => $modelRequest,
                'form' => $form,
                'attributes' => [
                    'description' => ['type' => Form::INPUT_STATIC],
                ],
            ]);
            ?>
        </fieldset>


    </div>

    <?php $form->end(); ?>
</div>
