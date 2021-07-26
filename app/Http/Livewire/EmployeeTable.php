<?php

namespace App\Http\Livewire;

use App\Models\Employee;
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

        return view('livewire.employee-table', [
            'employees' => Employee::where('name', 'like', "%$this->search_key%")
            ->with(['department' => function($q) {
                $q->withTrashed();
            }])
            ->paginate(10)
            ]);
        }
    }
