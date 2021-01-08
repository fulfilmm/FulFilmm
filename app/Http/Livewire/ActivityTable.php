<?php

namespace App\Http\Livewire;

use App\Models\Activity;
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
<<<<<<< Updated upstream
            "activities" => Activity::where('name', 'like', '%'.$this->search_key.'%')->paginate(10)
=======
            "activities" => Activity::with('employee', 'report_to_employee')->where('title', 'like', '%'.$this->search_key.'%')->paginate(10)
>>>>>>> Stashed changes
        ]);
    }
}
