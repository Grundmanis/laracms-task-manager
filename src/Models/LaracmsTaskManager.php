<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Models;

use Illuminate\Database\Eloquent\Model;

class LaracmsTaskManager extends Model
{
    protected $fillable = ['project_id', 'title', 'description', 'creator_id'];

    protected $table = 'laracms_tasks';

    public $status = null;

    /**
     * @var LaracmsTaskManagerHistory
     */
    public $lastHistory = null;

    public $minutes = 0;

    public function project()
    {
        return $this->belongsTo(LaracmsTaskManagerProject::class);
    }

    public function history()
    {
        return $this->hasMany(LaracmsTaskManagerHistory::class, 'task_id');
    }


    public function getStatus()
    {
        if (!$this->status) {
            $this->getLastHistory();
            $this->status = $this->lastHistory ? $this->lastHistory->status : 'open';
        }
        return $this->status;
    }

    public function getTime()
    {
        if (!$this->minutes) {
            $this->minutes = $this->history()->sum('minutes');
        }
        return $this->minutes;
    }

    public function getHours()
    {
        return round($this->getTime() / 60, 2);
    }

    public function getLastHistory()
    {
        if (!$this->lastHistory) {
            $this->lastHistory = $this->history()->orderByDesc('id')->first();
        }
        return $this->lastHistory;
    }
}
