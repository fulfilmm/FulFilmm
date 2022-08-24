<?php

namespace App\Http\Controllers;


use App\Models\Account;
use App\Models\Approvalrequest;
use App\Models\assign_ticket;
use App\Models\Assignment;
use App\Models\Bill;
use App\Models\countdown;
use App\Models\Customer;
use App\Models\DealActivitySchedule;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseClaim;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\Meetingmember;
use App\Models\MinutesAssign;
use App\Models\next_plan;
use App\Models\ProductVariations;
use App\Models\PurchaseOrder;
use App\Models\Revenue;
use App\Models\SaleActivity;
use App\Models\SellingUnit;
use App\Models\status;
use App\Models\Stock;
use App\Models\ticket;
use App\Models\ticket_follower;
use App\Models\Transaction;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::guard('employee')->user();
        $id = Auth::id();
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthly_expense = [];
        $monthly_income = [];
        $profit = [];
        $meeting = Meetingmember::with('meeting')->where('member_id', $user->id)->count();
        $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
//          dd($meeting);
        $assignment = MinutesAssign::where('emp_id', $user->id)->count();
        $group = Group::whereHas('employees', function ($query) use ($id) {
            $query->where('employee_id', $id);
        })->count();
        //ticket Admin Dashboard
        switch ($user->role->name) {
            case "Super Admin":
                $year = date('Y');
                $current_month = date('m');
                if ($current_month < 4) {
                    $year = $year - 1;
                }
                $total_emp = Employee::count();
                $contact = Customer::count();
                $start = $year . '-04-01';
                $mid = $year . '-09-30';
                $end = ($year + 1) . '-03-31';
                $daily_sale = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereDate('created_at', Carbon::today())
                    ->get();
                $current_year_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereYear('transaction_date', date('Y'))
                    ->get();
                $current_year_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('bill_date', date('Y'))
                    ->get();
                $current_year_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereYear('transaction_date', date('Y'))
                    ->get();
                $current_month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('bill_date', date('m'))
                    ->get();
                $current_month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();
                $current_month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();
                $first_6month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$start, $mid])
                    ->get();
                $first_6month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('bill_date', [$start, $mid])
                    ->get();
                $first_6month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$start, $mid])
                    ->get();
                $second_6month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$mid, $end])
                    ->get();
                $second_6month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('bill_date', [$mid, $end])
                    ->get();
                $second_6month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$mid, $end])
                    ->get();


                foreach ($month as $key => $value) {
                    $grand_total = DB::table("revenues")
                        ->select(DB::raw("SUM(amount) as total"))
                        ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                        ->get();
                    $monthly_income[$value] = $grand_total[0];
                    $expense = DB::table("expenses")
                        ->select(DB::raw("SUM(amount) as total"))
                        ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                        ->get();
                    $monthly_expense[$value] = $expense[0] ?? 0;
                    $profit[$value] = ($grand_total[0]->total ?? 0) - ($expense[0]->total ?? 0);

                }
                $sale_activity = SaleActivity::count();
                $numberOfalltickets = ticket::all()->count();
                $group = Group::count();
                $account = DB::table("accounts")
                    ->select(DB::raw("SUM(balance) as total"))->get();
                $transaction = Transaction::count();
                $requestation = Approvalrequest::count();
                $bills = Bill::count();
                $purchaseorder = PurchaseOrder::count();
                $stock_balance = DB::table("stocks")
                    ->select(DB::raw("SUM(stock_balance) as total"))
                    ->get();
                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->count();
                $upcoming_schedule = $deal_activity + $lead_activity;
                $task = Assignment::where('end_date', '>=', Carbon::today())->count();
                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'stock_balance' => $stock_balance,
                    'bills' => $bills,
                    'purchaseorder' => $purchaseorder,
                    'daily_sale' => $daily_sale,
                    'saleactivity' => $sale_activity,
                    'requestation' => $requestation,
                    'customer' => $contact,
                    'assignment' => $assignment,
                    'meeting' => $meeting,
                    'my_groups' => $group,
                    'all_ticket' => $numberOfalltickets,
                    'transaction' => $transaction ?? 0,
                    'total_income' => $current_year_income[0]->total ?? 0,
                    'total_bill' => $current_year_bill[0]->total ?? 0,
                    'total_expense' => $current_year_expense[0]->total ?? 0,
                    'first_term_income' => $first_6month_income[0]->total ?? 0,
                    'first_term_bill' => $first_6month_bill[0]->total ?? 0,
                    'first_term_expense' => $first_6month_expense[0]->total ?? 0,
                    'first_term_profit' => ($first_6month_income[0]->total ?? 0) - ($first_6month_expense[0]->total ?? 0),
                    'second_term_income' => $second_6month_income[0]->total ?? 0,
                    'second_term_bill' => $second_6month_bill[0]->total ?? 0,
                    'second_term_expense' => $second_6month_expense[0]->total ?? 0,
                    'second_term_profit' => ($second_6month_income[0]->total ?? 0) - ($second_6month_expense[0]->total ?? 0),
                    'current_month_income' => $current_month_income[0]->total ?? 0,
                    'current_month_bill' => $current_month_bill[0]->total ?? 0,
                    'current_month_expense' => $current_month_expense[0]->total ?? 0,
                    'current_month_profit' => ($current_month_income[0]->total ?? 0) - ($current_month_expense[0]->total ?? 0),

                    'profit' => Auth::guard('employee')->user()->role->name == 'CEO' || Auth::guard('employee')->user()->role->name == 'Super Admin' ? $current_year_income[0]->total ?? 0 - $current_year_expense[0]->total ?? 0 : 0,
                ];
                $product_items = ProductVariations::all();
                $units = SellingUnit::all();

                $all_products = [];
                $bad_product = [];
                $i = 0;
                foreach ($product_items as $item) {
                    $qty = 0;

                    foreach ($units as $unit) {
                        $sell_product = DB::table("order_items")
                            ->select(DB::raw("SUM(quantity) as total"))
                            ->where('variant_id', $item->id)
                            ->where('sell_unit', $unit->id)
                            ->whereMonth('created_at', Carbon::today())->get();
                        $qty += $sell_product[0]->total * $unit->unit_convert_rate;
                    }
                    $all_products[$i]['qty'] = $qty;
                    $all_products[$i]['product_name'] = $item->product_name;
                    $all_products[$i]['variant'] = $item->variant;
                    $bad_product[$i]['qty'] = $qty;
                    $bad_product[$i]['product_name'] = $item->product_name;
                    $bad_product[$i]['variant'] = $item->variant;
                    $i++;

                }

                arsort($all_products);
                asort($bad_product);
                $best_sell = [];
                $bad_sell = [];
                foreach ($all_products as $pd) {
                    array_push($best_sell, $pd);
                }
                foreach ($bad_product as $pd) {
                    array_push($bad_sell, $pd);
                }
                return view('index', compact('items', 'total_emp', 'monthly_income', 'monthly_expense', 'profit', 'account', 'bad_sell', 'best_sell'));
                break;
            case "CEO":
                $year = date('Y');
                $current_month = date('m');
                if ($current_month < 4) {
                    $year = $year - 1;
                }
                $total_emp = Employee::count();
                $contact = Customer::count();
                $start = $year . '-04-01';
                $mid = $year . '-09-30';
                $end = ($year + 1) . '-03-31';
                $daily_sale = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereDate('created_at', date('d'))
                    ->get();
                $current_year_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereYear('transaction_date', date('Y'))
                    ->get();
                $current_year_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('bill_date', date('Y'))
                    ->get();
                $current_month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('bill_date', date('m'))
                    ->get();
                $first_6month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('bill_date', [$start, $mid])
                    ->get();
                $second_6month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('bill_date', [$mid, $end])
                    ->get();
                $current_year_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereYear('transaction_date', date('Y'))
                    ->get();
                $current_month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();
                $current_month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();

                $first_6month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$start, $mid])
                    ->get();
                $first_6month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$start, $mid])
                    ->get();
                $second_6month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$mid, $end])
                    ->get();
                $second_6month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$mid, $end])
                    ->get();


                foreach ($month as $key => $value) {
                    $grand_total = DB::table("revenues")
                        ->select(DB::raw("SUM(amount) as total"))
                        ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                        ->get();
                    $monthly_income[$value] = $grand_total[0];
                    $expense = DB::table("expenses")
                        ->select(DB::raw("SUM(amount) as total"))
                        ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                        ->get();
                    $monthly_expense[$value] = $expense[0] ?? 0;
                    $profit[$value] = ($grand_total[0]->total ?? 0) - ($expense[0]->total ?? 0);

                }
                $sale_activity = SaleActivity::count();
                $numberOfalltickets = ticket::all()->count();
                $group = Group::count();
                $account = Account::count();
                $transaction = Transaction::count();
                $requestation = Approvalrequest::where('approved_id', Auth::guard('employee')->user()->id)
                    ->orWhere('secondary_approved', Auth::guard('employee')->user()->id)
                    ->count();
                $bills = Bill::count();
                $purchaseorder = PurchaseOrder::count();
                $stock_balance = DB::table("stocks")
                    ->select(DB::raw("SUM(stock_balance) as total"))
                    ->get();
                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->count();
                $upcoming_schedule = $deal_activity + $lead_activity;
                $task = Assignment::where('end_date', '>=', Carbon::today())->count();
                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'stock_balance' => $stock_balance,
                    'bills' => $bills,
                    'purchaseorder' => $purchaseorder,
                    'daily_sale' => $daily_sale,
                    'first_term_bill' => $first_6month_bill[0]->total ?? 0,
                    'total_bill' => $current_year_bill[0]->total ?? 0,
                    'second_term_bill' => $second_6month_bill[0]->total ?? 0,
                    'current_month_bill' => $current_month_bill[0]->total ?? 0,
                    'saleactivity' => $sale_activity,
                    'requestation' => $requestation,
                    'customer' => $contact,
                    'assignment' => $assignment,
                    'meeting' => $meeting,
                    'my_groups' => $group,
                    'all_ticket' => $numberOfalltickets,
                    'transaction' => $transaction ?? 0,
                    'total_income' => $current_year_income[0]->total ?? 0,
                    'total_expense' => $current_year_expense[0]->total ?? 0,
                    'first_term_income' => $first_6month_income[0]->total ?? 0,
                    'first_term_expense' => $first_6month_expense[0]->total ?? 0,
                    'first_term_profit' => ($first_6month_income[0]->total ?? 0) - ($first_6month_expense[0]->total ?? 0),
                    'second_term_income' => $second_6month_income[0]->total ?? 0,
                    'second_term_expense' => $second_6month_expense[0]->total ?? 0,
                    'second_term_profit' => ($second_6month_income[0]->total ?? 0) - ($second_6month_expense[0]->total ?? 0),
                    'current_month_income' => $current_month_income[0]->total ?? 0,
                    'current_month_expense' => $current_month_expense[0]->total ?? 0,
                    'current_month_profit' => ($current_month_income[0]->total ?? 0) - ($current_month_expense[0]->total ?? 0),
                    'profit' => Auth::guard('employee')->user()->role->name == 'CEO' || Auth::guard('employee')->user()->role->name == 'Super Admin' ? $current_year_income[0]->total ?? 0 - $current_year_expense[0]->total ?? 0 : 0,
                ];
                $product_items = ProductVariations::all();
                $units = SellingUnit::all();

                $all_products = [];
                $bad_product = [];
                $i = 0;
                foreach ($product_items as $item) {
                    $qty = 0;

                    foreach ($units as $unit) {
                        $sell_product = DB::table("order_items")
                            ->select(DB::raw("SUM(quantity) as total"))
                            ->where('variant_id', $item->id)
                            ->where('sell_unit', $unit->id)
                            ->whereMonth('created_at', Carbon::today())->get();
                        $qty += $sell_product[0]->total * $unit->unit_convert_rate;
                    }
                    $all_products[$i]['qty'] = $qty;
                    $all_products[$i]['product_name'] = $item->product_name;
                    $all_products[$i]['variant'] = $item->variant;
                    $bad_product[$i]['qty'] = $qty;
                    $bad_product[$i]['product_name'] = $item->product_name;
                    $bad_product[$i]['variant'] = $item->variant;
                    $i++;

                }

                arsort($all_products);
                asort($bad_product);
                $best_sell = [];
                $bad_sell = [];
                foreach ($all_products as $pd) {
                    array_push($best_sell, $pd);
                }
                foreach ($bad_product as $pd) {
                    array_push($bad_sell, $pd);
                }
                return view('index', compact('items', 'total_emp', 'monthly_income', 'monthly_expense', 'profit', 'account', 'best_sell', 'bad_sell'));
                break;
            case "General Manager":
