<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RolesTable extends Component
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

        return view('livewire.roles-table', [
            'roles' => Role::where('name', 'like', "%$this->search_key%")
                ->with(['permissions'])
                ->paginate(10)
        ]);
    }
}
