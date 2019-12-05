<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 05.12.2019
 * Time: 10:59
 */

namespace frontend\modules\api\controllers;


use frontend\modules\api\models\Project;
use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
    public $modelClass = Project::class;
}