<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Models;

use Illuminate\Database\Eloquent\Model;

class LaracmsTaskManager extends Model
{
    protected $fillable = ['project_id', 'title', 'description', 'creator_id'];

    protected $table = 'laracms_tasks';

    public function project()
    {
        return $this->belongsTo(LaracmsTaskManagerProject::class);
    }
}
