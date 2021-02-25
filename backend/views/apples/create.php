<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Apples */

$this->title = Yii::t('app', 'Create Apples');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apples'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apples-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
