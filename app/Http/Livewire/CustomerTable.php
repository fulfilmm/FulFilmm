<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
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
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            return view('livewire.customer-table', [
                'customers' => Customer::where('name', 'like', '%'.$this->search_key.'%')
                    ->with(['company' => function($q) {
                        $q->withTrashed();
                    },'branch'
                    ,'zone','region'])
                    ->paginate(10)
            ]);
        }else{
            return view('livewire.customer-table', [
                'customers' => Customer::where('name', 'like', '%'.$this->search_key.'%')
                    ->where('branch_id',Auth::guard('employee')->user()->office_branch_id)
                    ->with(['company' => function($q) {
                        $q->withTrashed();
                    }])
                    ->where('region_id',$auth->region_id)
                    ->paginate(10)
            ]);
        }
    }
}
