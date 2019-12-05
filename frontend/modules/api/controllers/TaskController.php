<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 05.12.2019
 * Time: 10:58
 */

namespace frontend\modules\api\controllers;


use frontend\modules\api\models\Task;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class TaskController extends Controller
{

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Task::find()
        ]);
    }

    public function actionView($id) {
        return Task::findOne($id);
    }

}