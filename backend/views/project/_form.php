<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

/* @var $form yii\widgets\ActiveForm */

use unclead\multipleinput\MultipleInput;

?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, \common\models\Project::RELATIVE_PROJECT_USER)->widget(MultipleInput::class, [
        'id' => 'project-users-widget',
        'max' => 10,
        'min' => 0,
        'addButtonPosition' => MultipleInput::POS_HEADER,
        'columns' => [
            [
                'name' => 'project_id',
                'type' => 'hiddenInput',
                'defaultValue' => $model->id
            ],
            [
                'name' => 'user_id',
                'type' => 'dropDownLIst',
                'title' => 'User',
                'items' => $users
            ],
            [
                'name' => 'role',
                'type' => 'dropDownLIst',
                'title' => 'Role',
                'items' => \common\models\ProjectUser::ROLES_LABELS
            ],

        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
