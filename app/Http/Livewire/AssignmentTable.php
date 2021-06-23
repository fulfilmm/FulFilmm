<?php

namespace App\Http\Livewire;

use App\Models\Assignment;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AssignmentTable extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    public $search_key = "";
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $login_employee_id = Auth::guard('employee')->id();
        
        
        return view('livewire.assignment-table', [
            'assignments' => Assignment::with('assigned_employees', 'assignedBy', 'assignedBy.department')
            ->withCount(['assignment_tasks as task_done' => function ($q) {
                $q->where('status', 1);
            }])
            ->withCount(['assignment_tasks as total_tasks'])
            ->where('assigned_by', $login_employee_id)
            ->orWhereHas('assigned_employees', function ($q) use ($login_employee_id) {
                $q->where('employee_id', $login_employee_id);
            })
            ->where('title', 'like', '%' . $this->search_key . '%')
            ->paginate(10)
        ]);
    }
    
}
