<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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
            'projects' => Project::whereHas('task', function(Builder $query){
                $query->whereHas('assigned_employees', function(Builder $query){
                    $query->where('project_task_id', Auth::id());
                });
            })
            ->orWhereHas('ownedBy', function(Builder $query){
                $query->where('id', Auth::id());
            })
            ->orWhereHas('creator', function(Builder $query){
                $query->where('id', Auth::id());    
            })
            ->orWhereHas('leadedBy', function(Builder $query){
                $query->where('id', Auth::id());    
            })
            ->orWhereHas('proposedTo', function(Builder $query){
                $query->where('id', Auth::id());    
            })
            ->paginate(10)
        ]);
    }
    
    
}
