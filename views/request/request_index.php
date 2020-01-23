<?php
/* @var $this yii\web\View */
/* @var $requestContact \app\models\RequestContact */

use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

extract($params);

$form = ActiveForm::begin([
            'id' => 'RequestForm',
            'type' => ActiveForm::TYPE_VERTICAL,
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]);
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif ?>

<?php if (Yii::$app->session->getFlash('result')): ?>
    <div class="alert alert-info"><?= Yii::t('app', 'Request saved') ?></div>
<?php endif ?>


<fieldset>
    <legend><?= Yii::t('app', 'REQUEST') ?></legend>
    <div class="input-group-addon">
        <?php
        echo Form::widget([
            'model' => $request,
            'form' => $form,
            'columns' => 1,
            'compactGrid' => true,
            'attributes' => [
                'name' => ['type' => Form::INPUT_TEXT, 'options' => ['autofocus' => true]],
            ],
        ]);
        echo Form::widget([
            'model' => $request,
            'form' => $form,
            'columns' => 2,
            'compactGrid' => true,
            'attributes' => [
                'type_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestTypes],
                'priority_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $requestPriorities],
            ],
        ]);
        echo Form::widget([
            'model' => $request,
            'form' => $form,
            'columns' => 1,
            'compactGrid' => false,
            'attributes' => [
                'description' => ['type' => Form::INPUT_TEXTAREA],
            ],
        ]);
        ?>
    </div>


    <fieldset>
        <legend><?= Yii::t('app', 'DECLARANT') ?></legend>
        <div class="input-group-addon">
            <?php
            echo Form::widget([
                'model' => $requestContact,
                'form' => $form,
                'columns' => 1,
                'compactGrid' => true,
                'attributes' => [
                    'name' => ['type' => Form::INPUT_TEXT],
                ],
            ]);
            echo Form::widget([
                'model' => $requestContact,
                'form' => $form,
                'columns' => 2,
                'compactGrid' => true,
                'attributes' => [
                    'phone' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => MaskedInput::className(),
                        'options' => [
                            'mask' => '\+7 (999) 999-99-99',
                        ],
                    ],
                    'email' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => MaskedInput::className(),
                        'options' => [
                            'clientOptions' => [
                                'alias' => 'email',
                            ],
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </fieldset>
</fieldset>


<div class="clearfix form-group">
    <div class="text-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php
$form->end();
