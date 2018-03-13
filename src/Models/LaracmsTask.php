<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Models;

use Illuminate\Database\Eloquent\Model;

class LaracmsTask extends Model
{
    protected $fillable = ['project_id', 'title', 'description', 'creator_id', 'status'];

    protected $table = 'laracms_tasks';

    /**
     * @var LaracmsTaskHistory
     */
    public $lastHistory = null;

    public $minutes = 0;

    const STATUS_WORKING = 'in_progress';
    const STATUS_OPEN = 'open';
    const STATUS_TESTING = 'testing';
    const STATUS_DONE = 'done';
    const STATUS_NEED_INFORMATION = 'need_information';

    public function project()
    {
        return $this->belongsTo(LaracmsTaskProject::class);
    }

    public function history()
    {
        return $this->hasMany(LaracmsTaskHistory::class, 'task_id');
    }

    public function scopeFiltered($query)
    {
        foreach (request()->all() as $filter => $value)
        {
            if (!$value) continue;
            $query->where($filter, $value);
        }

        return $query;
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

    public static function getStatuses($key = null)
    {
        $statuses = [
            self::STATUS_NEED_INFORMATION => 'Need information',
            self::STATUS_OPEN => 'Open',
            self::STATUS_WORKING => 'In progress',
            self::STATUS_DONE => 'Done',
            self::STATUS_TESTING => 'Testing',
        ];

        if ($key) {
            return $statuses[$key];
        }

        return $statuses;
    }
}
