<?php

namespace Grundmanis\Laracms\Modules\TaskManager\Controllers;

use App\Http\Controllers\Controller;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskManagerProject;
use Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskManagerProjectEmployers;
use Grundmanis\Laracms\Modules\User\Models\LaracmsUser;
use Illuminate\Http\Request;

class TaskManagerProjectController extends Controller
{
    /**
     * @var LaracmsUser
     */
    private $users;

    /**
     * @var LaracmsTaskManagerProject
     */
    private $project;

    /**
     * @var LaracmsTaskManagerProjectEmployers
     */
    private $employers;

    /**
     * TaskManagerProjectController constructor.
     * @param LaracmsUser $users
     * @param LaracmsTaskManagerProject $project
     * @param LaracmsTaskManagerProjectEmployers $employers
     */
    public function __construct(
        LaracmsUser $users,
        LaracmsTaskManagerProject $project,
        LaracmsTaskManagerProjectEmployers $employers
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

        return redirect()->route('laracms.tasks.projects')->with('status', 'Project created!');
    }

    /**
     * @param LaracmsTaskManagerProject $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LaracmsTaskManagerProject $project)
    {
        return view('laracms.tasks::projects.form', [
            'project' => $project,
            'users' => $this->users->get()
        ]);
    }

    /**
     * @param LaracmsTaskManagerProject $project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LaracmsTaskManagerProject $project, Request $request)
    {
        $project->update($request->all());
        $project->employers()->sync($request->users);

        return back()->with('status', 'Project updated.');
    }

    /**
     * @param LaracmsTaskManagerProject $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LaracmsTaskManagerProject $project)
    {
        $project->delete();
        return redirect()->back()->with('status', 'Project deleted!');
    }
}