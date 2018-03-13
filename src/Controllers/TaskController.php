<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTask;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskHistory;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * @var LaracmsTaskProject
     */
    private $project;

    /**
     * @var LaracmsTask
     */
    private $task;

    /**
     * TaskManagerController constructor.
     * @param LaracmsTaskProject $project
     * @param LaracmsTask $task
     */
    public function __construct(LaracmsTaskProject $project, LaracmsTask $task)
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
        return redirect()->route('laracms.task')->with('status', 'Task created.');
    }

    /**
     * @param LaracmsTask $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LaracmsTask $task)
    {
        return view('laracms.tasks::tasks.form', [
            'projects' => $this->project->get(),
            'task' => $task
        ]);
    }

    /**
     * @param LaracmsTask $task
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LaracmsTask $task, Request $request)
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
        return redirect()->route('laracms.task')->with('status', 'Task updated.');
    }

    /**
     * @param LaracmsTask $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LaracmsTask $task)
    {
        $task->delete();
        return redirect()->back()->with('status', 'Task deleted!');
    }
}