//                dd("GM");
                $year = date('Y');
                $current_month = date('m');
                if ($current_month < 4) {
                    $year = $year - 1;
                }
                $total_emp = Employee::count();
                $contact = Customer::count();
                $start = $year . '-04-01';
                $mid = $year . '-09-30';
                $end = ($year + 1) . '-03-31';
                $daily_sale = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereDate('created_at', date('d'))
                    ->get();
                $current_year_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereYear('transaction_date', date('Y'))
                    ->get();
                $current_year_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereYear('bill_date', date('Y'))
                    ->get();
                $current_month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('bill_date', date('m'))
                    ->get();
                $first_6month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('bill_date', [$start, $mid])
                    ->get();
                $second_6month_bill = DB::table("bills")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereBetween('bill_date', [$mid, $end])
                    ->get();
                $current_year_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereYear('transaction_date', date('Y'))
                    ->get();
                $current_month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();
                $current_month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();

                $first_6month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$start, $mid])
                    ->get();
                $first_6month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$start, $mid])
                    ->get();
                $second_6month_income = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$mid, $end])
                    ->get();
                $second_6month_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereBetween('transaction_date', [$mid, $end])
                    ->get();


                foreach ($month as $key => $value) {
                    $grand_total = DB::table("revenues")
                        ->select(DB::raw("SUM(amount) as total"))
                        ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                        ->get();
                    $monthly_income[$value] = $grand_total[0];
                    $expense = DB::table("expenses")
                        ->select(DB::raw("SUM(amount) as total"))
                        ->whereMonth('transaction_date', $key + 1)->whereYear('transaction_date', date('Y'))
                        ->get();
                    $monthly_expense[$value] = $expense[0] ?? 0;
                    $profit[$value] = ($grand_total[0]->total ?? 0) - ($expense[0]->total ?? 0);

                }
                $sale_activity = SaleActivity::where('report_to', Auth::guard('employee')->user()->id)->count();
                $numberOfalltickets = ticket::all()->count();
                $group = Group::count();
                $account = Account::count();
                $transaction = Transaction::count();
                $requestation = Approvalrequest::where('approved_id', Auth::guard('employee')->user()->id)
                    ->orWhere('secondary_approved', Auth::guard('employee')->user()->id)
                    ->count();
                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->count();
                $upcoming_schedule = $deal_activity + $lead_activity;
                $task = Assignment::where('end_date', '>=', Carbon::today())->count();
                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'daily_sale' => $daily_sale,
                    'first_term_bill' => $first_6month_bill[0]->total ?? 0,
                    'total_bill' => $current_year_bill[0]->total ?? 0,
                    'second_term_bill' => $second_6month_bill[0]->total ?? 0,
                    'current_month_bill' => $current_month_bill[0]->total ?? 0,
                    'saleactivity' => $sale_activity,
                    'requestation' => $requestation,
                    'customer' => $contact,
                    'assignment' => $assignment,
                    'meeting' => $meeting,
                    'my_groups' => $group,
                    'all_ticket' => $numberOfalltickets,
                    'transaction' => $transaction ?? 0,
                    'total_income' => $current_year_income[0]->total ?? 0,
                    'total_expense' => $current_year_expense[0]->total ?? 0,
                    'first_term_income' => $first_6month_income[0]->total ?? 0,
                    'first_term_expense' => $first_6month_expense[0]->total ?? 0,
                    'first_term_profit' => ($first_6month_income[0]->total ?? 0) - ($first_6month_expense[0]->total ?? 0),
                    'second_term_income' => $second_6month_income[0]->total ?? 0,
                    'second_term_expense' => $second_6month_expense[0]->total ?? 0,
                    'second_term_profit' => ($second_6month_income[0]->total ?? 0) - ($second_6month_expense[0]->total ?? 0),
                    'current_month_income' => $current_month_income[0]->total ?? 0,
                    'current_month_expense' => $current_month_expense[0]->total ?? 0,
                    'current_month_profit' => ($current_month_income[0]->total ?? 0) - ($current_month_expense[0]->total ?? 0),
                    'profit' => Auth::guard('employee')->user()->role->name == 'CEO' || Auth::guard('employee')->user()->role->name == 'Super Admin' ? $current_year_income[0]->total ?? 0 - $current_year_expense[0]->total ?? 0 : 0,
                ];
                return view('index', compact('items', 'total_emp', 'monthly_income', 'monthly_expense', 'profit', 'account'));
                break;
            case "Customer Service Manager":
                $agents = [];
                $allemp = Employee::all();
