<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <?= Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW),[
        'class' => 'img-circle center-block',
        'alt' => 'User image'
    ]); ?>
    <h1 class="text-center"><?= $model->username ?></h1>

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

    <img  class="center-block" src="" alt="">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            [
                'label' => 'Status',
                'value' => $model::STATUS_LABELS[$model->status]
            ],
            'created_at:date',
            'updated_at:date',
            'verification_token',
            'access_token',

        ],
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $search,
        'columns' => [
            'id',
            [
              'attribute' => 'title',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->title), Url::to(['project/view', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            'description:text',
            [
                'attribute' => 'active',
                'value' => function ($model) {
                    return $model::PROJECT_ACTIVE_LABELS[$model->active];
                },
                'filter' => \common\models\Project::PROJECT_ACTIVE_LABELS,
            ],
            'creator_id',
            'updater_id',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
