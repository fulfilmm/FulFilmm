<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Http\Request;
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

    public function render(Request $request)
    {
        $min=$request->min_amount??0;
        $max=$request->max_amount??null;
        $name=$request->name??null;
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
          if($request->name==null){
              if($max==null){
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
                          ->with(['company' => function($q) {
                              $q->withTrashed();
                          },'branch'
                              ,'zone','region'])
                          ->where('use_amount','>=',$min)
                          ->where('use_amount','<=',$max)
                          ->paginate(10),
                      'name'=>$name,'min'=>$min,'max'=>$max
                  ]);
              }
          }else{
              return view('livewire.customer-table', [
                  'customers' => Customer::where('name', 'like', '%'.$this->search_key.'%')
                      ->with(['company' => function($q) {
                          $q->withTrashed();
                      },'branch'
                          ,'zone','region'])
                      ->where('name','like','%'.$request->name.'%')
                      ->paginate(10),
                  'name'=>$name,'min'=>$min,'max'=>$max
              ]);
          }
        }else {
            if($request->name==null){
                if ($max == null) {
                    return view('livewire.customer-table', [
                        'customers' => Customer::where('name', 'like', '%' . $this->search_key . '%')
                            ->where('branch_id', Auth::guard('employee')->user()->office_branch_id)
                            ->with(['company' => function ($q) {
                                $q->withTrashed();
                            }])
                            ->where('region_id', $auth->region_id)
                            ->paginate(10),
                        'name'=>$name,'min'=>$min,'max'=>$max
                    ]);
                }else{
                    return view('livewire.customer-table', [
                        'customers' => Customer::where('name', 'like', '%'.$this->search_key.'%')
                            ->with(['company' => function($q) {
                                $q->withTrashed();
                            },'branch'
                                ,'zone','region'])
                            ->where('use_amount','>=',$min)
                            ->where('use_amount','<=',$max)
                            ->paginate(10),
                        'name'=>$name,'min'=>$min,'max'=>$max
                    ]);
                }
            }else{
                return view('livewire.customer-table', [
                    'customers' => Customer::where('name', 'like', '%'.$this->search_key.'%')
                        ->with(['company' => function($q) {
                            $q->withTrashed();
                        },'branch'
                            ,'zone','region'])
                        ->where('name','like','%'.$request->name.'%')
                        ->paginate(10),
                    'name'=>$name,'min'=>$min,'max'=>$max
                ]);
            }
        }
    }
}