//              dd($allemp);
                foreach ($allemp as $emp) {
                    if ($emp->role->name == 'Agent') {
                        array_push($agents, $emp);
                    }
                }
                $assign_ticket = assign_ticket::with('ticket')->get();
                $status = status::where('name', 'Complete')->orWhere('name', 'CLose')->get();
                $status_report = $this->report_status();
                $report_percentage = $this->report_with_percentage();
                $count_down = countdown::all()->pluck('endtime', 'ticket_id')->all();
                $numberOfalltickets = ticket::all()->count();
                $depts = Department::all();
                $group = Group::whereHas('employees', function ($query) use ($id) {
                    $query->where('employee_id', $id);
                })->count();
//                $deal_activity=DealActivitySchedule::where('to_date','>=',Carbon::today())->count();
//                $lead_activity=next_plan::where('date_time',">=",Carbon::today())->count();
//                $upcoming_schedule=$deal_activity+$lead_activity;
//                $task=Assignment::where('end_date','>=',Carbon::today())->count();
                return view('index', compact('numberOfalltickets', 'agents', 'depts', 'assign_ticket', 'status', 'status_report', 'report_percentage', 'count_down', 'group'));
                break;
            case "Stock Manager":
                $warehouse = Warehouse::all();
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $product = Stock::with('variant')->get();
                $total = 0;
                foreach ($product as $item) {
                    $valuation = $item->stock_balance * $item->variant->purchase_price ?? 0;
                    $total += $valuation;
                }
                $no_of_items =ProductVariations::all()->count();
