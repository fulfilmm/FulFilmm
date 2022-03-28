<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Invoice;
use App\Models\SaleTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;

class SaleTargetController extends Controller
{
    public function index()
    {
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', "Jul", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthly = [];
        $monthlysaletarget = [];
        $current_year = date('Y') + 0;
        $yearly = [];
        $yearly_target=[];
        $all_income = [];
        $year = [$current_year - 2,$current_year - 1,$current_year,$current_year + 1, $current_year +2];
        if(Auth::guard('employee')->user()->role->name=='CEO'||Auth::guard('employee')->user()->role->name=='Manager'||Auth::guard('employee')->user()->role->name=='Super Admin')
        {
            foreach ($month as $key => $value) {
                $grand_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->get();
                $monthly[$value] = $grand_total[0];
                $sale_target = DB::table("sale_targets")
                    ->select(DB::raw("SUM(target_sale) as target"))
                    ->where('month', $value)->where('year', date('Y'))
                    ->get();
                $monthlysaletarget[$value] = $sale_target[0]??0;

            }
            foreach ($year as $key => $value) {
                $grand_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date', $value)
                    ->get();
                $yearly[$value] = $grand_total[0];
                $yearly_sale_target = DB::table("sale_targets")
                    ->select(DB::raw("SUM(target_sale) as target"))
                    ->where('year',$value)
                    ->get();
                $yearly_target[$value]=$yearly_sale_target[0];
            }
            $income = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereYear('transaction_date', date('Y'))->whereMonth('transaction_date',date('M'))
                ->get();
            $all_income[date('Y')] = $income[0];
            $revenue = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereMonth('transaction_date', date('m'))
                ->get();
            $all_income[date('Y')] = $income[0];
            $sale_target = DB::table("sale_targets")
                ->select(DB::raw("SUM(target_sale) as target"))
                ->where('month', date('M'))->where('year', date('Y'))
                ->get();
            $invoice_revenue = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereMonth('transaction_date', date('m'))->where('invoice_id','!=',null)
                ->get();
            $remaining=$monthly[date('M')]->total-$invoice_revenue[0]->total;
        }else{
            //monthly
            $auth=Auth::guard('employee')->user();
            foreach ($month as $key => $value) {
                $grand_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->where('emp_id',$auth->id)
                    ->get();
                $monthly[$value] = $grand_total[0];
                $sale_target = DB::table("sale_targets")
                    ->select(DB::raw("SUM(target_sale) as target"))
                    ->where('month', $value)->where('year', date('Y'))->where('emp_id',$auth->id)
                    ->get();
                $monthlysaletarget[$value] = $sale_target[0];

            }

            //Yearly
            foreach ($year as $key => $value) {
                $grand_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('invoice_date', $value)->where('emp_id',$auth->id)
                    ->get();
                $yearly[$value] = $grand_total[0];
                $yearly_sale_target = DB::table("sale_targets")
                    ->select(DB::raw("SUM(target_sale) as target"))
                    ->where('year',$value)->where('emp_id',$auth->id)
                    ->get();
                $yearly_target[$value]=$yearly_sale_target[0];
            }
            $income = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereYear('transaction_date', date('Y'))->whereMonth('transaction_date',date('M'))
                ->get();
            $all_income[date('Y')] = $income[0];
            $revenue = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereMonth('transaction_date', date('m'))->where('emp_id',$auth->id)
                ->get();
            $all_income[date('Y')] = $income[0];
            $sale_target = DB::table("sale_targets")
                ->select(DB::raw("SUM(target_sale) as target"))
                ->where('month', date('M'))->where('year', date('Y'))->where('emp_id',$auth->id)
                ->get();
            $invoice_revenue = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereMonth('transaction_date', date('m'))->where('invoice_id','!=',null)
                ->where('emp_id',$auth->id)
                ->get();
            $remaining=$monthly[date('M')]->total-$invoice_revenue[0]->total;
        }



//        dd($yearly_target);





        return view('sale.dashboard', compact('monthly', 'yearly', 'year', 'all_income', 'sale_target', 'monthlysaletarget', 'revenue','remaining','yearly_target','month'));
    }

