<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Models;

use Illuminate\Database\Eloquent\Model;

class LaracmsTaskProjectEmployer extends Model
{
    protected $fillable = ['user_id', 'project_id'];

    public function projects()
    {
        return $this->belongsToMany(LaracmsTaskProject::class, 'project_id', 'user_id');
    }

}
