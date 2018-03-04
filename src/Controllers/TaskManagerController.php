<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Controllers;

use App\Http\Controllers\Controller;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskManager;
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
            'tasks' => $this->task->with('project')->get()
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
        $this->task->create($data);

        return redirect()->route('laracms.tasks')->with('status', 'Task created!');
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
        return back()->with('status', 'Task updated.');
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
}