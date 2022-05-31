<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\OfficeBranch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeTable extends Component
{
    use WithPagination;
    public $search_key = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearchKey()
    {
        $this->resetPage();
    }

    public function render()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'||$auth->role->name=='Hr Manager'){
            return view('livewire.employee-table', [
                'employees' => Employee::where('name', 'like', "%$this->search_key%")
                    ->with(['department' => function ($q) {
                        $q->withTrashed();
                    },'branch'=>function($q){
                        $q->get();
                    }],'region','head')
                    ->paginate(20)
            ]);
        }else{
            return view('livewire.employee-table', [
                'employees' => Employee::where('name', 'like', "%$this->search_key%")
                    ->with(['department' => function ($q) {
                        $q->withTrashed();
                    },'branch'=>function($q){
                        $q->get();
                    }],'region','head')->where('office_branch_id',Auth::guard('employee')->user()->office_branch_id)
                    ->paginate(20)
            ]);
        }
    }
}
