<?php
/* @var $this yii\web\View */
/* @var $requestContact \app\models\RequestContact */

use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$form = ActiveForm::begin([
            'id' => 'RequestForm',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => [
//                    'label' => 'col-md-2 control-label',
//                    'offset' => 'col-sm-offset-4',
//                    'wrapper' => 'col-sm-10',
//                    'error' => 'has-error',
//                    'hint' => 'help-block',
                ],],
//            'enableClientValidation' => false,
            'enableAjaxValidation' => false,
//            'enableClientScript' => false,
        ]);
?>

<fieldset>
    <legend>Данные заявки</legend>
    <div class="input-group-addon">
        <?php echo $form->field($request, 'name')->textInput([]); ?>
        <div class="form-inline col-sm-offset-2 col-md-8">
            <?php echo $form->field($request, 'type_id', ['options' => ['class' => 'col-xs-6']])->dropDownList($requestTypes); ?>
            <?php echo $form->field($request, 'priority_id', ['options' => ['class' => 'col-xs-6']])->dropDownList($requestPriorities); ?>
        </div>
    </div>
</fieldset>


<fieldset>
    <legend>Заявитель</legend>
    <div class="form-group input-group-addon">
        <?php echo $form->field($requestContact, 'name')->textInput([]); ?>
        <div class="form-inline col-xs-11">
            <?php
            echo $form->field($requestContact, 'phone')->widget(MaskedInput::className(), [
                'mask' => '\+7 (999) 999-99-99'
            ]);
            ?>
            <?php echo $form->field($requestContact, 'email')->input('email'); ?>
        </div>
    </div>
</fieldset>

<div class="form-group">
    <div class="col-lg-offset-5 col-lg-8">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php
$form->end();
