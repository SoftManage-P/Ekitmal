<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Users;
class LoginController extends Controller
{

    public function index(){
    	
    }
    public function signin(Request $request) { 

        $user_name = $request->user_name;
        $user_role = $request->user_role;
        $password = md5($request->password);

        if($user_role == 'admin'){
            $user = DB::select('SELECT a.*,b.unite, b.expires,a.created_at as start_date
                            FROM users a
                            LEFT JOIN membership b ON a.membership_id = b.id
                            where a.user_role = "'.$user_role.'" AND a.user_name = "'.$user_name.'"'
                           );
        }else{
            $user = DB::select('SELECT *
                            FROM users
                            where user_role = "'.$user_role.'" AND user_name = "'.$user_name.'"'
                           );
        }
       
        if(count($user)>0){
            if($user_role == 'admin'){
                $today = strtotime(date('Y-m-d'));
                $start_date = strtotime($user[0]->start_date);
                if($user[0]->unite=='years'){
                    $expired_date = strtotime("+".$user[0]->expires." years",$start_date);
                }elseif ($user[0]->unite=='months') {
                    $expired_date = strtotime("+".$user[0]->expires." months",$start_date);
                }elseif($user[0]->unite=='days'){
                    $expired_date = strtotime("+".$user[0]->expires." days",$start_date);
                
                }
                
                if($today > $expired_date) {
                    return redirect()->back()->with('msg', 'Date expired!')->withInput();
                }              
            }
            
            if($user[0]->password == $password){
                $user = [
                    "id" =>$user[0]->id,
                    "user_name" =>$user_name,
                    "full_name" =>$user[0]->full_name,
                    "email" =>$user[0]->email,
                    "role" =>$user_role,
                    "phone_num" =>$user[0]->phone_num,
                    "password" => $password,
                    "isLoggedIn" => true                   
                ];
                     
                Session::put('user',$user);
                
                // if($request->session()->get('user')['role'] == "Super Admin"){
                //     return redirect('superadmin'); 
                // }
                if($this->isSuperAdmin($request)){
                    return redirect('superadmin'); 
                }
                if($this->isAdmin($request)){
                    return redirect('admin'); 
                }
                if($this->isManager($request)){
                    return redirect('manager'); 
                }
                if($this->isEmployee($request)){
                    return redirect('employee'); 
                }

            } else {
                return redirect()->back()->with('msg', 'Invalid password!')->withInput();
            }

        }else {
            return redirect()->back()->with('msg', 'Invalid user!')->withInput();
        }
    }

    public function signup(Request $request) { 

        $this->validate($request, [
            'username' => 'required',
            'fullname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'rpassword' => 'required|same:password'
        ]);
        $default_membership = DB::select('SELECT id
                            FROM membership
                            WHERE is_default = 1');
        if(count($default_membership)<0){
                    return redirect()->back()->with('error_msg', 'Defalt Membership Doesn\'t exist!')->withInput(); 
                }
        $users = DB::table('users')
            ->select('*')
            ->where('user_name', $request->username)
            ->orWhere('email', $request->email)
            ->get();

        if(count($users)>0){
            return redirect()->back()->with('signup_msg', 'UserId or E-mail is already exist!')->withInput();
        }else{
            $users = new Users;
            $users->user_name = $request->username;
            $users->full_name = $request->fullname;
            $users->email = $request->email;
            $users->password = md5($request->password);
            $users->user_role = 'admin';
            $users->membership_id = $default_membership[0]->id;
            $users->created_at = date('Y-m-d H:i:s');
            $users->save();

            $user_id = $users->id;
            MailController::send_email_newClient($user_id, $request->password);

            return redirect('login')->with('signup_success_msg', 'SinUp Successfull!')->withInput();
        }
       

    }

    public function logout(Request $request) { 
        Session::forget('user');
         return redirect('login'); 
    }


}
