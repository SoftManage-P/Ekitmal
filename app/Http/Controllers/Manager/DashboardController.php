<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $manager_id = $request->session()->get('user')['id'];

       if($this->isLogged($request)){
            Session::put('nav') =='manager/dashboard';
            $total_employee=DB::select('SELECT count(id) as user_num
                                    FROM users
                                    WHERE user_role = "employee" AND parent_id = '.$manager_id
                );
            $total_objective=DB::select('SELECT count(id) as objective_num
                                    FROM objective
                                    WHERE manager_id = '.$manager_id.' AND created_at = '.date('Y'));
            return view('manager.dashboard.dashboard', compact('total_employee', 'total_objective'));
        } else {
            return redirect('login');
        } 
    }

    public function first(Request $request)
    {
    	
      
    }

    
}