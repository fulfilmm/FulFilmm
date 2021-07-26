<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectTable extends Component
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
        return view('livewire.project-table', [
            'projects' => Project::with('creator')->where('title', 'like', "%$this->search_key%")
                ->paginate(10)
        ]);
    }


}
