<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 18.12.2019
 * Time: 16:40
 */

namespace common\services;


use yii\base\Component;

class EmailService extends Component
{

    public function send($to, $subject, $viewHTML, $viewText, $data)
    {
        \Yii::$app->mailer->compose([
            'html' => $viewHTML,
            'text' => $viewText
        ], $data)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])->setTo($to)
            ->setSubject($subject)->send();
    }
    
}