//                foreach ($warehouse as $wh) {
//                    $inhand_product = Stock::with('variant')->where('warehouse_id', $wh->id)->where('stock_balance', '>', 0)->get();
//                    foreach ($inhand_product as $item) {
//                        if (!in_array($item->variant->product_code, $no_of_items)) {
//                            array_push($no_of_items, $item->variant->product_code);
//                        }
//                    }
//                }
                $employee = Employee::where('department_id', $user->department_id)->get();
                $upcoming_schedule = 0;
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));
                foreach ($employee as $emp) {
                    $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $emp->id)->count();
                    $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $emp->id)->count();
                    $upcoming_schedule += $deal_activity + $lead_activity;

                }
                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'no_product_item' => count($no_of_items),
                    'valuation' => $total,
                    'warehouse' => count($warehouse)

                ];
                return view('index', compact('items'));
                break;
            case "Stock Controller":
                $warehouse = Warehouse::where('branch_id', $user->office_branch_id)->get();
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $product = Stock::with('variant')->where('branch_id', $user->office_branch_id)->get();
                $total = 0;
                foreach ($product as $item) {
                    $valuation = $item->stock_balance * $item->variant->purchase_price ?? 0;
                    $total += $valuation;
                }
                $no_of_items = [];
                foreach ($warehouse as $wh) {
                    $inhand_product = Stock::with('variant')->where('warehouse_id', $wh->id)->where('stock_balance', '>', 0)->get();
                    foreach ($inhand_product as $item) {
                        if (!in_array($item->variant->product_code, $no_of_items)) {
                            array_push($no_of_items, $item->variant->product_code);
                        }
                    }
                }
