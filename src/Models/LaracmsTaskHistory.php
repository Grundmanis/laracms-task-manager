<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Models;

use Grundmanis\Laracms\Modules\User\Models\LaracmsUser;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $employers
 */
class LaracmsTaskHistory extends Model
{
    protected $fillable = ['status', 'task_id', 'user_id', 'minutes'];

    protected $table = 'laracms_tasks_status_history';

    public function task()
    {
        return $this->hasOne(
            LaracmsTask::class
        );
    }
}
