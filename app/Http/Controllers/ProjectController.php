<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Group;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectTaskComment;
use App\Repositories\Contracts\ProjectContract;
use Carbon\Carbon;
use DeepCopy\Matcher\PropertyNameMatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    private $projectContract;

    public function __construct(ProjectContract $projectContract)
    {
        $this->projectContract = $projectContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        
        $employees = Employee::all()->pluck('name', 'id')->all();
        $employee_without_user = Employee::where('id', '!=', Auth::id())->pluck('name', 'id')->all();
        return view('project.index', compact(['employees', 'employee_without_user']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //

        $request['start_date'] = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $request['end_date'] = Carbon::createFromFormat('d/m/Y', $request->end_date);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date|after_or_equal:today',
        ]);

        $data = $request->all();
        $data['created_by'] = loginUser()->id;
        // $data['start_date'] = Carbon::createFromFormat('d/m/Y', $request->start_date);
        // $data['end_date'] = Carbon::createFromFormat('d/m/Y', $request->end_date);


        $project = Project::where('title', $request->title)->first();
        if (!$project) {
            $this->projectContract->create($data);
            $message = 'Project created successfully';
        } else {
            $message = 'The name you give already exists';
        }
        return redirect('projects')->with('error', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Project $project, $task_id = null)
    {
        //
        $employees = Employee::all()->pluck('name', 'id')->all();
        $project = $this->projectContract->getProjectsWithTasks($project->id);

        if ($project) {
            $messages = ProjectTaskComment::where('project_task_id', $task_id)->get();
            return view('project.show', compact('project', 'messages', 'employees', 'task_id'));
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Project $project)
    {
        //
        $project->delete();
        return redirect('projects')->with('success', __('alert.delete_success'));
    }
}
