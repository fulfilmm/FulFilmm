<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssigmentController extends Controller
{
    public function index(){
        $auth=Auth::guard('employee')->user();
        $role=$auth->role->name;
        switch ($auth->role->name){
            case 'CEO':
                $todo_list=Assignment::with('owner','responsible_emp')->get();
                $employees=Employee::all();

                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case 'Super Admin':
                $todo_list=Assignment::with('owner','responsible_emp')->get();
                $employees=Employee::all();
                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case 'Sales Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case 'Finance Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case 'Customer Service Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case 'HR Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees'));
                break;
            case 'Stock Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case'General Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees','role'));
                break;
            case 'Car Admin':
                $todo_list=Assignment::with('owner','responsible_emp')->where('assignee_id',$auth->id)->get();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.index',compact('todo_list','employees'));
                break;
            default:
                $todo_list=Assignment::with('owner','responsible_emp')->where('emp_id',$auth->id)->get();
                $employees=Employee::where('id',$auth->id)->get();
                return view('Assignment.index',compact('todo_list','employees','role'));
        }

    }
    public function create(){


    }
    public function store(Request $request){

        $this->validate($request,[
           'title'=>'required',
           'emp_id'=>'required',
           'assignee_id'=>'required',
           'description'=>'nullable',
           'priority'=>'required',
           'status'=>'nullable',
           'end_date'=>'required',
           'attach'=>'nullable'
        ]);
        Assignment::create($request->all());
        return redirect('assignments')->with('success','Add new todo list');

    }
    public function edit($id){
        $auth=Auth::guard('employee')->user();
        switch ($auth->role->name){
            case 'CEO':
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::all();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'Super Admin':
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::all();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'Sales Manager':
                 $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'Finance Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'Customer Service Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'HR Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'Stock Manager':
               $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case'General Manager':
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            case 'Car Admin':
                 $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('department_id',$auth->department_id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
                break;
            default:
                $todo_list=Assignment::with('owner','responsible_emp')->where('id',$id)->firstOrFail();
                $employees=Employee::where('id',$auth->id)->get();
                return view('Assignment.edit',compact('todo_list','employees'));
        }
    }
    public function update(Request $request,$id){
        $todo=Assignment::where('id',$id)->first();
        $todo->progress=$request->progress;
        $todo->title=$request->title;
        $todo->description=$request->description;
        $todo->status=$request->status;
        $todo->priority=$request->priority;
        $todo->end_date=$request->end_date;
        $todo->emp_id=$request->emp_id;
        $todo->assignee_id=$request->assignee_id;
        $todo->update();

        return redirect('assignments')->with('success','Task Updated');
    }
}
