<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Users;
use stdClass;
class UserController extends Controller
{
    public function view_employee(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','user/employee');
            return view('manager.user.employee_list');
        } else {
            return redirect('login');
        } 
    }

    public function employee_list(Request $request)
    {   
        $parent_id = Session::get('user')['id'];
        $table_data['data'] = DB::select('SELECT a.*, b.name as grade, c.department as department_name
                                         FROM users a
                                         LEFT JOIN grade b ON a.grade_id = b.id
                                         LEFT JOIN users c ON a.parent_id = c.id
                                        WHERE a.user_role = "employee" AND a.parent_id = '.$parent_id );  
        foreach ($table_data['data'] as $key => $value) {            
                     
            $table_data['data'][$key] = $value;               
            
        }    

        foreach ($table_data['data'] as $key => $value) {            

          $table_data['data'][$key]->no = $key+1;               
          
        }
      echo json_encode($table_data);   
      
    }
    public function edit_employee($id)
    {
      Session::put('nav','user/employee');
      $grade = DB::select('SELECT *
                                FROM grade');
       if($id == 0){
            return view('manager.user.edit_employee', compact('grade'));
        } else {
            $employee = DB::select('SELECT *
                                FROM users
                                WHERE id ='.$id);
            

            return view('manager.user.edit_employee', compact('employee','grade'));
        } 
    }
    public function insert(Request $request)
    {   
        $parent_id = Session::get('user')['id'];
        if($request->id==0){
            $user = new Users;
            $user->user_role = $request->user_role;
            $user->user_name = $request->user_name;
            $user->full_name = $request->full_name;
            $user->parent_id = $parent_id;
            $user->email = $request->email;
            $user->DOJ = $request->DOJ;
            $user->level = $request->level;
            $user->grade_id = $request->grade_id;
            $user->phone_num = $request->phone_num;
            $user->basic_salary = $request->basic_salary;
            $user->password = $request->password;
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->back()->with('msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $user = Users::find($id);
            $user->user_role = $request->user_role;
            $user->user_name = $request->user_name;
            $user->full_name = $request->full_name;
            $user->parent_id = $parent_id;
            $user->email = $request->email;
            $user->DOJ = $request->DOJ;
            $user->level = $request->level;
            $user->grade_id = $request->grade_id;
            $user->phone_num = $request->phone_num;
            $user->basic_salary = $request->basic_salary;
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->back()->with('msg', 'Update Success!')->withInput(); 
        }
       
    }
    public function delete(Request $request){
      $id = $request->user_id;
      $user = Users::find($id);
      $user->delete();    
      $res = [
              "success" => true,                    
          ]; 
      echo json_encode($res); 
    }

}