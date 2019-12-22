<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $role string */
?>
<div>
    <p>Hello <?= Html::encode($user->username)?></p>
    <p>In the project <?= $project->title?> your role was changed to <?= $role?></p>
</div>
