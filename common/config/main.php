<?php
use common\services\ProjectService;
use common\services\AssignRoleEvent;
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'projectService' => [
            'class' => ProjectService::class,
            'on ' . ProjectService::EVENT_ASSIGN_ROLE => function (AssignRoleEvent $event) {
                    Yii::$app->notificationService->newRoleUserNotification($event);
            }
        ],
        'emailService' => [
            'class' => common\services\EmailService::class
        ],
        'notificationService' => [
            'class' => common\services\NotificationService::class
        ]
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
    ],
];
