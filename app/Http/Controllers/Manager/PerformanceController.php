<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use App\Objective;
use App\Kpi;
use stdClass;
class PerformanceController extends Controller
{
    public function view_assign(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','performance');
            Session::put('sub_nav','assign');
            return view('manager.performance.assign_objective');
        } else {
            return redirect('login');
        } 
    }

     public function objective_list(Request $request)
    {
        $year = date('Y');
        $manager_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT  a.*, d.descript_target, d.completion_date, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.manager_id = '.$manager_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%" AND d.completion_date !=""'); 

        $table_data['data'] = array();
        
        foreach ($main as $key => $value) {        
            $sub = DB::select('SELECT  a.*, d.descript_target, d.completion_date, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.manager_id = '.$manager_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->id.'  AND d.completion_date !=""');
            if(count($sub)>0){
              $value->has_sub=1;
            }else $value->has_sub=0;
            array_push($table_data['data'], $value);
            foreach ($sub as $s) {
              array_push($table_data['data'], $s);
            }
        }    
      echo json_encode($table_data);   
    }
    public function edit_objective($id)
    {
        Session::put('nav','performance');
        Session::put('sub_nav','assign');
        $manager_id = Session::get('user')['id'];
        $employee = DB::select('SELECT *
                               FROM users
                              WHERE parent_id = '.$manager_id.' AND user_role = "employee"'); 
       
        $mainobjective = DB::select('SELECT *
                                FROM objective
                                WHERE manager_id = '.$manager_id.' AND is_sub = "0"'
                                );
      
       if($id == 0){
            return view('manager.performance.objective_edit', compact('mainobjective','employee'));
        } else {
            $objective = DB::select('SELECT *
                                FROM objective
                                WHERE id ='.$id);

            return view('manager.performance.assign_objective_edit', compact('objective','mainobjective','employee'));
        } 
    }

    public function insert_assign(Request $request)
    {   
        $id = $request->id; 
        $objective = Objective::find($id);
        $manager_id = $request->session()->get('user')['id'];
        $objective->manager_id = $manager_id;
        $objective->employee_id = $request->employee_id;
        $objective->save();

        MailController::send_email_assignedUser($id);

        return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
    }

    public function view_evaluation(Request $request)
    {
        $eval_date = $this->get_evalDate();
        if($eval_date[0]=='no') return redirect('manager')->with('eval_date_error', 'Evaluation date not yet!')->withInput();
       if($this->isLogged($request)){
            Session::put('nav','performance');
            Session::put('sub_nav','evaluation');

            return view('manager.performance.evaluation');
        } else {
            return redirect('login');
        } 
    }
    // private function get_evalDate(){
    //   $manager_id =  Session::get('user')['id'];
    //     $company = DB::select('SELECT a.parent_id as company_id
    //       FROM users a
    //       WHERE a.id = '.$manager_id);
    //     $company_id = $company[0]->company_id;

    //     $year = date('Y');
    //     $today = date('Y-m-d');
    //     $schedule = DB::select('SELECT *
    //                           FROM evaluation_schedule
    //                           WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');

    //     if(strtotime($schedule[0]->mid_year_eval_start) <= strtotime($today) && strtotime($schedule[0]->mid_year_eval_end) >= strtotime($today)){
    //       $eval_date[0] = 'mid_date';
    //     }elseif(strtotime($schedule[0]->end_year_eval_start) <= strtotime($today) && strtotime($schedule[0]->end_year_eval_end) >= strtotime($today)){
    //       $eval_date[0] = 'end_date';
    //     }else{$eval_date[0] = 'no';}
    //     if(strtotime($schedule[0]->end_year_eval_start) <= strtotime($today)){
    //       $eval_date[1] = 'last';
    //     }else $eval_date[1] = 'mid';
    //     return $eval_date;
    // }

    public function evaluation_list(Request $request)
    {
      $year = date('Y');
        $manager_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT  a.*,a.id as obj_id, d.*, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.manager_id = '.$manager_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%"  AND d.completion_date !=""'); 

        $table_data['data'] = array();
        
        foreach ($main as $key => $value) {        
            $sub = DB::select('SELECT  a.*,a.id as obj_id, d.*, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.manager_id = '.$manager_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->obj_id.' AND d.completion_date !=""');
            if(count($sub)>0){
              $value->has_sub=1;
            }else $value->has_sub=0;
            array_push($table_data['data'], $value);
            foreach ($sub as $s) {
              array_push($table_data['data'], $s);
            }
        }

        $eval_date = $this->get_evalDate();  
        foreach ($table_data['data'] as $d =>$data) {
          if($eval_date[1]=='last'){
              $table_data['data'][$d]->actual_achived=$data->actual_achived_2;
              $table_data['data'][$d]->status=$data->status_2;
            }else{
              $table_data['data'][$d]->actual_achived=$data->actual_achived_1;
              $table_data['data'][$d]->status=$data->status_1;
            }
        }    
      echo json_encode($table_data);   
      
    }

    public function edit_evaluation($id)
    {
      Session::put('nav','performance');
      Session::put('sub_nav','evaluation');

      $kpi=DB::select('SELECT *
                         FROM kpi
                        WHERE objective_id = '.$id);

      $eval_date = $this->get_evalDate();

      if($eval_date[0]=='mid_date'){
        $kpi[0]->actual_achived = $kpi[0]->actual_achived_1;
      }else{
        $kpi[0]->actual_achived = $kpi[0]->actual_achived_2;
      }

      $objective = DB::select('SELECT *
                                FROM objective
                                WHERE id ='.$id);
      if($objective[0]->is_sub=='1'){
        $main = DB::select('SELECT name
                              FROM objective
                              WHERE id ='.$objective[0]->parent_id);
        $objective[0]->main_name = $main[0]->name;
        $objective[0]->sub_name = $objective[0]->name;
      }else{
        $objective[0]->main_name = $objective[0]->name;
        $objective[0]->sub_name = '';
      }
      
       if(count($kpi)>0){
            return view('manager.performance.evaluation_edit', compact('objective','kpi'));
        } else {
            return view('manager.performance.evaluation_edit', compact('objective'));
        } 
    }



    public function insert_evaluation(Request $request)
    {   

            $id = $request->id; 
            $kpi = Kpi::find($id);
             ////get_evalDate
              $eval_date = $this->get_evalDate();
              if($eval_date[0]=='mid_date'){
                $kpi->actual_achived_1 = $request->actual_achived;
                $kpi->status_1 = '1';
              }else{
                $kpi->actual_achived_2 = $request->actual_achived;
                $kpi->status_2 = '1';
              }
            //// end
            $kpi->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
       
    }
    
}