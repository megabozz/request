<?php
/* @var $this yii\web\View */
/* @var $requestContact \app\models\RequestContact */

use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

extract($params);
?>
<div id="RequestForm">
    <div  class="form-group">

        <?php
        $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'enableClientScript' => false,
        ]);
        ?>

        <fieldset>
            <legend><?= Yii::t('app', 'REQUEST') ?></legend>
            <?php
            echo Form::widget([
                'model' => $modelRequest->requestContact,
                'form' => $form,
                'columns' => 1,
                'encloseFieldSet' => true,
                'attributes' => [
                    'name' => ['type' => Form::INPUT_STATIC],
                    'phone' => ['type' => Form::INPUT_STATIC],
                    'email' => ['type' => Form::INPUT_STATIC],
                ],
            ]);
            ?>

            <?php
            echo Form::widget([
                'model' => $modelRequest,
                'form' => $form,
                'encloseFieldSet' => true,
                'attributes' => [
                    'name' => ['type' => Form::INPUT_STATIC],
                    'type_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestTypes, 'options' => ['style' => 'width:20em;'],],
                    'priority_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestPriorities, 'options' => ['style' => 'width:20em;'],],
                    'description' => ['type' => Form::INPUT_STATIC],
                ],
            ]);
            ?>

            <div class="input-group-addon">

                <?php
                echo Form::widget([
                    'model' => $modelRequest,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'status_id' => [
                            'type' => Form::INPUT_DROPDOWN_LIST,
                            'items' => $requestStatuses,
                            'options' => ['style' => 'width:10em;'],
                        ],
                        'work_time_estimated' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => MaskedInput::className(),
                            'options' => [
                                'options' => [
                                    'style' => 'width:5em;',
                                ],
                                'mask' => '99:99',
                            ],
                        ],
                    ],
                ]);
                ?>

            </div>

            <div class="text-right">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
        </fieldset>


    </div>

    <?php $form->end(); ?>
</div>
