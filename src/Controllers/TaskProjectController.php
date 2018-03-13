<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Controllers;

use App\Http\Controllers\Controller;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskProject;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskProjectEmployer;
use Grundmanis\Laracms\Modules\User\Models\LaracmsUser;
use Illuminate\Http\Request;

class TaskProjectController extends Controller
{
    /**
     * @var LaracmsUser
     */
    private $users;

    /**
     * @var LaracmsTaskProject
     */
    private $project;

    /**
     * @var LaracmsTaskProjectEmployer
     */
    private $employers;

    /**
     * TaskManagerProjectController constructor.
     * @param LaracmsUser $users
     * @param LaracmsTaskProject $project
     * @param LaracmsTaskProjectEmployer $employers
     */
    public function __construct(
        LaracmsUser $users,
        LaracmsTaskProject $project,
        LaracmsTaskProjectEmployer $employers
    )
    {
        $this->users = $users;
        $this->project = $project;
        $this->employers = $employers;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('laracms.tasks::projects.index', [
            'projects' => $this->project->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('laracms.tasks::projects.form', [
            'users' => $this->users->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $project = $this->project->create($request->all());
        $project->employers()->sync($request->users);

        return redirect()->route('laracms.task.project')->with('status', 'Project created!');
    }

    /**
     * @param LaracmsTaskProject $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LaracmsTaskProject $project)
    {
        return view('laracms.tasks::projects.form', [
            'project' => $project,
            'users' => $this->users->get()
        ]);
    }

    /**
     * @param LaracmsTaskProject $project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LaracmsTaskProject $project, Request $request)
    {
        $project->update($request->all());
        $project->employers()->sync($request->users);

        return back()->with('status', 'Project updated.');
    }

    /**
     * @param LaracmsTaskProject $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LaracmsTaskProject $project)
    {
        $project->delete();
        return redirect()->back()->with('status', 'Project deleted!');
    }
}