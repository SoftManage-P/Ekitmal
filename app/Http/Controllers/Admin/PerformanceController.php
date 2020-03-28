<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use App\Objective;
use App\Kpi;
use App\BonusHistory;

use stdClass;
class PerformanceController extends Controller
{

    public function view_assign(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','performance');
            Session::put('sub_nav','assign');
            return view('admin.performance.assign_objective');
        } else {
            return redirect('login');
        } 
    }

    public function objective_list(Request $request)
    {
        $company_id = $request->session()->get('user')['id'];
        $year =date("Y");
        $main = DB::select('SELECT  a.*, d.descript_target, d.completion_date, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%" AND d.completion_date !=""'); 
        
        $table_data['data']=array();
        foreach ($main as $key => $value) {        
            $sub = DB::select('SELECT  a.*, d.descript_target, d.completion_date, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->id.' AND d.completion_date !=""');
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
      $company_id = Session::get('user')['id'];
      $department = DB::select('SELECT *
                             FROM users
                            WHERE parent_id = '.$company_id.' AND user_role = "manager"'); 
     
      $mainobjective = DB::select('SELECT *
                                FROM objective
                                WHERE company_id = '.$company_id.' AND is_sub = "0"'
                                );
      
       if($id == 0){
            return view('admin.performance.objective_edit', compact('mainobjective','department'));
        } else {
            $objective = DB::select('SELECT *
                                FROM objective
                                WHERE id ='.$id);
// var_dump($objective);
// die();
            return view('admin.performance.assign_objective_edit', compact('objective','mainobjective','department'));
        } 
    }

    public function get_employee(Request $request){
        $department_id = $request->department_id;

        $user_data = DB::select('SELECT *
                             FROM users
                            WHERE parent_id = '.$department_id); 
        echo json_encode($user_data);
          
        
    }

    public function insert_assign(Request $request)
    {   
        $id = $request->id; 
        $objective = Objective::find($id);
        $objective->manager_id = $request->manager_id;
        $objective->employee_id = $request->employee_id;
        $objective->save();

        MailController::send_email_assignedUser($id);

        return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
    }

    public function view_evaluation(Request $request)
    {
      if($this->isLogged($request)){
          $eval_date = $this->get_evalDate();
          if($eval_date[0] == 'no') return redirect('admin/schedule');
      
            Session::put('nav','performance');
            Session::put('sub_nav','evaluation');

            return view('admin.performance.evaluation');
      } else {
          return redirect('login');
      } 
    }
    // private function get_evalDate(){
    //     $company_id = Session::get('user')['id'];
    //     $year = date('Y');
    //     $today = date('Y-m-d');
    //     $schedule = DB::select('SELECT *
    //                           FROM evaluation_schedule
    //                           WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');
    //     $eval_date[0]='';
    //     $eval_date[1] = '';
    //     if(count($schedule)>0){
    //       if(strtotime($schedule[0]->mid_year_eval_start) <= strtotime($today) && strtotime($schedule[0]->mid_year_eval_end) >= strtotime($today)){
    //         $eval_date[0] = 'mid_date';
    //       }elseif(strtotime($schedule[0]->end_year_eval_start) <= strtotime($today) && strtotime($schedule[0]->end_year_eval_end) >= strtotime($today)){
    //         $eval_date[0] = 'end_date';
    //       }else{$eval_date[0] = 'no';}
    //       if(strtotime($schedule[0]->end_year_eval_start) <= strtotime($today)){
    //         $eval_date[1] = 'last';
    //       }else $eval_date[1] = 'mid';
    //     }
        
    //     return $eval_date;
    // }
    public function evaluation_list(Request $request)
    { 
        $company_id = $request->session()->get('user')['id'];
        $year =date("Y");
        $main = DB::select('SELECT  a.*,a.id as obj_id, d.*, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%" AND d.completion_date !=""'); 
        
        $table_data['data']=array();
        foreach ($main as $key => $value) {        
            $sub = DB::select('SELECT  a.*,a.id as obj_id,d.*, b.department,b.full_name as manager_name, c.full_name as employee_name
                             FROM objective a
                            LEFT JOIN users b ON a.manager_id = b.id
                            LEFT JOIN users c ON a.employee_id = c.id
                            LEFT JOIN kpi d ON a.id = d.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->obj_id.' AND d.completion_date !=""');
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

      $company_id = Session::get('user')['id'];
      
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
            return view('admin.performance.evaluation_edit', compact('objective','kpi'));
        } else {
            return view('admin.performance.evaluation_edit', compact('objective'));
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
                $kpi->status_1 = '2'; // 2: admin evaluated
              }else{
                $kpi->actual_achived_2 = $request->actual_achived;
                $kpi->status_2 = '2'; // 2: admin evaluated
              }
            //// end
          
            
            
            $kpi->save();
            $result = $this->get_rating_mechanism($eval_date[1]);
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
       
    }
    public function insert_overall_rating(Request $request)
    {   
          
            $id = $request->id; 
            $kpi = Kpi::find($id);
            $kpi->overall_rating = $request->overall_rating;
            $kpi->save();
             $res = [
                'result'=>'success',
                ];
      
       return $res;
       // return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
       
    }
    public function view_report(Request $request)
    {
    if($this->isLogged($request)){
      Session::put('nav','performance');
      Session::put('sub_nav','report');



      $company_id = Session::get('user')['id'];
      $year =date("Y");
      $assigner = DB::select('SELECT *
                              FROM objective
                              WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');
      
      foreach ($assigner as $a => $user) {
        $repeat = 0;
        foreach ($assigner as $a1 => $user1) {
          if($user->manager_id == $user1->manager_id && 
            $user->employee_id == $user1->employee_id){
            $repeat ++;
          if($repeat > 1) return redirect('admin/assign')->with('assign_error_msg', 'Assign Uncompleted!')->withInput();
          }
        }
      }
      
      
      $force_ranking = DB::select('SELECT *
                                    FROM force_rank
                                    WHERE company_id = '.$company_id.' AND  created_at LIKE "'.$year.'%"');
      $performance = DB::select('SELECT *
                                    FROM percent
                                    WHERE company_id = '.$company_id.' AND  created_at LIKE "'.$year.'%"');

      ////get_evalDate
              $eval_date = $this->get_evalDate();
      //// end
     
          if(isset($force_ranking[0])&&$force_ranking[0]->allowed == 1){
            $result = $this->get_rating_force($eval_date[1]);
          }

      if(count($performance)>0 && $performance[0]->allowed == 1)
      {
        $view_performance = 'allowed';
            // if(count($null_performance)>0){
          $result = $this->get_performance($eval_date[1]);
          if($result=='false'){
          return redirect('admin/percent')->with('performance_error_msg', 'Performance Result Error!')->withInput();
        }
            // }
            

            
      }else
        $view_performance = 'disallowed';
      
      
        $years=DB::select('SELECT YEAR(created_at) as years
                          FROM kpi
                          GROUP BY years
                          ORDER BY years');
        return view('admin.performance.report',compact('years','view_performance'));
      } else {
        return redirect('login');
      } 
    }

    private function get_rating_mechanism($eval_date){

      $company_id = Session::get('user')['id'];
      $mechanism = DB:: select('SELECT rate_id, achivement
                                  FROM rating_mechanism
                                  WHERE company_id = '.$company_id);
        foreach ($mechanism as $r => $rate) {
          switch ($rate->rate_id) {
              case "5":
                  $rate_5 = $rate->achivement;
                  break;
              case "4":
                  $rate_4 = $rate->achivement;
                  $rate_4 = explode("-",$rate_4);
                  break;
              case "3":
                  $rate_3 = $rate->achivement;
                  $rate_3 = explode("-",$rate_3);
                  break;
              case "2":
                  $rate_2 = $rate->achivement;
                  $rate_2 = explode("-",$rate_2);
                  break;
              case "1":
                  $rate_1 = $rate->achivement;
                  break;
              default:
                  break;
          }
        }
      $year =date("Y");
      
          if($eval_date=='mid') 
            $kpi = DB::select('SELECT *, actual_achived_1/target*100 as achived
                      FROM kpi
                      WHERE company_id ='.$company_id.' AND created_at LIKE "'.$year.'%"
                      ');
          else 
            $kpi = DB::select('SELECT *, actual_achived_2/target*100 as achived
                      FROM kpi
                      WHERE company_id ='.$company_id.' AND created_at LIKE "'.$year.'%"
                      ');
      for ($i=0; $i < count($kpi); $i++) { 
        if($kpi[$i]->status_1 == 2 || $kpi[$i]->status_2 == 2){
          if($kpi[$i]->achived <= $rate_1){
            $kpi[$i]->rate = 1;
          }
          if($kpi[$i]->achived > $rate_1 && $kpi[$i]->achived <= $rate_2[1]){
            $kpi[$i]->rate = 2;
          }
          if($kpi[$i]->achived > $rate_2[1] && $kpi[$i]->achived <= $rate_3[1]){
            $kpi[$i]->rate = 3;
          }
          if($kpi[$i]->achived > $rate_3[1] && $kpi[$i]->achived <= $rate_4[1]){
            $kpi[$i]->rate = 4;
          }
          if($kpi[$i]->achived > $rate_4[1]){
            $kpi[$i]->rate = 5;
          }
        }else $kpi[$i]->rate = 1;
        // var_dump($kpi[$i]->rate);
        // die();
          $save_kpi= Kpi::find($kpi[$i]->id);
              if($eval_date=='mid') {
                $save_kpi->rate_1 = $kpi[$i]->rate;
              }else {
                $save_kpi->rate_2 = $kpi[$i]->rate;
                
              }
          $save_kpi->overall_rating = $kpi[$i]->rate;      
          $save_kpi->save();
        }

        return $success='true';
    }
    private function get_rating_force($eval_date){
      $company_id = Session::get('user')['id'];
      $year =date("Y");
      $force_ranking = DB::select('SELECT *
                                  FROM force_rank
                                  WHERE company_id = '.$company_id.' AND  created_at LIKE "'.$year.'%"
                                  ORDER BY rating DESC');
      if($eval_date=='mid') 
        $kpi = DB::select('SELECT *, actual_achived_1/target*100 as achived
                            FROM kpi
                            WHERE company_id ='.$company_id.' AND created_at LIKE "'.$year.'%"
                            ORDER BY achived DESC');
      else
        $kpi = DB::select('SELECT *, actual_achived_2/target*100 as achived
                            FROM kpi
                            WHERE company_id ='.$company_id.' AND created_at LIKE "'.$year.'%"
                            ORDER BY achived DESC');
     // return $kpi;
        for ($i=0; $i < count($kpi); $i++) { 
          if(($i+1)/count($kpi)<$force_ranking[0]->population/100){
            $kpi[$i]->rate = $force_ranking[0]->rating;
          }
          if(($i+1)/count($kpi)>$force_ranking[0]->population/100 && 
            ($i+1)/count($kpi)<($force_ranking[0]->population + $force_ranking[1]->population)/100){
            $kpi[$i]->rate = $force_ranking[1]->rating;
          }
          if(($i+1)/count($kpi)>($force_ranking[0]->population + $force_ranking[1]->population)/100 && 
            ($i+1)/count($kpi)<($force_ranking[0]->population + $force_ranking[1]->population + $force_ranking[2]->population)/100){
            $kpi[$i]->rate = $force_ranking[2]->rating;
          }
          if(($i+1)/count($kpi)>($force_ranking[0]->population + $force_ranking[1]->population + $force_ranking[2]->population)/100 && 
            ($i+1)/count($kpi)<($force_ranking[0]->population + $force_ranking[1]->population + $force_ranking[2]->population + $force_ranking[3]->population)/100){
            $kpi[$i]->rate = $force_ranking[3]->rating;
          }
          if(($i+1)/count($kpi)>($force_ranking[0]->population + $force_ranking[1]->population + $force_ranking[2]->population + $force_ranking[3]->population)/100){
            $kpi[$i]->rate = $force_ranking[4]->rating;
          }
          $save_kpi= Kpi::find($kpi[$i]->id);
              if($eval_date=='mid') 
                $save_kpi->rate_1 = $kpi[$i]->rate;
              else 
                $save_kpi->rate_2 = $kpi[$i]->rate;
          $save_kpi->overall_rating = $kpi[$i]->rate;
              
          $save_kpi->save();
        }
        return $success='true';
        
    }
     public function get_performance($eval_date)
    {
      $year = date('Y');
      $company_id = Session::get('user')['id'];
        $percent = DB::select('SELECT *
                               FROM percent
                              WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');
        foreach ($percent as $p => $p_value) {
          if($p_value->level=='CEO'){
            $company_percent_1 = $p_value->company_percent/100;
          }
          if($p_value->level=='Manager'){
            $company_percent_2 = $p_value->company_percent/100;
            $department_percent_2 = $p_value->department_percent/100;
          }
          if($p_value->level=='Employee'){
            $company_percent_3 = $p_value->company_percent/100;
            $department_percent_3 = $p_value->department_percent/100;
            $individual_percent_3 = $p_value->individual_percent/100;
          }
        }
        $company_id = Session::get('user')['id'];
        $user=array();
        $admin= DB::select('SELECT a.*, b.name as grade, a.department as department_name, d.overall_rating ,d.id as kpi_id
                             FROM users a
                             LEFT JOIN grade b ON a.grade_id = b.id
                             LEFT JOIN objective c ON a.id = c.company_id
                             LEFT JOIN kpi d ON c.id = d.objective_id
                            WHERE a.id = '.$company_id.' AND c.manager_id = 0 AND c.employee_id = 0 AND d.completion_date LIKE "'.$year.'%"');
        if(count($admin)>0){
          if($eval_date=='mid')
            $admin[0]->performance = round(($admin[0]->overall_rating * $company_percent_1),1);
          else 
            $admin[0]->performance = round(($admin[0]->overall_rating * $company_percent_1),1);
          array_push($user, $admin[0]);

          $manager = DB::select('SELECT a.*, b.name as grade, a.department as department_name, d.overall_rating ,d.id as kpi_id
                               FROM users a
                               LEFT JOIN grade b ON a.grade_id = b.id
                               LEFT JOIN objective c ON a.id = c.manager_id
                              LEFT JOIN kpi d ON c.id = d.objective_id
                              WHERE a.parent_id = '.$company_id.' AND c.employee_id = 0 AND c.manager_id <> 0 AND d.completion_date LIKE "'.$year.'%"');
          foreach ($manager as $key => $value) { 
            if($eval_date=='mid')
              $value->performance = round(($admin[0]->overall_rating * $company_percent_2) + ($value->overall_rating * $department_percent_2),1); 
            else
              $value->performance = round(($admin[0]->overall_rating * $company_percent_2) + ($value->overall_rating * $department_percent_2),1);         
              
              array_push($user, $value);         
              $employee = DB::select('SELECT a.*, b.name as grade, c.department as department_name, e.overall_rating ,e.id as kpi_id
                                       FROM users a
                                       LEFT JOIN grade b ON a.grade_id = b.id
                                       LEFT JOIN users c ON a.parent_id = c.id
                                       LEFT JOIN objective d ON a.id = d.employee_id
                                      LEFT JOIN kpi e ON d.id = e.objective_id
                                      WHERE a.parent_id = '.$value->id.' AND d.employee_id <> 0 AND e.completion_date LIKE "'.$year.'%"');
              foreach ($employee as $key1 => $value1) {
                if($eval_date=='mid')
                  $value1->performance = round(($admin[0]->overall_rating * $company_percent_3) + ($value->overall_rating * $department_percent_3) + ($value1->overall_rating * $individual_percent_3),1);
                else
                  $value1->performance = round(($admin[0]->overall_rating * $company_percent_3) + ($value->overall_rating * $department_percent_3) + ($value1->overall_rating * $individual_percent_3),1);
                array_push($user, $value1);
            }               
          }   
        }

        if(count($user)>0){
          foreach ($user as $key2 => $value2) { 
            $user[$key2]->no = $key2+1;
            $kpi=DB::select('SELECT *
                         FROM kpi
                        WHERE id = '.$value2->kpi_id
                        );
              if($eval_date=='mid'){
                $save_kpi= Kpi::find($value2->kpi_id);
                $save_kpi->performance_1 = $value2->performance;
                $save_kpi->save();
              } else {
                $save_kpi= Kpi::find($value2->kpi_id);
                $save_kpi->performance_2 = $value2->performance;
                $save_kpi->save();
              }           
            }

            return $success='true';
        }else return $success='false';
        
      
    }

    public function report_kpi_list(Request $request)
    {   
        $year = $request->year;
        $company_id = $request->session()->get('user')['id'];
        $eval_date = $this->get_evalDate();
        if($eval_date[1]=='mid'){
          $status = 'status_1';
        }else $status = 'status_2';
        $main = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id,a.id as obj_id, b.* 
                             FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%" AND b.'.$status.' = 2');  
        $table_data['data'] = array();
        foreach ($main as $key => $value) {         
           $sub = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id, b.* 
                         FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                        WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->objective_id.' AND b.'.$status.' = 2');
           
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

    public function report_bonus_list(Request $request)
    { 
        $year = $request->year;
        $company_id = Session::get('user')['id'];
        $user=array();
        //////  table view
        if($year==date('Y')){     
          ////get_evalDate
            $eval_date = $this->get_evalDate();
          //// end
          if($eval_date[1]=='mid'){
              $admin= DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.overall_rating as rating, c.performance_1 as performance
                                  FROM users a
                                   LEFT JOIN grade b ON a.grade_id = b.id
                                   LEFT JOIN objective d ON a.id = d.company_id 
                                   LEFT JOIN kpi c ON d.id = c.objective_id
                                  WHERE a.id = '.$company_id.' AND d.manager_id = 0  AND d.employee_id = 0 AND c.completion_date LIKE "'.$year.'%"');
              if(count($admin)>0 ) array_push($user, $admin[0]);
              $manager = DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.overall_rating as rating, c.performance_1 as performance
                                     FROM users a
                                     LEFT JOIN grade b ON a.grade_id = b.id
                                     LEFT JOIN objective d ON a.id = d.manager_id 
                                     LEFT JOIN kpi c ON d.id = c.objective_id
                                     WHERE a.parent_id = '.$company_id.' AND d.employee_id = 0 AND d.manager_id <> 0 AND c.completion_date LIKE "'.$year.'%"');

              foreach ($manager as $key => $value) {            
                  array_push($user, $value);         
                  $employee = DB::select('SELECT a.*, b.name as grade, c.department as department_name, d.overall_rating as rating, d.performance_1 as performance
                                           FROM users a
                                           LEFT JOIN grade b ON a.grade_id = b.id
                                           LEFT JOIN users c ON a.parent_id = c.id
                                           LEFT JOIN objective e ON a.id = e.employee_id 
                                           LEFT JOIN kpi d ON e.id = d.objective_id
                                           WHERE a.parent_id = '.$value->id.' AND e.employee_id <> 0 AND d.completion_date LIKE "'.$year.'%"');
                  foreach ($employee as $key1 => $value1) {
                    array_push($user, $value1);
                  }               
              }    
            }else {
                  $admin= DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.overall_rating as rating, c.performance_2 as performance
                                      FROM users a
                                       LEFT JOIN grade b ON a.grade_id = b.id
                                       LEFT JOIN objective d ON a.id = d.company_id 
                                       LEFT JOIN kpi c ON d.id = c.objective_id
                                      WHERE a.id = '.$company_id.' AND d.manager_id = 0  AND d.employee_id = 0 AND c.completion_date LIKE "'.$year.'%"');
                  if(count($admin)>0 ) array_push($user, $admin[0]);
                  $manager = DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.overall_rating as rating, c.performance_2 as performance
                                         FROM users a
                                         LEFT JOIN grade b ON a.grade_id = b.id
                                         LEFT JOIN objective d ON a.id = d.manager_id 
                                         LEFT JOIN kpi c ON d.id = c.objective_id
                                         WHERE a.parent_id = '.$company_id.' AND d.employee_id = 0 AND d.manager_id <> 0 AND c.completion_date LIKE "'.$year.'%"');
                  foreach ($manager as $key => $value) {            
                    array_push($user, $value);         
                    $employee = DB::select('SELECT a.*, b.name as grade, c.department as department_name, d.overall_rating as rating, d.performance_2 as performance
                                             FROM users a
                                             LEFT JOIN grade b ON a.grade_id = b.id
                                             LEFT JOIN users c ON a.parent_id = c.id
                                             LEFT JOIN objective e ON a.id = e.employee_id 
                                             LEFT JOIN kpi d ON e.id = d.objective_id
                                             WHERE a.parent_id = '.$value->id.' AND e.employee_id <> 0 AND d.completion_date LIKE "'.$year.'%"');
                    foreach ($employee as $key1 => $value1) {
                      array_push($user, $value1);
                    }               
                  }    
            } 

            $cute_date = DB::select('SELECT *
                                    FROM cute_date
                                    WHERE company_id = '.$company_id);
            if(count($cute_date)>0) $cute = strtotime($cute_date[0]->cute_date);
            else $cute = strtotime(date('Y-m-d'));
            if($request->get_bonus_value=='yes'){
              foreach ($user as $key2 => $value2) { 
                
                $DOJ = strtotime($user[$key2]->DOJ);
                $today = strtotime(date('Y-m-d'));
                if($cute > $DOJ)
                  $work_days= ceil(($today-$cute)/60/60/24);
                else 
                  $work_days= 0;

                $user[$key2]->no = $key2+1;
                $bonus = DB::select('SELECT *
                                    FROM bonus
                                    WHERE company_id = '.$company_id.' AND grade_id = '.$user[$key2]->grade_id);
                switch ($user[$key2]->rating) {
                    case "5":
                        $user[$key2]->bonus_num = $bonus[0]->num_5;
                        $user[$key2]->bonus_amount = round($bonus[0]->amount_5/365*$work_days,2);
                        $user[$key2]->bonus_increase = round($bonus[0]->increase_5/100*$user[$key2]->basic_salary*$work_days,2);
                        break;
                    case "4":
                        $user[$key2]->bonus_num = $bonus[0]->num_4;
                        $user[$key2]->bonus_amount = round($bonus[0]->amount_4/365*$work_days, 2);
                        $user[$key2]->bonus_increase = round($bonus[0]->increase_4/100*$user[$key2]->basic_salary*$work_days,2);
                        break;
                    case "3":
                        $user[$key2]->bonus_num = $bonus[0]->num_3;
                        $user[$key2]->bonus_amount = round($bonus[0]->amount_3/365*$work_days,2);
                        $user[$key2]->bonus_increase = round($bonus[0]->increase_3/100*$user[$key2]->basic_salary*$work_days,2);
                        break;
                    case "2":
                        $user[$key2]->bonus_num = $bonus[0]->num_2;
                        $user[$key2]->bonus_amount = round($bonus[0]->amount_2/365*$work_days,2);
                        $user[$key2]->bonus_increase = round($bonus[0]->increase_2/100*$user[$key2]->basic_salary*$work_days,2);
                        break;
                    case "1":
                        $user[$key2]->bonus_num = $bonus[0]->num_1;
                        $user[$key2]->bonus_amount = round($bonus[0]->amount_1/365*$work_days,2);
                        $user[$key2]->bonus_increase = round($bonus[0]->increase_1/100*$user[$key2]->basic_salary*$work_days,2);
                        break;
                    default:
                        $user[$key2]->bonus_num = $bonus[0]->num_1;
                        $user[$key2]->bonus_amount = $bonus[0]->amount_1/365*$work_days;
                        $user[$key2]->bonus_increase = $bonus[0]->increase_1/100*$user[$key2]->basic_salary*$work_days;
                        break;
                }

                  ///// insert history table
                $bonus_history = DB::select('SELECT *
                                            FROM bonus_history
                                            WHERE user_id = '.$user[$key2]->id.' AND created_at LIKE "'.$year.'%"');
                if(count($bonus_history)>0){
                  $bonus_history = BonusHistory::find($bonus_history[0]->id);
                  $bonus_history->bonus_amount = $user[$key2]->bonus_amount;
                  $bonus_history->bonus_increase = $user[$key2]->bonus_increase;
                  $bonus_history->save();
                }else{
                  $bonus_history = new BonusHistory;
                  $bonus_history->user_id = $user[$key2]->id;
                  $bonus_history->rating = $user[$key2]->rating;
                  $bonus_history->bonus_num = $user[$key2]->bonus_num;
                  $bonus_history->bonus_amount = $user[$key2]->bonus_amount;
                  $bonus_history->bonus_increase = $user[$key2]->bonus_increase;
                  $bonus_history->created_at = date('Y-m-d H:i:s');
                  $bonus_history->save();
                }


              }
            } else{
                foreach ($user as $key2 => $value2) {            
                $user[$key2]->no = $key2+1;
                $bonus = DB::select('SELECT *
                                    FROM bonus
                                    WHERE company_id = '.$company_id.' AND grade_id = '.$user[$key2]->grade_id);
                switch ($user[$key2]->rating) {
                    case "5":
                        $user[$key2]->bonus_num = $bonus[0]->num_5;
                        $user[$key2]->bonus_amount = '';
                        $user[$key2]->bonus_increase = '';
                        break;
                    case "4":
                        $user[$key2]->bonus_num = $bonus[0]->num_4;
                        $user[$key2]->bonus_amount = '';
                        $user[$key2]->bonus_increase = '';
                        break;
                    case "3":
                        $user[$key2]->bonus_num = $bonus[0]->num_3;
                        $user[$key2]->bonus_amount = '';
                        $user[$key2]->bonus_increase = '';
                        break;
                    case "2":
                        $user[$key2]->bonus_num = $bonus[0]->num_2;
                        $user[$key2]->bonus_amount = '';
                        $user[$key2]->bonus_increase = '';
                        break;
                    case "1":
                        $user[$key2]->bonus_num = $bonus[0]->num_1;
                        $user[$key2]->bonus_amount = '';
                        $user[$key2]->bonus_increase = '';
                        break;
                    default:
                        $user[$key2]->bonus_num = $bonus[0]->num_1;
                        $user[$key2]->bonus_amount = '';
                        $user[$key2]->bonus_increase = '';
                        break;
                }
              }
            }     
        }else{ //// history view
          $admin= DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.bonus_num,c.bonus_amount,c.bonus_increase,c.rating
                              FROM users a
                               LEFT JOIN grade b ON a.grade_id = b.id
                               LEFT JOIN bonus_history c ON a.id = c.user_id 
                              WHERE a.id = '.$company_id.' AND c.created_at LIKE "'.$year.'%"');
          if(count($admin)>0 ) array_push($user, $admin[0]);
          $manager = DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.bonus_num,c.bonus_amount,c.bonus_increase,c.rating
                                 FROM users a
                                 LEFT JOIN grade b ON a.grade_id = b.id
                                 LEFT JOIN bonus_history c ON a.id = c.user_id 
                                 WHERE a.parent_id = '.$company_id.' AND c.created_at LIKE "'.$year.'%"');
          foreach ($manager as $key => $value) {            
                  array_push($user, $value);         
                  $employee = DB::select('SELECT a.*, b.name as grade, d.department as department_name, c.bonus_num,c.bonus_amount,c.bonus_increase,c.rating
                                           FROM users a
                                           LEFT JOIN grade b ON a.grade_id = b.id
                                           LEFT JOIN users d ON a.parent_id = d.id
                                           LEFT JOIN bonus_history c ON a.id = c.user_id 
                                           WHERE a.parent_id = '.$value->id.' AND c.created_at LIKE "'.$year.'%"');
                  foreach ($employee as $key1 => $value1) {
                    array_push($user, $value1);
                  }               
            } 
           foreach ($user as $key2 => $value2) {            
                $user[$key2]->no = $key2+1;
            }  
        }
      
        
      $table_data['data']=$user;
      echo json_encode($table_data);   
    }
    public function exportAll()
    {
        $year = date('Y');
        $company_id = Session::get('user')['id'];
        $user=array();
        $admin= DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.bonus_num,c.bonus_amount,c.bonus_increase,c.rating
                              FROM users a
                               LEFT JOIN grade b ON a.grade_id = b.id
                               LEFT JOIN bonus_history c ON a.id = c.user_id 
                              WHERE a.id = '.$company_id.' AND c.created_at LIKE "'.$year.'%"');
          if(count($admin)>0 ) array_push($user, $admin[0]);
          $manager = DB::select('SELECT a.*, b.name as grade, a.department as department_name, c.bonus_num,c.bonus_amount,c.bonus_increase,c.rating
                                 FROM users a
                                 LEFT JOIN grade b ON a.grade_id = b.id
                                 LEFT JOIN bonus_history c ON a.id = c.user_id 
                                 WHERE a.parent_id = '.$company_id.' AND c.created_at LIKE "'.$year.'%"');
          foreach ($manager as $key => $value) {            
                  array_push($user, $value);         
                  $employee = DB::select('SELECT a.*, b.name as grade, d.department as department_name, c.bonus_num,c.bonus_amount,c.bonus_increase,c.rating
                                           FROM users a
                                           LEFT JOIN grade b ON a.grade_id = b.id
                                           LEFT JOIN users d ON a.parent_id = d.id
                                           LEFT JOIN bonus_history c ON a.id = c.user_id 
                                           WHERE a.parent_id = '.$value->id.' AND c.created_at LIKE "'.$year.'%"');
                  foreach ($employee as $key1 => $value1) {
                    array_push($user, $value1);
                  }               
            } 
        ini_set('max_execution_time', '0');
        require_once dirname(__FILE__) . '/../../../../excel/PHPExcel.php';
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        $pCol = 0;
        $pRow = 1;

        $First_name = array('User Name','Department','Grade','DOJ','Basic Salary','Rate','Bonus Number', 'Bonus Amount', 'Bonus Increase');
        $field_name = array('full_name','department_name','grade','DOJ','basic_salary','rating','bonus_num', 'bonus_amount', 'bonus_increase');
        for ($pCol = 0; $pCol < count($First_name); $pCol++){
            $sheet->setCellValueByColumnAndRow($pCol, $pRow,$First_name[$pCol]);
        }
        $pCol = 0;
        $pRow = 2;

        foreach ($user as $row) {
          if (is_object($row)) {
                  foreach ($row as $key => $value) {
                      $array[$key] = $value;
                  }
              }

            for ($pCol = 0; $pCol < count($field_name); $pCol++){
                $sheet->setCellValueByColumnAndRow($pCol, $pRow,$array[$field_name[$pCol]]);
            }
            $pRow++;
        }
        header('Content-Encoding: utf-8');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="BonusReview'.date('Y-m-d H:i:s').'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

     public function exportKPI()
    {
        $year = date('Y');
        $company_id = Session::get('user')['id'];
        $eval_date = $this->get_evalDate();
        if($eval_date[1]=='mid'){
          $status = 'status_1';
        }else $status = 'status_2';
        $main = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id,a.id as obj_id, b.* 
                             FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%" AND b.'.$status.' = 2');  
        $table_data['data'] = array();
        foreach ($main as $key => $value) {         
           $sub = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id, b.* 
                         FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                        WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->objective_id.' AND b.'.$status.' = 2');
           
           if(count($sub)>0){
              $value->has_sub=1;
            }else $value->has_sub=0;
            array_push($table_data['data'], $value);
            foreach ($sub as $s) {
              array_push($table_data['data'], $s);
              
            }
        }    
        ini_set('max_execution_time', '0');
        require_once dirname(__FILE__) . '/../../../../excel/PHPExcel.php';
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        $pCol = 0;
        $pRow = 1;

        $First_name = array('Type','Objective','Completion Date','Target Type','Target','Mid Year Achieved','End Year Achieved','Weights', 'Overall Rating');
        $field_name = array('type','name','completion_date','target_type','target','actual_achived_1', 'actual_achived_2', 'weights','overall_rating');
        for ($pCol = 0; $pCol < count($First_name); $pCol++){
            $sheet->setCellValueByColumnAndRow($pCol, $pRow,$First_name[$pCol]);
        }
        $pCol = 0;
        $pRow = 2;

        foreach ($table_data['data'] as $row) {
          if (is_object($row)) {
                  foreach ($row as $key => $value) {
                      $array[$key] = $value;
                  }
              }

            for ($pCol = 0; $pCol < count($field_name); $pCol++){
                $sheet->setCellValueByColumnAndRow($pCol, $pRow,$array[$field_name[$pCol]]);
            }
            $pRow++;
        }
        header('Content-Encoding: utf-8');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="Objective'.date('Y-m-d H:i:s').'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    

  public function view_chart(Request $request)
    {
       $company_id = Session::get('user')['id'];
       $year =date("Y");
       if($this->isLogged($request)){
        Session::put('nav','performance');
        Session::put('sub_nav','report');
        // $result = $this->get_chart_value($company_id);
        // $lebels->1 = $result['name'];
        // $data->2 = $result['rate'];
        return view('admin.performance.view_chart');
      } else {
        return redirect('login');
      } 
    }

  public function get_chart_value(Request $request){
    $year =date("Y");
    ////get_evalDate
    $eval_date = $this->get_evalDate();
    //// end
      $company_id = $request->session()->get('user')['id'];
      $main = DB::select('SELECT * 
                           FROM objective
                          WHERE company_id = '.$company_id.' AND is_sub = 0'); 
      
      $objective=array();
      foreach ($main as $key => $value) {        

          // $value->sub_name='';
          array_push($objective, $value);
        
          $sub = DB::select('SELECT a.name , a.is_sub, a.type, a.created_at, a.id
                       FROM objective a
                       LEFT JOIN objective b ON a.parent_id = b.id
                      WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->id);
          foreach ($sub as $key1 => $value1) {
             array_push($objective, $value1);
          } 
      }

      $performance=array();
      $i=0;
      foreach ($objective as $key2 => $value2) {  
        $kpi=DB::select('SELECT *
                         FROM kpi
                        WHERE objective_id = '.$value2->id.' AND completion_date LIKE "'.$year.'%"');
        
        if($eval_date[1]='mid'){
            $kpi[0]->status = $kpi[0]->status_1;
        }
        else{
            $kpi[0]->status = $kpi[0]->status_2;
        } 
        if(count($kpi)>0 && $kpi[0]->status == 2){

          $objective[$key2]->rating = $kpi[0]->overall_rating;
          $performance[$i]=$objective[$key2];
          $i++;
          $performance[$i-1]->no = $i;
        }else {
          continue;
        }
      }
     
      $result['name'] = array();
      $result['rate'] = array();
      foreach ($performance as $key3 => $value3) {
       array_push($result['name'], $value3->name);
       array_push($result['rate'], $value3->rating);
      }
      
      echo json_encode($result);   

   }

}