<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{	
    
    public function home(Request $request)
    {           
        return view('index');
    }

    public function about_us(Request $request)
    {           
        return view('about-us');
    }

    public function contact(Request $request)
    {           
        return view('contact');
    }

    public function login_page()
    {
        $userRole = DB::select('SELECT *
                                FROM role
                                ORDER BY id');
        return view('auth.login', compact('userRole'));
    }

}