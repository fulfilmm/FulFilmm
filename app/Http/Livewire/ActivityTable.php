<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityTable extends Component
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
        return view('livewire.activity-table', [
            "activities" => $this->getActivities()
        ]);
    }

    protected function getActivities()
    {
        $login_employee = Auth::guard('employee')->user();
        switch ($login_employee->role) {
            case 'Manager':
                return Activity::with('employee', 'report_to_employee')
                                ->where('department_id', $login_employee->department->id)
                                ->where('title', 'like', '%' . $this->search_key . '%')
                                ->paginate(10);
                break;
            case 'Employee':
                return Activity::with('employee', 'report_to_employee')
                                ->where('employee_id', $login_employee->id)
                                ->where('title', 'like', '%' . $this->search_key . '%')
                                ->paginate(10);
            
            default:
                return Activity::with('employee', 'report_to_employee')->where('title', 'like', '%' . $this->search_key . '%')->paginate(10);
                break;
        }
    }
}
