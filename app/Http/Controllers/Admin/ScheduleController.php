<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Schedule;
use stdClass;
class ScheduleController extends Controller
{

    public function view_schedule(Request $request)
    {
        $year = date('Y');
       if($this->isLogged($request)){
            Session::put('nav','schedule');
            $company_id = $request->session()->get('user')['id'];
            $schedule = DB::select('SELECT *
                            FROM evaluation_schedule
                            WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');

            return view('admin.schedule.schedule',compact('schedule'));
        } else {
            return redirect('login');
        } 
    }


    public function insert_schedule(Request $request)
    {   
        $company_id = $request->session()->get('user')['id'];
        if($request->id==0){
            $schedule = new Schedule;
            $schedule->mid_year_eval_start = $request->mid_year_eval_start;
            $schedule->mid_year_eval_end = $request->mid_year_eval_end;
            $schedule->end_year_eval_start = $request->end_year_eval_start;
            $schedule->end_year_eval_end = $request->end_year_eval_end;
            $schedule->company_id = $company_id;
            $schedule->created_at = date('Y-m-d H:i:s');
            $schedule->save();
            return redirect()->back()->with('success_msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $schedule = Schedule::find($id);
            $schedule->mid_year_eval_start = $request->mid_year_eval_start;
            $schedule->mid_year_eval_end = $request->mid_year_eval_end;
            $schedule->end_year_eval_start = $request->end_year_eval_start;
            $schedule->end_year_eval_end = $request->end_year_eval_end;
            $schedule->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
        }
       
    }

}
