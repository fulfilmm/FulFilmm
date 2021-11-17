<?php

namespace App\Http\Controllers;


use App\Models\deal;
use App\Models\DealActivitySchedule;
use App\Models\Department;
use App\Models\Employee;
use App\Models\next_plan;
use App\Models\Quotation;
use App\Models\SalePipelineRecord;

class ReportController extends Controller
{
    public function SalePerformance(){
            $dept=Department::where('name','Sale Department')->first();
            $employee=Employee::where('department_id',$dept->id)->get();
            $performance=[];
            foreach ($employee as $emp){
                $emp_appointment=next_plan::where('type','Meeting')->where('emp_id',$emp->id)->whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->count();
                $emp_deal_win=deal::where('sale_stage','Win')->where('created_id',$emp->id)->whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))->count();
                $emp_proposal=Quotation::whereMonth('created_at', date('m'))->where('sale_person_id',$emp->id)
                    ->whereYear('created_at', date('Y'))->where('is_confirm',1)
                    ->count();
                $emp_meeting=DealActivitySchedule::where('type','Meeting')->where('emp_id',$emp->id)->count();
                $performance[$emp->id]['appointment']=$emp_appointment;
                $performance[$emp->id]['deal']=$emp_deal_win;
                $performance[$emp->id]['proposal']=$emp_proposal;
                $performance[$emp->id]['meeting']=$emp_meeting;
            }
//            dd($performance);
            $appointment=next_plan::where('type','Meeting')->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();
            $deal_win=deal::where('sale_stage','Win')->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->count();
            $proposal=Quotation::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))->where('is_confirm',1)
                ->count();
            $stage=['New','Qualified','Quotation','Invoicing','Win','Lost'];
            $salepipeline=[];
            foreach ($stage as $key=>$value){
                $dealeach_stage=deal::where('sale_stage',$value)->count();
                $salepipeline[$value]=$dealeach_stage;
            }
            $meeting=DealActivitySchedule::where('type','Meeting')->count();
            $lead=SalePipelineRecord::where('state','New')->count();
            $qualified=SalePipelineRecord::where('state','Qualified')->count();
            $quotation=SalePipelineRecord::where('state','Quotation')->count();
            $win=SalePipelineRecord::where('state','Win')->count();
            $lost=SalePipelineRecord::where('state','Lost')->count();
            $unqualified=$lead-$qualified;
            $still_qualified=$qualified-$quotation;
            $still_quotation=$quotation-$win-$lost;


//            dd($lead);

        $data=['appointment'=>$appointment,'deal'=>$deal_win,'proposal'=>$proposal,'meeting'=>$meeting,'lead'=>$lead,'qualified'=>$qualified,'unqualified'=>$unqualified,'quotation'=>$quotation,'win'=>$win,
            'still_qualified'=>$still_qualified,'still_quotation'=>$still_quotation,'lost'=>$lost];

        return view('Report.saleperformance',compact('data','performance','employee','salepipeline'));

    }
}
