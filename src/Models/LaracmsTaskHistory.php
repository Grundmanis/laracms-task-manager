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

    const STATUS_WORKING = 'working';
    const STATUS_OPEN = 'open';
    const STATUS_TESTING = 'testing';
    const STATUS_DONE = 'done';

    public function task()
    {
        return $this->hasOne(
            LaracmsTask::class
        );
    }
}
