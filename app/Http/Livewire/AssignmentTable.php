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
        $login_employee = Auth::guard('employee')->id();
//        dd( Assignment::with('assigned_employees')->get());

        return view('livewire.assignment-table', [
            'customers' => Assignment::
//                ->where('department_id', $login_employee->department->id)
                where('title', 'like', '%' . $this->search_key . '%')
                ->paginate(10)
        ]);
    }
}
