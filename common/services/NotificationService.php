<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 18.12.2019
 * Time: 18:28
 */

namespace common\services;


class NotificationService
{
    public function newRoleUserNotification(AssignRoleEvent $event)
    {
        \Yii::$app->emailService->send(
            $event->user->email,
            'Your project role has been changed!',
            'assignRole-html',
            'assignRole-text',
            (array) $event
        );
    }
}