<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 05.12.2019
 * Time: 11:40
 */

namespace frontend\modules\api\models;

use yii\helpers\StringHelper;
use yii\behaviors\TimestampBehavior;



class Project extends \common\models\Project
{

    public function behaviors()
    {
        return [
            'class' => TimestampBehavior::class,
        ];
    }
    public function fields()
    {
        return ['id', 'title', 'description_short' => function () {
            return StringHelper::truncate($this->description, 50);
        },
            'active'];
    }

    public function extraFields()
    {
        return ['tasks'];
    }
}