<?php

namespace common\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $active
 * @property int $creator_id
 * @property int|null $updater_id
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property User $creator
 * @property User $updater
 * @property ProjectUser[] $projectUsers
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    const PROJECT_ACTIVE = 1;
    const PROJECT_INACTIVE = 0;
    const PROJECT_ACTIVE_LABELS = [
        self::PROJECT_ACTIVE => 'active',
        self::PROJECT_INACTIVE => 'inactive'
    ];
    const RELATIVE_PROJECT_USER = 'projectUsers';

    public function behaviors()
    {
        return [

            'class' => TimestampBehavior::class,

            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id'
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    self::RELATIVE_PROJECT_USER
                ]
            ]

        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'creator_id', 'created_at'], 'required'],
            [['description'], 'string'],
            [['active', 'creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    public function getUsersQuery()
    {
        return User::find()->where(['id' => $this->getUsersId()]);
    }

    public function getUsers()
    {
        return $this->getUsersQuery()->all();
    }

    public function getUsersRole()
    {
        return $this->getProjectUsers()->select('role')->indexBy('user_id')->column();
    }

    public function getUsersId()
    {
        return array_keys($this->getUsersRole());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }
}
