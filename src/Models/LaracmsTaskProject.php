<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Models;

use Grundmanis\Laracms\Modules\User\Models\LaracmsUser;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $employers
 */
class LaracmsTaskProject extends Model
{
    protected $fillable = ['name'];

    public function employers()
    {
        return $this->belongsToMany(
            LaracmsUser::class,
            'laracms_task_project_employers',
            'project_id',
            'user_id'
        );
    }
}
