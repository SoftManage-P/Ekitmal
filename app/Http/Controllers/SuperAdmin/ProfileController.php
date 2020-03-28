<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use App\Users;
use stdClass;
class ProfileController extends Controller
{
    public function profile(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','profile');
            return view('superadmin.user.adminlist');
        } else {
            return redirect('login');
        } 
    }

    public function adminlist(Request $request)
    {
        $table_data['data'] = DB::select('SELECT a.*, b.name as membership, c.name as grade
                                         FROM users a
                                   LEFT JOIN membership b ON a.membership_id = b.id
                                   LEFT JOIN grade c ON a.grade_id = c.id
                                        WHERE a.user_role = "admin"');  
        foreach ($table_data['data'] as $key => $value) {            
                     
            $table_data['data'][$key] = $value;               
            
        }    

        foreach ($table_data['data'] as $key => $value) {            

          $table_data['data'][$key]->no = $key+1;               
          
        }
      echo json_encode($table_data);   
      
    }
    public function editadmin($id)
    {
        Session::put('nav','profile');
        $membership = DB::select('SELECT *
                                FROM membership'
                                );
        
        if($id == 0){
            return view('superadmin.user.editadmin', compact('membership'));
        } else {
            $admin = DB::select('SELECT *
                                FROM users
                                WHERE id ='.$id);

            return view('superadmin.user.editadmin', compact('admin','membership'));
        } 
    }
    public function insert(Request $request)
    {   

        $users = DB::table('users')
            ->select('*')
            ->where('user_name', $request->user_name)
            ->orWhere('email', $request->email)
            ->get();


        if($request->id==0){
            if(count($users)>0){
                return redirect()->back()->with('error_msg', 'UserId or E-mail is already exist!')->withInput();
            }
            $user = new Users;
            $user->user_role = $request->user_role;
            $user->user_name = $request->user_name;
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->company_name = $request->company_name;
            $user->membership_id = $request->membership_id;
            // $user->DOJ = $request->DOJ;
            $user->level = $request->level;
            // $user->grade_id = $request->grade_id;
            // $user->basic_salary = $request->basic_salary;
            $user->phone_num = $request->phone_num;
            if($request->password !=''){
                if($request->password == $request->rpassword){
                $user->password = md5($request->password);
                }else{
                return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput(); 
                }
            }else return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput();
            $user->created_at = date('Y-m-d H:i:s');
            if($request->check=='on'){
              $user->active = 1;
            }else{
              $user->active = 0;
            }
            
            
            $user->save();

            $user_id = $user->id;

            MailController::send_email_newClient($user_id, $request->password);

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
            $user->company_name = $request->company_name;
            $user->membership_id = $request->membership_id;
            $user->email = $request->email;
            // $user->DOJ = $request->DOJ;
            $user->level = $request->level;
            // $user->grade_id = $request->grade_id;
            // $user->basic_salary = $request->basic_salary;
            $user->phone_num = $request->phone_num;
            if($request->password !=''){
                if($request->password == $request->rpassword){
                $user->password = md5($request->password);
                }else{
                return redirect()->back()->with('error_msg', 'Please Recheck Your Password!')->withInput(); 
                }
            }
            $user->created_at = date('Y-m-d H:i:s');
            if($request->check=='on'){
              $user->active = 1;
            }else{
              $user->active = 0;
            }
            
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
            return view('superadmin.myprofile');
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
                            where user_role = "superadmin" AND user_name = "'.$request->user_name.'"'
                           );

            if(count($new_user)>0){
                $new_user = [
                    "id" =>$new_user[0]->id,
                    "user_name" =>$new_user[0]->user_name,
                    "full_name" =>$new_user[0]->full_name,
                    "email" =>$new_user[0]->email,
                    "phone_num" =>$new_user[0]->phone_num,
                    "role" =>'superadmin',
                    "password" => $new_user[0]->password,
                    "isLoggedIn" => true                   
                ];
                     
                  Session::put('user',$new_user);

              return redirect()->back()->with('success_msg', 'Update Successfull!')->withInput(); 
            }
       
    }
}