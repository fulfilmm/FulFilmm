<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyTable extends Component
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

        return view('livewire.company-table', [
            'companies' => Company::where('name', 'like', "%$this->search_key%")->paginate(10)
        ]);
    }
}