//                    dd(count($no_of_items));

                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'no_product_item' => count($no_of_items),
                    'valuation' => $total,
                    'warehouse' => count($warehouse)

                ];
                return view('index', compact('items'));
                break;

            case "Store Keeper":
                $warehouse = Warehouse::where('id', $user->warehouse_id)->get();
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $product = Stock::with('variant')->where('warehouse_id', $user->warehouse_id)->get();
                $total = 0;
                foreach ($product as $item) {
                    $valuation = $item->stock_balance * $item->variant->purchase_price ?? 0;
                    $total += $valuation;
                }
                $no_of_items = [];
                foreach ($warehouse as $wh) {
                    $inhand_product = Stock::with('variant')->where('warehouse_id', $wh->id)->where('stock_balance', '>', 0)->get();
                    foreach ($inhand_product as $item) {
                        if (!in_array($item->variant->product_code, $no_of_items)) {
                            array_push($no_of_items, $item->variant->product_code);
                        }
                    }
                }
//                    dd(count($no_of_items));
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'no_product_item' => count($no_of_items),
                    'valuation' => $total,
                    'warehouse' => count($warehouse)

                ];
                return view('index', compact('items'));
                break;
            case "Finance Manager":
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $product = Stock::with('variant')->get();
                $total = 0;
                foreach ($product as $item) {
                    $valuation = $item->stock_balance * $item->variant->purchase_price ?? 0;
                    $total += $valuation;
                }
                $total_sale = DB::table("invoices")
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('invoice_date', date('m'))
                    ->get();
                $payable_amount = DB::table('bills')
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('bill_date', date('m'))->get();
                $total_remaining = DB::table('invoices')
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->whereMonth('invoice_date', date('m'))->get();
                $total_revenue = DB::table("revenues")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();
                $total_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->get();
                $bill = Bill::whereMonth('bill_date', date('m'))->count();
                $bank_transaction_count = Transaction::whereMonth('created_at', date('m'))->count();
                $exp_claim_count = ExpenseClaim::where('created_at', date('m'))->count();
                $account_count = Account::count();
                $employee = Employee::where('department_id', $user->department_id)->get();
                $upcoming_schedule = 0;
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));
                foreach ($employee as $emp) {
                    $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $emp->id)->count();
                    $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $emp->id)->count();
                    $upcoming_schedule += $deal_activity + $lead_activity;

                }
                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'valuation' => $total,
                    'total_sale' => $total_sale[0]->total ?? 0,
                    'total_revenue' => $total_revenue[0]->total ?? 0,
                    'total_expense' => $total_expense[0]->total ?? 0,
                    'total_debt' => $total_remaining[0]->total ?? 0,
                    'bill_count' => $bill,
                    'transaction_count' => $bank_transaction_count,
                    'exp_claim_count' => $exp_claim_count,
                    'account_count' => $account_count,
                    'payable' => $payable_amount[0]->total ?? 0,
                ];

                return view('index', compact('items'));
                break;
            case "HR Manager":
                dd('HRM');
                break;
            case "Sales Manager":
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $sale_activity = SaleActivity::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $customer = Customer::count();
                $invoice = Invoice::wheremonth('invoice_date', date('m'))->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $emp_expense = DB::table("emp_expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->where('emp_id', Auth::guard('employee')->user()->id)
                    ->get();
                $monthly_receiable = DB::table("invoices")
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->get();
                $stock_balance = DB::table("stocks")
                    ->select(DB::raw("SUM(stock_balance) as total"))
                    ->get();
                $employee = Employee::where('department_id', $user->department_id)->get();
                $upcoming_schedule = 0;
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));
                foreach ($employee as $emp) {
                    $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $emp->id)->count();
                    $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $emp->id)->count();
                    $upcoming_schedule += $deal_activity + $lead_activity;

                }
                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'saleactivity' => $sale_activity,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'customer' => $customer,
                    'assignment' => $assignment,
                    'invoice' => $invoice,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'stock_balance' => $stock_balance[0]->total,
                    'receivable' => $monthly_receiable[0]->total,
                    'expense' => $emp_expense[0]->total ?? 0
                ];
                return view('index', compact('items'));
                break;
            case "Car Admin":
                break;
            case "Sales":
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $sale_activity = SaleActivity::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $customer = Customer::where('region_id', Auth::guard('employee')->user()->region_id)->count();
                $saleMan_invoice = Invoice::wheremonth('invoice_date', date('m'))->where('emp_id', $user->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $revenue = Revenue::with('invoice')->where('invoice_id', '!=', null)->where('approve', 1)->get();
                $transferred_amount = 0;
                foreach ($revenue as $inv_item) {
                    if ($inv_item->invoice->emp_id == Auth::guard('employee')->user()->id) {
                        $transferred_amount += $inv_item->amount;
                    }
                }
                $stock_balance = DB::table("stocks")
                    ->select(DB::raw("SUM(stock_balance) as total"))
                    ->where('warehouse_id', Auth::guard('employee')->user()->warehouse_id)
                    ->get();
                $emp_expense = DB::table("emp_expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->where('emp_id', Auth::guard('employee')->user()->id)
                    ->get();
                $monthly_receiable = DB::table("invoices")
                    ->select(DB::raw("SUM(due_amount) as total"))
                    ->where('emp_id', Auth::guard('employee')->user()->id)
                    ->get();
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'saleactivity' => $sale_activity,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'customer' => $customer,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'invoice' => $saleMan_invoice,
                    'transferred_amount' => $transferred_amount,
                    'stock_balance' => $stock_balance[0]->total,
                    'receivable' => $monthly_receiable[0]->total,
                    'expense' => $emp_expense[0]->total ?? 0

                ];
                return view('index', compact('items'));
                break;
            case "Accountant":
                $payable_amount = DB::table('bills')
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('bill_date', date('m'))->where('emp_id', $user->id)->get();
                $bill = Bill::whereMonth('bill_date', date('m'))->where('emp_id', $user->id)->count();
                $exp_claim_count = ExpenseClaim::whereMonth('created_at', date('m'))->where('financial_approver', $user->id)->count();
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $account_count = Account::count();
                $total_expense = DB::table("expenses")
                    ->select(DB::raw("SUM(amount) as total"))
                    ->whereMonth('transaction_date', date('m'))
                    ->where('approver_id', $user->id)
                    ->get();
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'bill_count' => $bill,
                    'total_expenses' => $total_expense[0]->total ?? 0,
                    'exp_claim_count' => $exp_claim_count,
                    'account_count' => $account_count,
                    'payable' => $payable_amount[0]->total ?? 0,
                ];
                return view('index', compact('items'));
                break;
            case "Agent":
                $agents = [];
                $allemp = Employee::all();
