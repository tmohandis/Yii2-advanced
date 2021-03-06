<?php

namespace common\models;

use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $access_token
 * @property string $avatar
 * @property string $password write-only password
 * @property-read Project $createdProjects
 * @property-read Project $updatedProjects
 * @property-read Task $createdTasks
 * @property-read Task $updatedTasks
 * @property-read Task $activeTasks
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const AVATAR_ICO = 'ico';
    const AVATAR_PREVIEW = 'preview';
    const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_DELETED
    ];
    const STATUS_LABELS = [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_INACTIVE => 'inactive',
            self::STATUS_DELETED => 'deleted'
        ];
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const EVENT_AFTER_LOGIN = 'afterLogin';
    private $password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_INSERT, self::SCENARIO_UPDATE],
                //'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@frontend/web/upload/user/{id}',
                'url' => Yii::$app->params['hostsFront'] . Yii::getAlias('@web/upload/user/{id}'),
                'thumbs' => [
                    self::AVATAR_ICO => [
                        'width' => 100,
                        'height' => 100
                    ],
                    self::AVATAR_PREVIEW => [
                        'width' => 200,
                        'height' => 200
                    ],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['password', 'required', 'on' => self::SCENARIO_INSERT],
            [['username', 'email', 'password'], 'safe'],
            ['email', 'email'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['avatar', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
            ['status', 'in', 'range' => self::STATUS_LIST],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        if ($password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

   public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getProjectRole($project)
    {
        $data = ProjectUser::findOne([
            'project_id' => $project,
            'user_id' => $this->id
        ]);
        return $data->role;
    }

    public function getProjectUsers()
    {
        return ProjectUser::find()->where([
            'user_id' => $this->id
        ])->all();
    }

    public function getProjectsQuery()
    {
        $idArray = [];
        $projectsArray = ArrayHelper::toArray($this->getProjectUsers());
        foreach ($projectsArray  as $item) {
            array_push($idArray, $item['project_id']);
        }
        return Project::find()->where(['id' => $idArray]);
    }

    public function getProjects()
    {
        return $this->getProjectsQuery()->all();
    }

    public function getActiveTasks()
    {
        return Task::find()->where(['executor_id' => $this->id]);
    }


    public function getCreatedTasks()
    {
        return Task::find()->where(['creator_id' => $this->id]);
    }

    public function getUpdatedTasks()
    {
        return Task::find()->where(['updater_id' => $this->id]);
    }

    public function getCreatedProjects()
    {
        return Project::find()->where(['creator_id' => $this->id]);
    }

    public function getUpdatedProjects()
    {
        return Project::find()->where(['updater_id' => $this->id]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->generateAuthKey();
            return true;
        }
        return false;
    }
}
