<?php
/* @var $this yii\web\View */
/* @var $requestContact \app\models\RequestContact */

use kartik\form\ActiveForm;
use kartik\builder\FormGrid;
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
            echo FormGrid::widget([
                'model' => $modelRequest->requestContact,
                'form' => $form,
                'rows' => [
                    [
                        'attributes' => [
                            'name' => ['type' => Form::INPUT_STATIC],
                        ],
                    ],
                    [
                        'attributes' => [
                            'phone' => ['type' => Form::INPUT_STATIC],
                            'email' => ['type' => Form::INPUT_STATIC],
                        ],
                    ],
                ],
            ]);
            ?>

            <?php
            echo FormGrid::widget([
                'model' => $modelRequest,
                'form' => $form,
                'rows' => [
                    [
                        'attributes' => [
                            'name' => ['type' => Form::INPUT_STATIC],
                        ],
                    ],
                    [
                        'attributes' => [
                            'type_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestTypes],
                            'priority_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestPriorities],
                        ],
                    ],
                    [
                        'encloseFieldSet' => true,
                        'attributes' => [
                            'description' => ['type' => Form::INPUT_STATIC],
                        ],
                    ],
                ]
            ]);
            ?>

            <div class="input-group-addon">

                <?php
                echo Form::widget([
                    'model' => $modelRequest,
                    'form' => $form,
                    'attributes' => [
                        'status_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestStatuses],
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
