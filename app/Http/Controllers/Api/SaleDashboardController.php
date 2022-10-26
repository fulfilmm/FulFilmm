<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Approvalrequest;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\Meetingmember;
use App\Models\MinutesAssign;
use App\Models\Revenue;
use App\Models\SaleActivity;
use App\Models\ticket;
use App\Models\ticket_follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleDashboardController extends Controller
{
    public function dashboard(Request $request){
        $user=Auth::guard('api')->user();
        $id=Auth::id();

        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', "Jul", 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthly = [];
        $cos=[];
        $monthlysaletarget = [];
        $current_year = date('Y') + 0;
        $yearly = [];
        $yearly_target=[];
        $all_income = [];
        $receivable=[];
        $payable=[];
        $gp=[];
        $year = [$current_year - 2,$current_year - 1,$current_year,$current_year + 1, $current_year +2];
        if(Auth::guard('api')->user()->role->name=='CEO'||Auth::guard('api')->user()->role->name=='Manager'||Auth::guard('api')->user()->role->name=='Super Admin')
        {
            foreach ($month as $key => $value) {
                $grand_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->where('cancel',0)
                    ->get();
                $monthly[$value] = $grand_total[0];
                $sale_target = DB::table("sale_targets")
                    ->select(DB::raw("SUM(target_sale) as target"))
                    ->where('month', $value)->where('year', date('Y'))
                    ->get();
                $monthlysaletarget[$value] = $sale_target[0]??0;
                $cost_of_sale=DB::table('invoices')
                    ->select(DB::raw("SUM(invoice_cos) as total"))
                    ->where('cancel',0)
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->get();
                $cos[$value]=$cost_of_sale[0]->total??0;
                $gp[$value]=$monthly[$value]->total-$cos[$value];
                $monthly_payable=DB::table('purchase_orders')
                    ->select(DB::raw("SUM(payable_amount) as total"))
                    ->whereMonth('created_at', $key + 1)->whereYear('created_at', date('Y'))
                    ->get();
                $monthly_receiable = DB::table("invoices")
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->where('cancel',0)
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->get();
                $receivable[$value]=$monthly_receiable[0]->total??0;

                $payable[$value]=$monthly_payable[0]->total??0;

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
            $total_receivable = DB::table("invoices")
                ->select(DB::raw("SUM(due_amount) as total"))
                ->where('cancel',0)
                ->get();
        }else{
            //monthly
            $auth=Auth::guard('api')->user();
            foreach ($month as $key => $value) {
                $grand_total = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->where('emp_id',$auth->id)
                    ->where('cancel',0)
                    ->get();
                $monthly[$value] = $grand_total[0];
                $sale_target = DB::table("sale_targets")
                    ->select(DB::raw("SUM(target_sale) as target"))
                    ->where('month', $value)->where('year', date('Y'))->where('emp_id',$auth->id)
                    ->get();
                $monthlysaletarget[$value] = $sale_target[0];
                $cost_of_sale=DB::table('invoices')
                    ->select(DB::raw("SUM(invoice_cos) as total"))
                    ->where('cancel',0)
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->where('emp_id',Auth::guard('api')->user()->id)
                    ->get();
                $monthly_payable=DB::table('purchase_orders')
                    ->select(DB::raw("SUM(payable_amount) as total"))
                    ->whereMonth('created_at', $key + 1)->whereYear('created_at', date('Y'))
                    ->get();
                $monthly_receiable = DB::table("invoices")
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->where('cancel',0)
                    ->whereMonth('invoice_date', $key + 1)->whereYear('invoice_date', date('Y'))
                    ->get();

                $cos[$value]=$cost_of_sale[0]->total??0;
                $gp[$value]=$monthly[$value]->total-$cos[$value];
                $receivable[$value]=$monthly_receiable[0]->total??0;

                $payable[$value]=$monthly_payable[0]->total??0;

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
            $total_receivable = DB::table("invoices")
                ->select(DB::raw("SUM(due_amount) as total"))
                ->where('cancel',0)
                ->get();
            $income = DB::table("revenues")
                ->select(DB::raw("SUM(amount) as total"))
                ->whereYear('transaction_date', date('Y'))->whereMonth('transaction_date',date('M'))
                ->get();
            $all_income[date('Y')] = $income[0];
            $all_income[date('Y')] = $income[0];

        }
        $meeting=Meetingmember::with('meeting')->where('member_id',$user->id)->count();
        $follow_ticket=ticket_follower::where('emp_id',$user->id)->count();
//          dd($meeting);
        $assignment=MinutesAssign::where('emp_id',$user->id)->count();
        $group=Group::whereHas('employees', function ($query) use ($id) {
            $query->where('employee_id', $id);
        })->count();
        $requestation=Approvalrequest::where('emp_id',Auth::guard('api')->user()->id)->count();
        $sale_activity=SaleActivity::where('emp_id',Auth::guard('api')->user()->id)->count();
        $customer=Customer::where('region_id',Auth::guard('api')->user()->region_id)->count();
        $saleMan_invoice=Invoice::wheremonth('invoice_date',date('m'))->where('emp_id',$user->id)->count();
        $myticket=ticket::where('created_emp_id',$user->id)->count();
        $follow_ticket=ticket_follower::where('emp_id',$user->id)->count();
        $emp_ticket=$myticket+$follow_ticket;
        $revenue=Revenue::with('invoice')->where('invoice_id','!=',null)->where('approve',1)->get();
        $transferred_amount=0;
        foreach ($revenue as $inv_item){
            if($inv_item->invoice->emp_id==Auth::guard('api')->user()->id){
                $transferred_amount+=$inv_item->amount;
            }
        }
        $stock_balance=DB::table("stocks")
            ->select(DB::raw("SUM(stock_balance) as total"))
            ->where('warehouse_id',Auth::guard('api')->user()->warehouse_id)
            ->get();
        $emp_expense=DB::table("emp_expenses")
            ->select(DB::raw("SUM(amount) as total"))
            ->where('emp_id',Auth::guard('api')->user()->id)
            ->get();
        $monthly_receiable = DB::table("invoices")
            ->select(DB::raw("SUM(due_amount) as total"))
            ->where('emp_id',Auth::guard('api')->user()->id)
            ->get();



//        dd($yearly_target);



        $result=['month'=>$month,
            'monthly'=>$monthly,
            'year'=>$year,
            'yearly'=>$yearly,
            'monthlysaletarget'=>$monthlysaletarget,
            'cos'=>$cos,
            'gross_profit'=>$gp,
            'receivable'=>$receivable,
                'total_sales'=>$monthly[date('M')]->total,
            'yearly_target'=>$yearly_target[date('Y')]->target??0,
            'sale_target'=>$sale_target[0]->target??0,
            'total_receivable'=>$total_receivable[0]->total??0,
            'saleactivity'=>$sale_activity??0,
            'my_groups'=>$group??0,
            'meeting'=>$meeting??0,
            'customer'=>$customer??0,
            'assignment'=>$assignment??0,
            'all_ticket'=>$emp_ticket??0,
            'requestation'=>$requestation??0,
            'invoice'=>$saleMan_invoice??0,
            'transferred_amount'=>$transferred_amount??0,
            'stock_balance'=>$stock_balance[0]->total??0,
            'expense'=>$emp_expense[0]->total??0,
            'inhand'=>Auth::guard('api')->user()->amount_in_hand??0
            ];
        $data=[];
        array_push($data,$result);
//dd($gp);
       return response()->json([
           'result'=>$data,'con'=>true
       ]);

    }
}
