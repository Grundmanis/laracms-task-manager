<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTask;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskHistoryController extends Controller
{
    /**
     * @param LaracmsTask $task
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function work(LaracmsTask $task, Request $request)
    {
        if (!$first = $task->history()->orderByDesc('id')->first())
        {
            $task->history()->create([
                'status' => 'working',
                'user_id' => Auth::guard('laracms')->user()->id,
                'minutes' => 0
            ]);
        } else {
            if ($first->status == LaracmsTaskHistory::STATUS_WORKING) {
                $startTime = Carbon::parse($first->created_at);
                $finishTime = Carbon::now();
                $task->history()->create([
                    'status' => LaracmsTaskHistory::STATUS_OPEN,
                    'user_id' => Auth::guard('laracms')->user()->id,
                    'minutes' => $startTime->diffInMinutes($finishTime)
                ]);
            } else {
                $task->history()->create([
                    'status' => LaracmsTaskHistory::STATUS_WORKING,
                    'user_id' => Auth::guard('laracms')->user()->id,
                    'minutes' => 0
                ]);
            }
        }

        return redirect()->back();
    }
}