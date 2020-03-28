<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','dashboard');
            $total_admin=DB::select('SELECT count(id) as admin_num
                                    FROM users
                                    WHERE user_role = "admin"
                ');
            $total_membership=DB::select('SELECT count(id) as membership_num
                                    FROM membership
                ');
            return view('superadmin.dashboard.dashboard',compact('total_admin','total_membership'));
        } else {
            return redirect('login');
        } 
    }

    public function first(Request $request)
    {
    	
      
    }

    
}