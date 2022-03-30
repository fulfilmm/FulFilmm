<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\RevenueBudget;
use App\Models\RevenueBudgetItem;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reve_budget=RevenueBudget::all();
        return view('RevenueBudget.index',compact('reve_budget'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coas=ChartOfAccount::all();
        return view('RevenueBudget.create',compact('coas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request,[
            'name'=>'required',
            'year'=>'required'
        ]);
//        $is_exists=RevenueBudget::where('category_id',$request->category_id)->where('year',$request->year)->where('month',$request->month)->first();
//        if($is_exists==null){
//            $actual= DB::table("revenues")
//                ->select(DB::raw("SUM(amount) as total"))
//                ->where('category',$request->category_id)->where('approve',1)
//                ->get();
//            $data=$request->all();
//            $data['actual']=$actual[0]->total??0;
            $data['name']=$request->name;
            $data['year']=$request->year;

            $rev_budget=RevenueBudget::create($data);
            $coas=ChartOfAccount::all();
            foreach ($coas as $item){
                $data['revenue_budget_id']=$rev_budget->id;
                $data['coa_id']=$item->id;
                $data['cost_center']=$request->cost_center[$item->id];
                $data['department']=$request->dept[$item->id];
                $data['total']=$request->total[$item->id]??0;
                $data['jan']=$request->jan[$item->id]??0;
                $data['feb']=$request->feb[$item->id]??0;
                $data['mar']=$request->mar[$item->id]??0;
                $data['apr']=$request->apr[$item->id]??0;
                $data['may']=$request->may[$item->id]??0;
                $data['jun']=$request->jun[$item->id]??0;
                $data['jul']=$request->jul[$item->id]??0;
                $data['aug']=$request->aug[$item->id]??0;
                $data['sep']=$request->sep[$item->id]??0;
                $data['oct']=$request->oct[$item->id]??0;
                $data['nov']=$request->nov[$item->id]??0;
                $data['dec']=$request->dec[$item->id]??0;
                RevenueBudgetItem::create($data);
            }
            return redirect('revenuebudget')->with('success','Added New Revenue Budget!');
//        }else{
//            return redirect('revenuebudget')->with('error','Already Exists!');
//        }

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $revenue_budget=RevenueBudget::where('id',$id)->firstOrFail();
        $items=RevenueBudgetItem::with('coa')->where('revenue_budget_id',$id)->get();
        return view('RevenueBudget.show',compact('revenue_budget','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $revenue_budget=RevenueBudget::where('id',$id)->firstOrFail();
        $items=RevenueBudgetItem::with('coa')->where('revenue_budget_id',$id)->get();
        return view('RevenueBudget.edit',compact('revenue_budget','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['name']=$request->name;
        $data['year']=$request->year;

        $rev_budget=RevenueBudget::where('id',$id)->first();
        $rev_budget->update($data);
        $coas=ChartOfAccount::all();
        foreach ($coas as $item) {
            $data['revenue_budget_id'] = $rev_budget->id;
            $data['coa_id'] = $item->id;
            $data['cost_center'] = $request->cost_center[$item->id];
            $data['department'] = $request->dept[$item->id];
            $data['total'] = $request->total[$item->id] ?? 0;
            $data['jan'] = $request->jan[$item->id] ?? 0;
            $data['feb'] = $request->feb[$item->id] ?? 0;
            $data['mar'] = $request->mar[$item->id] ?? 0;
            $data['apr'] = $request->apr[$item->id] ?? 0;
            $data['may'] = $request->may[$item->id] ?? 0;
            $data['jun'] = $request->jun[$item->id] ?? 0;
            $data['jul'] = $request->jul[$item->id] ?? 0;
            $data['aug'] = $request->aug[$item->id] ?? 0;
            $data['sep'] = $request->sep[$item->id] ?? 0;
            $data['oct'] = $request->oct[$item->id] ?? 0;
            $data['nov'] = $request->nov[$item->id] ?? 0;
            $data['dec'] = $request->dec[$item->id] ?? 0;
            $item = RevenueBudgetItem::where('revenue_budget_id', $id)->first();
            $item->update($data);
            return redirect(route('revenuebudget.show',$id))->with('success','Updated Successful!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
