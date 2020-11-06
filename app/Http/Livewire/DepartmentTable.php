<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentTable extends Component
{
    use WithPagination;

    private $search_key = "";

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.department-table', [
            "departments" => Department::where('name', 'like', '%'.$this->search_key.'%')->paginate(10)
        ]);
    }
}
