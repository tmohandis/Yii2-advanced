<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:text',
            'active',
            'creator_id',
            'updater_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $search,
        'columns' => [
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->username), Url::to(['user/view', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',

                'value' => function ($model) {
                    return $model::STATUS_LABELS[$model->status];
                },
                'filter' => \common\models\User::STATUS_LABELS,
            ],
            'email:email',
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    return $model->getProjectRole(Yii::$app->request->get('id'));
                },
            ]
        ],
    ]) ?>


</div>