//              dd($allemp);
                foreach ($allemp as $emp) {
                    if ($emp->role->name == 'Agent') {
                        array_push($agents, $emp);
                    }
                }
                $assign_ticket = assign_ticket::with('ticket')->get();
                $status = status::where('name', 'Complete')->orWhere('name', 'CLose')->get();
                $status_report = $this->report_status();
                $report_percentage = $this->report_with_percentage();
                $count_down = countdown::all()->pluck('endtime', 'ticket_id')->all();
                $depts = Department::all();
                $agent_alltickets = count($this->agent_all_ticket()) + $follow_ticket;
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();

                $customer = Customer::count();
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'requestation' => $requestation,
                    'assignment' => $assignment,
                    'meeting' => $meeting,
                    'my_groups' => $group,
                    'all_ticket' => $agent_alltickets,
                    'customer' => $customer
                ];
                return view('index', compact('items', 'status_report', 'report_percentage', 'count_down', 'status', 'assign_ticket', 'depts'));
                break;
            case "Cashier":
                $account_count = Account::count();
                $payable_amount = DB::table('bills')
                    ->select(DB::raw("SUM(grand_total) as total"))
                    ->whereMonth('bill_date', date('m'))
                    ->where('emp_id', $user->id)
                    ->get();
                $bill = Bill::whereMonth('bill_date', date('m'))->where('emp_id', $user->id)->count();
                $revenue_transaction = Revenue::where('cashier', $user->id)->whereMonth('transaction_date', date('m'))->count();
                $expense_transaction = Expense::where('approver_id', $user->id)->whereMonth('transaction_date', date('m'))->count();
                $exp_claim_count = ExpenseClaim::whereMonth('created_at', date('m'))->where('financial_approver', $user->id)->count();
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'my_groups' => $group,
                    'meeting' => $meeting,
                    'assignment' => $assignment,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'bill_count' => $bill,
                    'transaction_count' => ($revenue_transaction) + ($expense_transaction),
                    'exp_claim_count' => $exp_claim_count,
                    'account_count' => $account_count,
                    'payable' => $payable_amount[0]->total ?? 0,
                ];
                return view('index', compact('items'));
                break;
            case "Car Driver":
            default:
                $requestation = Approvalrequest::where('emp_id', Auth::guard('employee')->user()->id)->count();
                $myticket = ticket::where('created_emp_id', $user->id)->count();
                $follow_ticket = ticket_follower::where('emp_id', $user->id)->count();
                $emp_ticket = $myticket + $follow_ticket;
                $group = Group::whereHas('employees', function ($query) use ($id) {
                    $query->where('employee_id', $id);
                })->count();
                $task = Assignment::where('end_date', '>=', Carbon::today())->where('assignee_id', $user->id)->count();
