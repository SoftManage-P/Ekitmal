<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Kpi;
use stdClass;
class DashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //    if($this->isLogged($request)){
            
    //         return view('employee.dashboard.dashboard');
    //     } else {
    //         return redirect('login');
    //     } 
    // }

    public function view_evaluation(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','performance');
            Session::put('sub_nav','evaluation');

            return view('employee.dashboard.evaluation');
        } else {
            return redirect('login');
        } 
    }
    // private function get_evalDate(){
    //     $employee_id = Session::get('user')['id'];
    //     $company = DB::select('SELECT b.parent_id as company_id
    //       FROM users a
    //       LEFT JOIN users b ON a.parent_id = b.id
    //       WHERE a.id = '.$employee_id);
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

        $user_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT * 
                             FROM objective
                            WHERE employee_id = '.$user_id.' AND is_sub = 0');
        $sub_1 = DB::select('SELECT a.name as sub_name, b.name, a.is_sub, a.type, a.created_at, a.id
                           FROM     objective a
                       LEFT JOIN    objective b ON a.parent_id = b.id
                          WHERE     a.employee_id = '.$user_id.' AND a.is_sub = "1" '); 
        $table_data['data']=array();
        if(count($sub_1)>0){
          foreach ($sub_1 as $s => $sub_ob) {
            array_push($table_data['data'], $sub_ob);
          }
        }
        ////check schedule
               $eval_date = $this->get_evalDate();     
        //// check schedule end
        ////get objective
        foreach ($main as $key => $value) {        

          $value->sub_name='';
          array_push($table_data['data'], $value);
        
          $sub = DB::select('SELECT a.name as sub_name, b.name, a.is_sub, a.type, a.created_at, a.id
                           FROM     objective a
                       LEFT JOIN    objective b ON a.parent_id = b.id
                          WHERE     a.employee_id = '.$user_id.' AND a.is_sub = "1" ');
          foreach ($sub as $key1 => $value1) {
            array_push($table_data['data'], $value1);
          } 
        }
          // var_dump($user_id);
          // die();
        $objective = $table_data['data'];
        $performance=array();
        $i=0;
        foreach ($objective as $key2 => $value2) {            
          $kpi=DB::select('SELECT *
                           FROM kpi
                          WHERE objective_id = '.$value2->id
                          );
            
          if(count($kpi)>0){
            $objective[$key2]->descript_target=$kpi[0]->descript_target;
            $objective[$key2]->target_type=$kpi[0]->target_type;
            $objective[$key2]->weights=$kpi[0]->weights;
            $objective[$key2]->completion_date=$kpi[0]->completion_date;
            if($eval_date[1]=='last'){
              $objective[$key2]->actual_achived=$kpi[0]->actual_achived_2;
              $objective[$key2]->status=$kpi[0]->status_2;
            }else{
              $objective[$key2]->actual_achived=$kpi[0]->actual_achived_1;
              $objective[$key2]->status=$kpi[0]->status_1;
            }
            $objective[$key2]->target=$kpi[0]->target;
            
            $performance[$key2]=$objective[$key2];
            $i++;
            $performance[$key2]->no = $i;
          }else {
            continue;
          }
        }
        $table_data['data']=$performance;
      echo json_encode($table_data);   
      
    }

    public function edit_evaluation($id)
    {
      $eval_date = $this->get_evalDate();
      if($eval_date[0]=='no') return redirect('employee')->with('eval_date_error', 'Evaluation date not yet!')->withInput();
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
            return view('employee.dashboard.evaluation_edit', compact('objective','kpi'));
        } else {
            return view('employee.dashboard.evaluation_edit', compact('objective'));
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
              }else{
                $kpi->actual_achived_2 = $request->actual_achived;
              }
            //// end
            $kpi->status = '0'; // 2: manager evaluated
            $kpi->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
       
    }
    

    
}