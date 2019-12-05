<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 05.12.2019
 * Time: 11:40
 */

namespace frontend\modules\api\models;

use yii\helpers\StringHelper;


class Task extends \common\models\Task
{

    public function fields()
    {
        return ['id', 'title', 'description_short' => function () {
            return StringHelper::truncate($this->description, 50);
        }];
    }

    public function extraFields()
    {
        return ['project'];
    }
}