<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Users;
use App\Objective;
use App\Kpi;
use stdClass;
class SettingsController extends Controller
{
    public function viewObjective(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','setting');
            Session::put('sub_nav','objective');

            return view('manager.Settings.objective');
        } else {
            return redirect('login');
        } 
    }

    public function objectivelist(Request $request)
    {
        $year = date('Y');
        $manager_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT a.* 
                             FROM objective a
                            WHERE a.manager_id = '.$manager_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%"'); 

        $table_data['data'] = array();
        
        foreach ($main as $key => $value) {        
            $sub = DB::select('SELECT a.*
                         FROM objective a
                         LEFT JOIN objective b ON a.parent_id = b.id
                        WHERE a.manager_id = '.$manager_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->id);
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
      Session::put('nav','setting');
      Session::put('sub_nav','objective');

      $manager_id = Session::get('user')['id'];
      
      $mainobjective = DB::select('SELECT *
                                FROM objective
                                WHERE manager_id = '.$manager_id.' AND is_sub = "0"'
                                );
      
      
       if($id == 0){
            return view('manager.settings.objective_edit', compact('mainobjective'));
        } else {
            $objective = DB::select('SELECT *
                                FROM objective
                                WHERE id ='.$id);

            return view('manager.settings.objective_edit', compact('objective','mainobjective'));
        } 
    }
    public function insert_objective(Request $request)
    {   
        $company_id = DB::select('SELECT a.id
                                  FROM users a
                                  LEFT JOIN users b ON a.id = b.parent_id
                                  WHERE b.id = '.$request->session()->get('user')['id']);
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
            $objective->manager_id = $request->session()->get('user')['id'];
            $objective->company_id = $company_id[0]->id;

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
            $objective->company_id = $company_id[0]->id;
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
        $manager_id = $request->session()->get('user')['id'];
        $objective = DB::select('SELECT id 
                             FROM objective
                            WHERE manager_id = '.$manager_id.' AND created_at LIKE "'.$year.'%"');
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
            Session::put('nav','setting');
            Session::put('sub_nav','kpi');

            return view('manager.Settings.kpi');
        } else {
            return redirect('login');
        } 
    }
     public function kpi_list(Request $request)
    {
        $year = date('Y');
        $manager_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id,a.id as obj_id, b.* 
                             FROM objective a
                             LEFT JOIN kpi b ON a.id = b.objective_id
                            WHERE a.manager_id = '.$manager_id.' AND a.is_sub = 0 AND a.created_at LIKE "'.$year.'%"'); 

        $table_data['data'] = array();
        
        foreach ($main as $key => $value) {        
            $sub = DB::select('SELECT a.type,a.name,a.is_sub,a.parent_id,a.id as obj_id, b.* 
                         FROM objective a
                         LEFT JOIN kpi b ON a.id = b.objective_id
                        WHERE a.manager_id = '.$manager_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->obj_id);
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
      Session::put('nav','setting');
      Session::put('sub_nav','kpi');

      $company_id = Session::get('user')['id'];
      
      $kpi=DB::select('SELECT *
                         FROM kpi
                        WHERE objective_id = '.$id);
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
            return view('manager.settings.kpi_edit', compact('objective','kpi'));
        } else {
            return view('manager.settings.kpi_edit', compact('objective'));
        } 
    }

    public function insert_kpi(Request $request)
    {   

        if($request->id==0){
            $kpi = new Kpi;
            $kpi->objective_id = $request->objective_id;
            $kpi->target_type = $request->target_type;
            $kpi->completion_date = $request->completion_date;
            $kpi->weights = $request->weights;
            $kpi->descript_target = $request->descript_target;
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
            
            $kpi->save();
            return redirect()->back()->with('success_msg', 'Update Success!')->withInput(); 
        }
       
    }
}