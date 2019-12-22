<?php
/**
 * Created by PhpStorm.
 * User: Ghost
 * Date: 18.12.2019
 * Time: 15:54
 */
namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AssignRoleEvent extends Event
{
    public $project;
    public $user;
    public $role;

    public function dump () {
        return ['project' => $this->project->id, 'user' => $this->user->id, 'role' => $this->role ];
    }


}

class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);

    }
}