<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\widgets\Pjax;

extract($params);

$comments = $modelRequest->getRelation('requestComments');
?>
<div id="RequestComments">
    <div  class="form-group">
        <fieldset id="RequestComments">
            <legend><?= Yii::t('app', 'Comments') ?></legend>
            <?php
            Pjax::begin([
                'id' => $modelComment->formName(),
                'enablePushState' => false,
            ]);
            echo GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $comments,
                    'sort' => [
                        'attributes' => [
                            'description' => false,
                            'created_at',
                        ],
                        'defaultOrder' => [
                            'created_at' => SORT_DESC,
                        ],
                    ],
                    'pagination' => [
                        'pageSize' => 8,
                    ],
                        ]),
                'columns' => $modelComment->getFormColumns('grid'),
                'layout' => "<center>{pager}{summary}</center>\n{items}\n",
            ]);
            Pjax::end();
            ?>
            <?php
            Pjax::begin([
                'id' => 'pjax-' . $modelComment->formName(),
//                'formSelector' => $modelComment->formName(),
            ]);
            $form = ActiveForm::begin([
                        'options' => [
                            'data-pjax' => true,
                        ],
                        'id' => $modelComment->formName(),
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL],
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => false,
                        'enableClientScript' => false,
            ]);
            echo Form::widget([
                'model' => $modelComment,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'description' => ['type' => Form::INPUT_TEXTAREA],
                ],
            ]);
            ?>
            <div class="text-right">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
                <?php
                $form->end();
                Pjax::end();
                ?>
        </fieldset>
    </div>
</div>
<?php
$this->registerJs('
$("document").ready(function(){
    $("#pjax-' . $modelComment->formName() . '").on("pjax:end", function() {
        $.pjax.reload({container:"#' . $modelComment->formName() . '"});
    });
});    
');

