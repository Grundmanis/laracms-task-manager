<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskManager;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskManagerHistory;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskManagerProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskManagerController extends Controller
{
    /**
     * @var LaracmsTaskManagerProject
     */
    private $project;

    /**
     * @var LaracmsTaskManager
     */
    private $task;

    /**
     * TaskManagerController constructor.
     * @param LaracmsTaskManagerProject $project
     * @param LaracmsTaskManager $task
     */
    public function __construct(LaracmsTaskManagerProject $project, LaracmsTaskManager $task)
    {
        $this->project = $project;
        $this->task = $task;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('laracms.tasks::tasks.index', [
            'tasks' => $this->task->with('project', 'history')->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('laracms.tasks::tasks.form', [
            'projects' => $this->project->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['creator_id'] = Auth::guard('laracms')->user()->id;
        $task = $this->task->create($data);

        $task->history()->create([
            'status' => $data['status'],
            'user_id' => Auth::guard('laracms')->user()->id,
            'minutes' => 0
        ]);

        if ($request->stay) {
            return back()->with('status', 'Task created.');
        }
        return redirect()->route('laracms.tasks')->with('status', 'Task created.');
    }

    /**
     * @param LaracmsTaskManager $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LaracmsTaskManager $task)
    {
        return view('laracms.tasks::tasks.form', [
            'projects' => $this->project->get(),
            'task' => $task
        ]);
    }

    /**
     * @param LaracmsTaskManager $task
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LaracmsTaskManager $task, Request $request)
    {
        $task->update($request->all());

        if($request->status != $task->getStatus())
        {
            if ($task->getStatus() == 'working')
            {

                $startTime = Carbon::parse($task->created_at);
                $finishTime = Carbon::now();

                $task->history()->create([
                    'status' => $request->status,
                    'user_id' => Auth::guard('laracms')->user()->id,
                    'minutes' => $startTime->diffInMinutes($finishTime)
                ]);
            } else {
                $task->history()->create([
                   'status' => $request->status,
                   'user_id' => Auth::guard('laracms')->user()->id,
                    'minutes' => 0
                ]);
            }
        }
        if ($request->stay) {
            return back()->with('status', 'Task updated.');
        }
        return redirect()->route('laracms.tasks')->with('status', 'Task updated.');
    }

    /**
     * @param LaracmsTaskManager $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LaracmsTaskManager $task)
    {
        $task->delete();
        return redirect()->back()->with('status', 'Task deleted!');
    }

    public function work(LaracmsTaskManager $task, Request $request)
    {
        if (!$first = $task->history()->orderByDesc('id')->first())
        {
            $task->history()->create([
               'status' => 'working',
               'user_id' => Auth::guard('laracms')->user()->id,
               'minutes' => 0
            ]);
        } else {
            if ($first->status == LaracmsTaskManagerHistory::STATUS_WORKING) {
                $startTime = Carbon::parse($first->created_at);
                $finishTime = Carbon::now();
                $task->history()->create([
                    'status' => LaracmsTaskManagerHistory::STATUS_OPEN,
                    'user_id' => Auth::guard('laracms')->user()->id,
                    'minutes' => $startTime->diffInMinutes($finishTime)
                ]);
            } else {
                $task->history()->create([
                    'status' => LaracmsTaskManagerHistory::STATUS_WORKING,
                    'user_id' => Auth::guard('laracms')->user()->id,
                    'minutes' => 0
                ]);
            }
        }

        return redirect()->back();
    }
}