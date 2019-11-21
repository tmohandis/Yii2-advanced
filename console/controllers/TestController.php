<?php
namespace console\controllers;

use common\models\User;

class TestController extends \yii\console\Controller
{
    public function actionIndex()
    {
        echo 'Hello world';
    }

    public function actionSetAdmin()
    {
        $user = new User(
            [
                'username' => 'admin',
                'email' => 'admin@local.net',
                'access_token' => 'admin-token',
                'avatar' => '../common/web/images/1.jpeg'
            ]
        );
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();
        $user->password = '123123123';
        if ($user->save()) echo 'success';
    }
}