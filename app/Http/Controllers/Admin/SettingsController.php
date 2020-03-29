<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Users;
use App\Objective;
use App\Kpi;
use App\Grade;
use App\Bonus;
use App\Percent;
use App\RatingMechanism;
use App\ForceRanking;
use App\Cute_date;
use stdClass;
class SettingsController extends Controller
{
    public function viewObjective(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','objective');
      

            return view('admin.Settings.objective');
        } else {
            return redirect('login');
        } 
    }

    public function objectivelist(Request $request)
    {
        $year = date('Y');
        $company_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT * 
                             FROM objective
                            WHERE company_id = '.$company_id.' AND is_sub = 0 AND created_at LIKE "'.$year.'%"');  
        $table_data['data'] = array();
        foreach ($main as $key => $value) { 
            
           $sub = DB::select('SELECT a.*
                         FROM objective a
                         LEFT JOIN objective b ON a.parent_id = b.id
                        WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->id);
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
    public function editobjective($id)
    {
      Session::put('nav','objective');
   

      $company_id = Session::get('user')['id'];
      
      $mainobjective = DB::select('SELECT *
                                FROM objective
                                WHERE company_id = '.$company_id.' AND is_sub = "0"'
                                );
        if($id == 0){
            return view('admin.settings.objective_edit', compact('mainobjective'));
        } else {
            $objective = DB::select('SELECT *
                                FROM objective
                                WHERE id ='.$id);
            return view('admin.settings.objective_edit', compact('objective','mainobjective'));
        } 
    }
    public function insert_objective(Request $request)
    {   

        if($request->id==0){

          
            $objective = new Objective;
            $objective->type = $request->type;
            $objective->name = $request->name;
            if($request->check=="on"){
             
              $objective->is_sub = '1';
              $objective->parent_id = $request->parent_id;
              if ($objective->parent_id=='0') {
                return redirect()->back()->with('error_msg', 'Please Select Main Objective!')->withInput(); 
              }
            }else{
              $objective->is_sub = '0';
              if ($request->parent_id !='0') {
                return redirect()->back()->with('error_msg', 'Please Check "Is Sub Objective" !')->withInput(); 
              }
              $objective->parent_id = '0';

            }
            $objective->created_at = date('Y-m-d H:i:s');
            $objective->company_id = $request->session()->get('user')['id'];

            $objective->save();
            return redirect()->back()->with('success_msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $objective = Objective::find($id);
            $objective->type = $request->type;
            $objective->name = $request->name;
            if($request->check=="on"){
              $objective->is_sub = '1';
               
              $objective->parent_id = $request->parent_id;
              if ($objective->parent_id=='0') {
                return redirect()->back()->with('error_msg', 'Please Select Main Object!')->withInput(); 
              }
            }else{
              $objective->is_sub = '0';
               if ($request->parent_id !='0') {
                return redirect()->back()->with('error_msg', 'Please Check "Is Sub Objective" !')->withInput(); 
              }
              $objective->parent_id = '0';
            }
            $objective->created_at = date('Y-m-d H:i:s');
            $objective->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
        }
       
    }
    public function delete_objective(Request $request){
      $id = $request->id;
      $objective = Objective::find($id);
      $objective->delete();  
      $sub = DB::select('SELECT *
                         FROM objective 
                        WHERE parent_id = '.$id);
      foreach ($sub as $key => $value) {
        $objective = Objective::find($value->id);
        $objective->delete();  
      }
      $res = [
              "success" => true,                    
          ]; 
      echo json_encode($res); 
    }
    public function view_kpi(Request $request)
    {
        $year = date('Y');
        $company_id = $request->session()->get('user')['id'];
        $objective = DB::select('SELECT id 
                             FROM objective
                            WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');
        foreach ($objective as $o) {
          $kpi = DB::select('SELECT id
                             FROM kpi
                            WHERE objective_id = '.$o->id
                            );
          if(count($kpi)<1){
            $kpi = new Kpi;
            $kpi->objective_id = $o->id;
            $kpi->created_at = date('Y-m-d H:i:s');
            $kpi->save();
          }
        }
       if($this->isLogged($request)){
            Session::put('nav','kpi');
            

            return view('admin.Settings.kpi');
        } else {
            return redirect('login');
        } 
    }
    public function kpi_list(Request $request)
    {
        $year = date('Y');
        $company_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id,a.id as main_id, b.* 
                             FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                            WHERE a.company_id = '.$company_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%"');  
        $table_data['data'] = array();
        foreach ($main as $key => $value) {         
           $sub = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id, b.* 
                         FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                        WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->objective_id);
           
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

    public function edit_kpi($id)
    {
      Session::put('nav','kpi');
     

      $company_id = Session::get('user')['id'];
      
      $kpi=DB::select('SELECT *
                         FROM kpi
                        WHERE id = '.$id);
      $objective = DB::select('SELECT *
                                FROM objective
                                WHERE id ='.$kpi[0]->objective_id);
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
            return view('admin.settings.kpi_edit', compact('objective','kpi'));
        } else {
            return view('admin.settings.kpi_edit', compact('objective'));
        } 
    }

    public function insert_kpi(Request $request)
    {   
        $company_id = Session::get('user')['id'];
        $weights_sum = DB::select('SELECT SUM(weights) as weights_sum
                         FROM kpi
                        WHERE company_id = '.$company_id.' AND created_at LIKE "'.date('Y').'%" AND id <> '.$request->id);
        // var_dump($weights_sum[0]->weights_sum);
        // die();
        if(($weights_sum[0]->weights_sum + $request->weights)>100){
          return redirect()->back()->with('error_msg', 'Weights value is over!')->withInput(); 
        }
        if($request->id==0){
            $kpi = new Kpi;
            $kpi->objective_id = $request->objective_id;
            $kpi->target_type = $request->target_type;
            $kpi->completion_date = $request->completion_date;
            $kpi->weights = $request->weights;
            $kpi->descript_target = $request->descript_target;
            $kpi->target = $request->target;
            $kpi->company_id = $company_id;
            $kpi->created_at = date('Y-m-d H:i:s');
            $kpi->save();
            return redirect()->back()->with('success_msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $kpi = Kpi::find($id);
            $kpi->objective_id = $request->objective_id;
            $kpi->target_type = $request->target_type;
            $kpi->completion_date = $request->completion_date;
            $kpi->weights = $request->weights;
            $kpi->descript_target = $request->descript_target;
            $kpi->target = $request->target;
            $kpi->company_id = $company_id;
            $kpi->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
        }
       
    }
    public function view_rating_mechanism(Request $request)
    { 
      $year =date("Y");
      $company_id = $request->session()->get('user')['id'];
       if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','rating_mechanism');
            for ($i=1; $i < 6 ; $i++) { 
              $rate1 = DB::select('SELECT *
                            FROM rating_mechanism
                            WHERE company_id = '.$company_id.' AND rate_id = '.$i.' AND created_at LIKE "'.$year.'%"');
              if (count($rate1)>0) {
                $rate[$i]=$rate1[0];
              }else{
                $rate[$i]=$rate1;
              }
            }
            return view('admin.Settings.rating_mechanism',compact('rate'));
        } else {
            return redirect('login');
        } 
    }
    public function insert_mechanism(Request $request)
    {   
        $company_id = $request->session()->get('user')['id'];
        $item = explode('_', $request->name);
        $value = $request->value;
        $rate = DB::select('SELECT id
                            FROM rating_mechanism
                            WHERE company_id = '.$company_id.' AND rate_id= '.$item[1]);

        if(count($rate)>0){
            $id = $rate[0]->id; 
            $rating = RatingMechanism::find($id);
            $rating->company_id = $company_id;
            $rating->rate_id = $item[1];
            if($item[0]=='result'){
              $rating->result_des = $value;
            } elseif($item[0]=='achive'){
              $rating->achivement = $value;
            }
            $rating->created_at = date('Y-m-d H:i:s');
            $rating->save();
            $res = [
                    "success" => true,                   
                ];   
            echo json_encode($res);
        }else{
            $rating = new RatingMechanism;
            $rating->company_id = $company_id;
            $rating->rate_id = $item[1];
            if($item[0]=='result'){
              $rating->result_des = $value;
            } elseif($item[0]=='achive'){
              $rating->achivement = $value;
            }
            $rating->save();
            $res = [
                    "success" => true,                   
                ];   
            echo json_encode($res);
        }
       
    }
    public function view_force_ranking(Request $request)
    {
      $year =date("Y");
      $company_id = $request->session()->get('user')['id'];
       if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','force');
            for ($i=1; $i < 6 ; $i++) { 
              $data = DB::select('SELECT *
                            FROM force_rank
                            WHERE company_id = '.$company_id.' AND rating = '.$i.' AND created_at LIKE "'.$year.'%"');
             
              if (count($data)>0) {
                $ranking[$i]=$data[0];
              }else{
                $ranking[$i]=$data;
              }

            }
// var_dump($ranking);
// die();
            return view('admin.Settings.force_ranking',compact('ranking'));
        } else {
            return redirect('login');
        } 
    }
    public function insert_force_ranking_allow(Request $request)
    {   
        $company_id = $request->session()->get('user')['id'];
        if($request->check == "on"){
          $allowed = 1;
        }else $allowed = 0;
        
        $ranking = DB::select('SELECT id
                            FROM force_rank
                            WHERE company_id = '.$company_id);

        if(count($ranking)>0){
          foreach ($ranking as $key => $value) {
            $id = $value->id; 
            $force_ranking = ForceRanking::find($id);
            $force_ranking->allowed = $allowed;
            $force_ranking->save();
          }
        }
       return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
    }
    
    public function insert_force_ranking(Request $request)
    {   
        $company_id = $request->session()->get('user')['id'];
        $item = explode('_', $request->name);
        $value = $request->value;
        $ranking = DB::select('SELECT id
                            FROM force_rank
                            WHERE company_id = '.$company_id.' AND rating= '.$item[1]);

        if(count($ranking)>0){
            $id = $ranking[0]->id; 
            $ranking = ForceRanking::find($id);
            $ranking->company_id = $company_id;
            $ranking->rating = $item[1];
            $ranking->population = $value;
            $ranking->created_at = date('Y-m-d H:i:s');
            $ranking->save();
            $res = [
                    "success" => true,                   
                ];   
            echo json_encode($res);
        }else{
            $ranking = new ForceRanking;
            $ranking->company_id = $company_id;
            $ranking->rating = $item[1];
            $ranking->population = $value;
            $ranking->save();
            $res = [
                    "success" => true,                   
                ];   
            echo json_encode($res);
        }
       
    }
    public function view_grade(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','grade');

            return view('admin.Settings.grade');
        } else {
            return redirect('login');
        } 
    }
    public function grade_list(Request $request)
    {
      $company_id = $request->session()->get('user')['id'];
      $table_data['data'] = DB::select('SELECT * 
                           FROM grade
                          WHERE company_id = '.$company_id);
      foreach ($table_data['data'] as $key => $value) {
         $table_data['data'][$key]->no = $key+1;
       } 
      echo json_encode($table_data);
    }

    public function edit_grade($id)
    {
      Session::put('nav','setting');
      Session::put('sub_nav','grade');

      $company_id = Session::get('user')['id'];
      
      $grade=DB::select('SELECT *
                         FROM grade
                        WHERE id = '.$id);
      
       if(count($grade)>0){
            return view('admin.settings.grade_edit', compact('grade'));
        } else {
            return view('admin.settings.grade_edit');
        } 
    }

    public function insert_grade(Request $request)
    {   
      $company_id = $request->session()->get('user')['id'];
        if($request->id==0){
            $grade = new Grade;
            $grade->name = $request->name;
            $grade->description = $request->description;
            $grade->company_id = $company_id;
            $grade->created_at = date('Y-m-d H:i:s');
            $grade->save();
            return redirect()->back()->with('success_msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $grade = Grade::find($id);
            $grade->name = $request->name;
            $grade->description = $request->description;
            $grade->company_id = $company_id;
            $grade->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
        }
       
    }

    public function delete_grade(Request $request){
      $id = $request->id;
      $grade = Grade::find($id);
      $grade->delete();  
      $res = [
              "success" => true,                    
          ]; 
      echo json_encode($res); 
    }
    public function view_bonus_review(Request $request)
    {
      if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','bonus');

            return view('admin.Settings.bonus_review');
        } else {
            return redirect('login');
        } 
    }

    public function bonus_list(Request $request)
    {
      $year = date('Y');
      $company_id = $request->session()->get('user')['id'];

      $grade = DB::select('SELECT *
                           FROM grade
                          WHERE company_id = '.$company_id.' 
                          ORDER BY id   ');
      foreach ($grade as $key => $value) {
        $bonus = DB::select('SELECT * 
                           FROM bonus
                          WHERE grade_id = '.$value->id.' AND created_at LIKE "'.$year.'%"');

        if(count($bonus)>0){
          $grade[$key]->num_1 = $bonus[0]->num_1;
          $grade[$key]->num_2 = $bonus[0]->num_2;
          $grade[$key]->num_3 = $bonus[0]->num_3;
          $grade[$key]->num_4 = $bonus[0]->num_4;
          $grade[$key]->num_5 = $bonus[0]->num_5;
          $grade[$key]->amount_1 = $bonus[0]->amount_1;
          $grade[$key]->amount_2 = $bonus[0]->amount_2;
          $grade[$key]->amount_3 = $bonus[0]->amount_3;
          $grade[$key]->amount_4 = $bonus[0]->amount_4;
          $grade[$key]->amount_5 = $bonus[0]->amount_5;
          $grade[$key]->increase_1 = $bonus[0]->increase_1;
          $grade[$key]->increase_2 = $bonus[0]->increase_2;
          $grade[$key]->increase_3 = $bonus[0]->increase_3;
          $grade[$key]->increase_4 = $bonus[0]->increase_4;
          $grade[$key]->increase_5 = $bonus[0]->increase_5;
        }else{
          $grade[$key]->num_1 = 0;
          $grade[$key]->num_2 = 0;
          $grade[$key]->num_3 = 0;
          $grade[$key]->num_4 = 0;
          $grade[$key]->num_5 = 0;
          $grade[$key]->amount_1 = 0;
          $grade[$key]->amount_2 = 0;
          $grade[$key]->amount_3 = 0;
          $grade[$key]->amount_4 = 0;
          $grade[$key]->amount_5 = 0;
          $grade[$key]->increase_1 = 0;
          $grade[$key]->increase_2 = 0;
          $grade[$key]->increase_3 = 0;
          $grade[$key]->increase_4 = 0;
          $grade[$key]->increase_5 = 0;
        }
      }
      $table_data['data'] = $grade;
      foreach ($table_data['data'] as $key => $value) {
         $table_data['data'][$key]->no = $key+1;
       } 
      echo json_encode($table_data);
    }
    public function get_bonus_row(Request $request){
      $company_id = $request->session()->get('user')['id'];
      $id = $request->id;
      $bonus = DB::select('SELECT a.*, b.name
                           FROM bonus a
                     LEFT JOIN  grade b ON b.id = a.grade_id 
                          WHERE a.grade_id = '.$id.' AND a.company_id = '.$company_id);
      if(count($bonus)>0){
        $res = [
            'success' => true,
            'data' => $bonus[0]
        ];
      }else {
        $res = [
            'success' => false,
            
        ];
        
      }
      return  $res;
    }

    public function insert_bonus(Request $request)
    {   
      $company_id = $request->session()->get('user')['id'];
      $type = $request->type;
      $bonus = DB::select('SELECT id
                          FROM bonus
                          WHERE id = '.$request->id);

      if(count($bonus)>0){
        $id = $request->id;
          $bonus = Bonus::find($id);
        $bonus->company_id = $company_id;
        switch ($type) {
          case "num":
              $bonus->num_1 = $request->value_1;
              $bonus->num_2 = $request->value_2;
              $bonus->num_3 = $request->value_3;
              $bonus->num_4 = $request->value_4;
              $bonus->num_5 = $request->value_5;
              break;
          case "amount":
              $bonus->amount_1 = $request->value_1;
              $bonus->amount_2 = $request->value_2;
              $bonus->amount_3 = $request->value_3;
              $bonus->amount_4 = $request->value_4;
              $bonus->amount_5 = $request->value_5;
              break;
          case "increase":
              $bonus->increase_1 = $request->value_1;
              $bonus->increase_2 = $request->value_2;
              $bonus->increase_3 = $request->value_3;
              $bonus->increase_4 = $request->value_4;
              $bonus->increase_5 = $request->value_5;
              break;
        }
        $bonus->created_at = date('Y-m-d H:i:s');
        $bonus->save();
        $res = [
        'result'=>'success',
        'type' =>$type];
      }else{
          $grade_name = $request->name;
          $grade = DB::select('SELECT id
            FROM grade
            WHERE name = "'.$grade_name.'"');
          $bonus = new Bonus;
          $bonus->grade_id = $grade[0]->id;
          $bonus->company_id = $company_id;
          switch ($type) {
            case "num":
                $bonus->num_1 = $request->value_1;
                $bonus->num_2 = $request->value_2;
                $bonus->num_3 = $request->value_3;
                $bonus->num_4 = $request->value_4;
                $bonus->num_5 = $request->value_5;
                break;
            case "amount":
                $bonus->amount_1 = $request->value_1;
                $bonus->amount_2 = $request->value_2;
                $bonus->amount_3 = $request->value_3;
                $bonus->amount_4 = $request->value_4;
                $bonus->amount_5 = $request->value_5;
                break;
            case "increase":
                $bonus->increase_1 = $request->value_1;
                $bonus->increase_2 = $request->value_2;
                $bonus->increase_3 = $request->value_3;
                $bonus->increase_4 = $request->value_4;
                $bonus->increase_5 = $request->value_5;
                break;
          }
          $bonus->created_at = date('Y-m-d H:i:s');
          $bonus->save();
          $res = [
        'result'=>'success',
        'type' =>$type];
      }
      
       return $res;
    }

    public function view_increase_review(Request $request)
    {
      if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','increase');

            return view('admin.Settings.increase_review');
        } else {
            return redirect('login');
        } 
    }
    public function view_percent(Request $request)
    {
      $year = date('Y');
      $company_id = $request->session()->get('user')['id'];
       if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','percent');
            $percent_ceo = DB::select('SELECT *
                            FROM percent
                            WHERE company_id = '.$company_id.' AND level = "CEO" AND created_at LIKE "'.$year.'%"');
            $percent_manager = DB::select('SELECT *
                            FROM percent
                            WHERE company_id = '.$company_id.' AND level = "Manager" AND created_at LIKE "'.$year.'%"');
            $percent_employee = DB::select('SELECT *
                            FROM percent
                            WHERE company_id = '.$company_id.' AND level = "Employee" AND created_at LIKE "'.$year.'%"');
            return view('admin.settings.percent',compact('percent_ceo','percent_manager','percent_employee'));
        } else {
            return redirect('login');
        } 
    }
    public function insert_percent(Request $request)
    {   
        $company_id = $request->session()->get('user')['id'];
        $item = explode('-', $request->name);
        $value = $request->value;
        $level = $request->level;
        $percent = DB::select('SELECT id
                            FROM percent
                            WHERE company_id = '.$company_id.' AND level = "'.$level.'"');
        if(count($percent)>0){
            $id = $percent[0]->id; 
            $percent = Percent::find($id);
            $percent->company_id = $company_id;
            $percent->level = $level;
            if($item[0]=='company_percent'){
              $percent->company_percent = $value;
            }
            if($item[0]=='department_percent'){
              $percent->department_percent = $value;
            }
            if($item[0]=='individual_percent'){
              $percent->individual_percent = $value;
            }
            $percent->created_at = date('Y-m-d H:i:s');
            $percent->save();
            $res = [
                    "success" => true,                   
                ];   
            echo json_encode($res);
        }else{
            $percent = new Percent;
            $percent->company_id = $company_id;
            $percent->level = $level;
            if($item[0]=='company_percent'){
              $percent->company_percent = $value;
            }
            if($item[0]=='department_percent'){
              $percent->department_percent = $value;
            }
            if($item[0]=='individual_percent'){
              $percent->individual_percent = $value;
            }
            $percent->created_at = date('Y-m-d H:i:s');
            $percent->save();
            $res = [
                    "success" => true,                   
                ];   
            echo json_encode($res);
        }
       
    }

    public function percent_allow(Request $request)
    {   
        $company_id = $request->session()->get('user')['id'];
        if($request->check == "on"){
          $allowed = 1;
        }else $allowed = 0;
        $percent = DB::select('SELECT id
                            FROM percent
                            WHERE company_id = '.$company_id);
        if(count($percent)>0){
          foreach ($percent as $key => $value) {
            $id = $value->id; 
            $percent = Percent::find($id);
            $percent ->allowed = $allowed;
            $percent ->save();
          }
        }
       return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
    }

    public function view_cute_date(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','cutedate');
            $company_id = $request->session()->get('user')['id'];
            $cutedate = DB::select('SELECT *
                            FROM cute_date
                            WHERE company_id = '.$company_id);

            return view('admin.settings.cute_date',compact('cutedate'));
        } else {
            return redirect('login');
        } 
    }


    public function insert_cutedate(Request $request)
    {   
       $company_id = $request->session()->get('user')['id'];
        if($request->id==0){
            $cutedate = new Cute_date;
            $cutedate->cute_date_pay = $request->cute_date_pay;
            $cutedate->cute_date_bonus = $request->cute_date_bonus;
        
            $cutedate->company_id = $company_id;
            $cutedate->created_at = date('Y-m-d H:i:s');
            $cutedate->save();
            return redirect()->back()->with('success_msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $cutedate = Cute_date::find($id);
            $cutedate->cute_date_pay = $request->cute_date_pay;
            $cutedate->cute_date_bonus = $request->cute_date_bonus;
            
            $cutedate->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
        }
    }
    
}