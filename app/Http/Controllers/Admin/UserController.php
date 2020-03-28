<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Users;
use stdClass;
class UserController extends Controller
{
    public function viewmanager(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','user/manager');
            return view('admin.user.managerlist');
        } else {
            return redirect('login');
        } 
    }

    public function managerlist(Request $request)
    {
        $parent_id = Session::get('user')['id'];
        $table_data['data'] = array();
        $admin = DB::select('SELECT a.*, b.name as grade
                                         FROM users a
                                         LEFT JOIN grade b ON a.grade_id = b.id
                                        WHERE a.id = '.$parent_id); 
        array_push($table_data['data'], $admin[0]);
        $manager = DB::select('SELECT a.*, b.name as grade
                                         FROM users a
                                         LEFT JOIN grade b ON a.grade_id = b.id
                                        WHERE a. user_role = "manager" AND a.parent_id = '.$parent_id); 

        foreach ($manager as $m) {            
            array_push($table_data['data'], $m);
            $employee = DB::select('SELECT a.*, b.name as grade
                                         FROM users a
                                         LEFT JOIN grade b ON a.grade_id = b.id
                                        WHERE a. user_role = "employee" AND a.parent_id = '.$m->id);      
            if(count($employee)>0){
                foreach ($employee as $e) {
                    $e->department = $m->department;
                    array_push($table_data['data'], $e);
                }
            }   
        }    

      echo json_encode($table_data);   
      
    }
    public function editmanager($id)
    {
        Session::put('nav','user/manager');
        $parent_id = Session::get('user')['id'];
        $grade = DB::select('SELECT *
                                FROM grade
                                WHERE company_id = '.$parent_id);
        $manager = DB::select('SELECT id, department
                             FROM users
                            WHERE user_role = "manager" AND parent_id = '.$parent_id); 
        if($id == 0){
            return view('admin.user.editmanager',compact('grade','manager'));
        } else {
            $user = DB::select('SELECT *
                                FROM users
                                WHERE id ='.$id);
            return view('admin.user.editmanager', compact('user','grade','manager'));
        } 
    }
    public function insert(Request $request)
    {   
        $max_employees = DB::select('SELECT a.allowed_users
                                    FROM membership a
                                LEFT JOIN users b ON a.id = b.membership_id
                                WHERE b.id = '.Session::get('user')['id']);
        $manager = DB::select('SELECT *
                                FROM users
                                WHERE parent_id = '.Session::get('user')['id']);
        $i=0;
        foreach ($manager as $m ) {
            $i++;
            $employee = DB::select('SELECT *
                                FROM users
                                WHERE parent_id = '.$m->id);
            foreach ($employee as $e ) {
                $i++;
            }
        }

        $users = DB::table('users')
            ->select('*')
            ->where('user_name', $request->user_name)
            ->orWhere('email', $request->email)
            ->get();

        $parent_id = Session::get('user')['id'];
        if($request->id==0){
            if($i >= $max_employees[0]->allowed_users)
            return redirect()->back()->with('error_msg', 'Number of Allowed Users are Over!')->withInput();
            if(count($users)>0){
                return redirect()->back()->with('error_msg', 'UserId or E-mail is already exist!')->withInput();
            }
            $user = new Users;
            $user->user_role = $request->user_role;
            $user->user_name = $request->user_name;
            $user->full_name = $request->full_name;
            if($request->password !=''){
                if($request->password == $request->rpassword){
                $user->password = md5($request->password);
                }else{
                return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput(); 
                }
            }else return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput();
            $user->email = $request->email;
            if($user->user_role=='manager'){
                $user->parent_id = $parent_id;
                $user->department = $request->department;
            }else if($user->user_role=='employee'){
                $user->parent_id = $request->department;
            }
            $user->DOJ = $request->DOJ;
            $user->level = $request->level;
            $user->grade_id = $request->grade_id;
            $user->phone_num = $request->phone_num;
            $user->basic_salary = $request->basic_salary;
            $user->password = md5('');
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();
            return redirect()->back()->with('msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            if(count($users)>1 || $id != $users[0]->id){
                return redirect()->back()->with('error_msg', 'UserId or E-mail is already exist!')->withInput();
            }
            $user = Users::find($id);
            $user->user_role = $request->user_role;
            $user->user_name = $request->user_name;
            $user->full_name = $request->full_name;
            if($request->password !=''){
                if($request->password == $request->rpassword){
                $user->password = md5($request->password);
                }else{
                return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput(); 
                }
            }
            if($user->user_role=='manager'){
                $user->parent_id = $parent_id;
                $user->department = $request->department;
            }else if($user->user_role=='employee'){
                $user->parent_id = $request->department;
            }
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

    public function myprofile(Request $request){
        if($this->isLogged($request)){
            Session::put('nav','myprofile');
            $id = Session::get('user')['id'];
            $admin = DB::select('SELECT *
                            FROM users
                            where id = '.$id
                           );
            $grade = DB::select('SELECT *
                                FROM grade');
            return view('admin.myprofile', compact('admin','grade'));
        } else {
            return redirect('login');
        } 
    }

    public function update_myprofile(Request $request)
    {   
            $id = $request->id; 
            $user = Users::find($id);
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->phone_num = $request->phone_num;
            $user->DOJ = $request->DOJ;
            $user->grade_id = $request->grade_id;
            $user->basic_salary = $request->basic_salary;
            if($request->password !=''){
              if($request->password == $request->rpassword){
                $user->password = md5($request->password);
              }else{
                return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput(); 
              }
            }
            
            $user->save();
            $new_user = DB::select('SELECT *
                            FROM users
                            where user_role = "admin" AND user_name = "'.$request->user_name.'"'
                           );

            if(count($new_user)>0){
                $new_user = [
                    "id" =>$new_user[0]->id,
                    "user_name" =>$new_user[0]->user_name,
                    "full_name" =>$new_user[0]->full_name,
                    "email" =>$new_user[0]->email,
                    "role" =>'admin',
                    "phone_num" =>$new_user[0]->phone_num,
                    "password" => $new_user[0]->password,
                    "isLoggedIn" => true                   
                ];
                     
                  Session::put('user',$new_user);

              return redirect()->back()->with('success_msg', 'Update Successfull!')->withInput(); 
            }
       
    }
    public function down_temp($type = ''){
         ini_set('max_execution_time', '0');
        require_once dirname(__FILE__) . '/../../../../excel/PHPExcel.php';
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        $pCol = 0;
        $pRow = 1;

        $field_name = array('User Role(e.g. employee)','Department Name','UserID','FullName','E-mail','DOJ(e.g. 2020-03-02)','Basic Salary', 'password');
        
        for ($pCol = 0; $pCol < count($field_name); $pCol++){
            $sheet->setCellValueByColumnAndRow($pCol, $pRow,$field_name[$pCol]);
        }

        header('Content-Encoding: utf-8');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="template.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        //$objWriter->save('template.xls');
    }

    public function uploadCsvFile(Request $request){

        if ($file = $request->file('excelfile')) {
            $extension = $file->getClientOriginalExtension();

            if($extension==""){
                return json_encode(array('status'=>0, 'msg' => 'Not Only  *.xls file!'));
            }
            $extension = strtolower($extension);
            if($extension != 'xls'){
                return json_encode(array('status'=>0, 'msg' => 'Not Only  *.xls file!'));

            }
            $destinationPath = public_path('uploads'.DIRECTORY_SEPARATOR.'xls'.DIRECTORY_SEPARATOR);
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $filePath = $destinationPath.$safeName;
            $result = $this->importExcelFile($filePath);

            unlink($filePath);
            if(count($result) == 0){
                return json_encode(array('status'=>0, 'msg' => 'Not Found file contents!'));

            }

            $format = $result[1];
            if(count($format)<5){
                return json_encode(array('status'=>0, 'msg' => 'Incorrect file format!'));

            }

            $this->importDatasFromCsv($result);
            return json_encode(array('status'=>1, 'msg' => 'the opration success!'));


        }else{
            json_encode(array('status'=>0, 'msg' => 'Not Found Upload file!'));
        }
        return ;
    }

    public function importDatasFromCsv($rows){
        for($i=2; $i < count($rows)+1; $i++){
            $item = $rows[$i];
            $this->importItemFromCsv($item);
        }
    }

    public function importItemFromCsv($item){
        // var_dump($item[5]);
        // die();
        $user = Users::where('user_name', $item[2])->orWhere('email', $item[4])->first();

        $department = Users::where('department', $item[1])->first();
        
        if(!isset($user->id) && isset($department->id)){
            // $user = new Users;
            $users = new Users;
            $users->parent_id = $department->id;
        }

        $users->user_role = $item[0];
        $users->user_name = $item[2];
        $users->full_name = $item[3];
        $users->email = $item[4];
        $users->DOJ = date_format(date_create($item[5]),"Y-m-d");
        $users->basic_salary = $item[6];
        $users->password = md5($item[7]);
        $users->created_at = date('Y-m-d H:i:s');
        // var_dump($users);
        // die();
        $users->save();
    }

    
}