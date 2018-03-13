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

    /**
     * @var int
     */
    public $minutes = 0;

    const STATUS_NEED_INFORMATION = 'need_information';
    const STATUS_TESTING = 'testing';
    const STATUS_DONE = 'done';
    const STATUS_WORKING = 'in_progress';
    const STATUS_OPEN = 'open';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(LaracmsTaskProject::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(LaracmsTaskHistory::class, 'task_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFiltered($query)
    {
        foreach (request()->all() as $filter => $value) {
            if (!$value) {
                continue;
            }
            $query->where($filter, $value);
        }

        return $query;
    }

    /**
     * @return mixed|string
     */
    public function getStatus()
    {
        if (!$this->status) {
            $this->getLastHistory();
            $this->status = $this->lastHistory ? $this->lastHistory->status : 'open';
        }
        return $this->status;
    }

    /**
     * @return int|mixed
     */
    public function getTime()
    {
        if (!$this->minutes) {
            $this->minutes = $this->history()->sum('minutes');
        }
        return $this->minutes;
    }

    /**
     * @return float
     */
    public function getHours()
    {
        return round($this->getTime() / 60, 2);
    }

    /**
     * @return LaracmsTaskHistory|Model|null|static
     */
    public function getLastHistory()
    {
        if (!$this->lastHistory) {
            $this->lastHistory = $this->history()->orderByDesc('id')->first();
        }
        return $this->lastHistory;
    }

    /**
     * @param null $key
     * @return array|mixed
     */
    public static function getStatuses($key = null)
    {
        $statuses = [
            self::STATUS_NEED_INFORMATION => 'Need information',
            self::STATUS_OPEN             => 'Open',
            self::STATUS_WORKING          => 'In progress',
            self::STATUS_DONE             => 'Done',
            self::STATUS_TESTING          => 'Testing',
        ];

        if ($key) {
            return $statuses[$key];
        }

        return $statuses;
    }
}
