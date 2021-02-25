<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApplesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Apples');
$this->params['breadcrumbs'][] = $this->title;

$statuses = [
    1 => Yii::t('app', 'on the tree'),
    2 => Yii::t('app', 'fell')
]
?>

<div class="apples-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => false ], 'action' => Url::toRoute('apples/generate'), 'class'=>'form']); ?>

        <label class="control-label" for="num"><?=Yii::t('app', 'Count');?></label>
        <?= Html::input('text', 'count', "", ['class' => "form-control", 'placeholder' => Yii::t('app', 'Count'), 'id' => "count"]) ?>

        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-default'])?>
        <?php ActiveForm::end(); ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'color',
            'appeared_at:datetime',
            'fell_at:datetime',
            'percent',
            [
                'attribute' => 'status',
                'value' => function ($model){
                    if($model->status == 1){
                        return Yii::t('app', 'on the tree');
                    } else {
                        return Yii::t('app', 'fell');
                    }
                },
                'filter' => $statuses,
            ],
            //'percent',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {eat}',
                'buttons' => [
                    'eat' => function ($url, $model, $key) {
                        if(empty($model->fell_at)) {
                            return Html::a(Yii::t('app', 'Down'), ['apples/down', 'id' => $model->id]);
                        }

                        $iconName = "info-sign";

                        $title = Yii::t('app', 'Eat');

                        $id = 'eat-'.$key;
                        $options = [
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'id' => $id
                        ];

                        $url = Url::current(['', 'id' => $key]);


                        $js = <<<JS
            $("#{$id}").on("click",function(event){  
                    event.preventDefault();
                    $("#modal-apple-id").val("{$model->id}");
                    $("#myModal").modal("show");
                }
            );
JS;


                        //Регистрируем скрипты
                        $this->registerJs($js, \yii\web\View::POS_READY, $id);

                        return Html::a(Yii::t('app', 'Eat'), $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <?php $form = ActiveForm::begin(['options' => ['data-pjax' => false ], 'action' => Url::toRoute('apples/eat'), 'class'=>'form']); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?=Yii::t('app', 'Eat');?></h4>
                </div>
                <div class="modal-body">

                    <label class="control-label" for="num"><?=Yii::t('app', 'percent');?></label>
                    <?= Html::input('text', 'percent', "", ['class' => "form-control", 'placeholder' => Yii::t('app', 'percent'), 'id' => "percent"]) ?>
                    <?= Html::hiddenInput('id', '' , ['id' => 'modal-apple-id']); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>


</div>