    public function create()
    {
        $employee = Employee::where('department_id', 1)->pluck('name', 'id')->all();
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', "Jul", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $mothly_targets = SaleTarget::with('employee')->where('year', date('Y'))->get();
        $year=[date('Y')+0,date('Y')+1,date('Y')+2];

//        dd($mothly_targets);
        return view('sale.monthly_target', compact('employee', 'month', 'mothly_targets','year'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['emp_id' => 'required', 'target_sale' => 'required', 'month' => 'required']);
        foreach ($request->emp_id as $emp_id) {
            $have_beenassing = SaleTarget::where('month', $request->month)->where('emp_id', $emp_id)->where('year',$request->year)->first();
            if ($have_beenassing == null) {
                $sale_target = new SaleTarget();
                $sale_target->emp_id = $emp_id;
                $sale_target->target_sale = $request->target_sale;
                $sale_target->month = $request->month;
                $sale_target->year = $request->year;
                $sale_target->save();

            }

        }
        return redirect(route('saletargets.create'));

    }

    public function edit($id)
    {
        $target = SaleTarget::where('id', $id)->first();
        $employee = Employee::where('department_id', 1)->pluck('name', 'id')->all();
        $month = ['Jan', 'Feb', 'March', 'April', 'May', 'June', "July", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return view('sale.target_edit', compact('target', 'month', 'employee'));
    }

    public function update(Request $request, $id)
    {
        $sale_target = SaleTarget::where('id', $id)->first();
        $sale_target->emp_id = $request->emp_id;
        $sale_target->target_sale = $request->target_sale;
        $sale_target->month = $request->month;
        $sale_target->year = $request->year;
        $sale_target->update();
        return redirect(route('saletargets.create'));
    }
    public function search(Request $request){
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', "Jul", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthly = [];
        $monthlysaletarget = [];
        foreach ($month as $key => $value) {
            $grand_total = DB::table("invoices")
                ->select(DB::raw("SUM(grand_total) as total"))
                ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date',$request->year)
                ->get();
            $monthly[$value] = $grand_total[0];

            $sale_target = DB::table("sale_targets")
                ->select(DB::raw("SUM(target_sale) as target"))
                ->where('month', $value)->where('year',$request->year)
                ->get();
            $monthlysaletarget[$value] = $sale_target[0];

        }
        $current_year = date('Y') + 0;
        $yearly = [];
        $yearly_target=[];
        $year = [$current_year - 2,$current_year - 1,$current_year,$current_year + 1, $current_year +2];
        foreach ($year as $key => $value) {
            $grand_total = DB::table("invoices")
                ->select(DB::raw("SUM(grand_total) as total"))
                ->whereYear('invoice_date', $value)
                ->get();
            $yearly[$value] = $grand_total[0];
            $yearly_sale_target = DB::table("sale_targets")
                ->select(DB::raw("SUM(target_sale) as target"))
                ->where('year',$value)
                ->get();
            $yearly_target[$value]=$yearly_sale_target[0];
        }
//        dd($yearly_target);
        $all_income = [];
        $income = DB::table("revenues")
            ->select(DB::raw("SUM(amount) as total"))
            ->whereYear('transaction_date',$request->year)
            ->get();
        $all_income[date('Y')] = $income[0];
        $revenue = DB::table("revenues")
            ->select(DB::raw("SUM(amount) as total"))
            ->whereMonth('transaction_date',$request->month)
            ->get();
        $all_income[date('Y')] = $income[0];
        $sale_target = DB::table("sale_targets")
            ->select(DB::raw("SUM(target_sale) as target"))
            ->where('month',$request->month)->where('year',$request->year)
            ->get();
        $invoice_revenue = DB::table("revenues")
            ->select(DB::raw("SUM(amount) as total"))
            ->whereMonth('transaction_date',$request->month)->where('invoice_id','!=',null)
            ->get();
        $remaining=$monthly[$request->month]->total-$invoice_revenue[0]->total;
        $search_month=$request->month;
        $searchYear=$request->year;
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', "Jul", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
//        dd($search_month);
        return view('sale.dashboard', compact('monthly', 'yearly', 'year', 'all_income', 'sale_target', 'monthlysaletarget', 'revenue','remaining','yearly_target','search_month','month','searchYear'));

    }
}
