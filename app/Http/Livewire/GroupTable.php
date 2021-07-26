<?php

namespace App\Http\Livewire;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;
class GroupTable extends Component
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
        return view('livewire.group-table', [
            'groups' => Group::where('name', 'like', "%$this->search_key%")
            ->paginate(10)
            ]);
    }
}