//                    dd(count($no_of_items));

                $deal_activity = DealActivitySchedule::where('to_date', '>=', Carbon::today())->where('emp_id', $user->id)->count();
                $lead_activity = next_plan::where('date_time', ">=", Carbon::today())->where('emp_id', $user->id)->count();
                $upcoming_schedule = $deal_activity + $lead_activity;

                $items = [
                    'upcoming_schedule' => $upcoming_schedule,
                    'upcoming_task' => $task,
                    'all_ticket' => $emp_ticket,
                    'requestation' => $requestation,
                    'assignment' => $assignment,
                    'meeting' => $meeting,
                    'my_groups' => $group,
                ];
                return view('index', compact('items'));
                break;
        }
    }

    public function agent_all_ticket()
    {
        $auth_user = Auth::guard('employee')->user();
        $all_tickets = [];
        $created_tickets = ticket::where("created_emp_id", $auth_user->id)->get();
        if (!$created_tickets->isEmpty()) {
            foreach ($created_tickets as $ticket) {
                array_push($all_tickets, $ticket);
            }
        }
        $agent_tickets = assign_ticket::with('ticket')->orWhere("agent_id", $auth_user->id)->orWhere("dept_id", $auth_user->department_id)->get();
        if (!$agent_tickets->isEmpty()) {
            foreach ($agent_tickets as $agent_ticket) {
                array_push($all_tickets, $agent_ticket->ticket);

            }
        }
        return $all_tickets;
    }

    public function report_status()
    {
        $all_status = status::all();
//        dd($all_status);
        $statuses = [];
        $report_for_agent = $this->agent_all_ticket();
        for ($i = 0; $i < count($all_status); $i++) {
            if (Auth::guard('employee')->user()->role->name == "Agent") {
                $same_status = [];
                foreach ($report_for_agent as $ticket) {
                    if ($ticket->status == $all_status[$i]->id) {
                        array_push($same_status, $ticket);
                    }
                }
                $statuses[$all_status[$i]->name] = count($same_status);
            } else {
                $ticket = ticket::with("ticket_status", "ticket_priority")->where('status', $all_status[$i]->id)->get();
                $statuses[$all_status[$i]->name] = count($ticket);
            }
        }
        return $statuses;
    }

    public function report_with_percentage()
    {

        $ticket = $this->report_status();
//        dd($ticket);
        $all_percentage = [];
        $all_ticket = $ticket['New'] + $ticket['Open'] + $ticket['Complete'] + $ticket['Pending'] + $ticket['Overdue'] + $ticket['Close'] + $ticket['In Progress'];
        if ($all_ticket == 0) {
            $all_ticket = 1;
        }
        $all_percentage['New'] = round($ticket['New'] / $all_ticket * 100, 2);
        $all_percentage['Open'] = round($ticket['Open'] / $all_ticket * 100, 2);
        $all_percentage['In-progress'] = round($ticket['In Progress'] / $all_ticket * 100, 2);
        $all_percentage['Solve'] = round(($ticket['Complete'] + $ticket['Close']) / $all_ticket * 100, 2);
        $all_percentage['Pending'] = round($ticket['Pending'] / $all_ticket * 100, 2);
        $all_percentage['Overdue'] = round($ticket['Overdue'] / $all_ticket * 100, 2);
        return $all_percentage;

    }

}