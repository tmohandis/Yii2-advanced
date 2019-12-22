<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 19.12.2019
 * Time: 15:47
 */

namespace console\controllers;
use yii\console\Controller;
use Yii;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $user = $auth->createRole('user');
        $auth->add($user);
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->assign($admin, 7);
        $auth->assign($user, 8);
        $auth->assign($user, 9);
    }
}