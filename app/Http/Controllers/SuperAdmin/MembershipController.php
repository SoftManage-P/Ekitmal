<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Membership;
use stdClass;
class MembershipController extends Controller
{
    public function membership(Request $request)
    {
       if($this->isLogged($request)){
            Session::put('nav','membership');
            return view('superadmin.membership.membership');
        } else {
            return redirect('login');
        } 
    }

    public function membershiplist(Request $request)
    {
        $table_data['data'] = DB::select('SELECT *
                                         FROM membership
                                        ');  
        foreach ($table_data['data'] as $key => $value) {            
                     
            $table_data['data'][$key] = $value;               
            
        }    

        foreach ($table_data['data'] as $key => $value) {            

          $table_data['data'][$key]->no = $key+1;               
          
        }
      echo json_encode($table_data);   
      
    }
    public function editmembership($id)
    {
      Session::put('nav','membership');
      
      
       if($id == 0){
            return view('superadmin.membership.editmembership');
        } else {
            $membership = DB::select('SELECT *
                                FROM membership
                                WHERE id ='.$id);

            return view('superadmin.membership.editmembership', compact('membership'));
        } 
    }
    public function insert(Request $request)
    {   
        $default = DB::select('SELECT id
                            FROM membership
                            WHERE is_default = 1');
        if($request->id==0){
            $data = new Membership;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->expires = $request->expires;
            $data->unite = $request->unite;
            $data->allowed_users = $request->allowed_users;
            $data->created_at = date('Y-m-d H:i:s');
            if($request->check=='on'){
                if(count($default)>0){
                    return redirect()->back()->with('error_msg', 'Defalt Membership already exist!')->withInput(); 
                }else{
                    $data->is_default = 1;
                }
            }else{
                    $data->is_default = 0;

            }
            $data->save();
            return redirect()->back()->with('msg', 'Insert Successfull!')->withInput(); 
        }else{
            $id = $request->id; 
            $data = Membership::find($id);
            $data->name = $request->name;
            $data->description = $request->description;
            $data->expires = $request->expires;
            $data->unite = $request->unite;
            $data->allowed_users = $request->allowed_users;
            $data->created_at = date('Y-m-d H:i:s');
            if($request->check=='on'){
                if(count($default)>0 && $default[0]->id != $id){
                    return redirect()->back()->with('error_msg', 'Defalt Membership already exist!')->withInput(); 
                }else{
                    $data->is_default = 1;
                }
            }else{
                    $data->is_default = 0;
            }
            $data->save();
            return redirect()->back()->with('msg', 'Update Success!')->withInput(); 
        }
       
    }
    public function delete(Request $request){
      $id = $request->id;
      $data = Membership::find($id);
      $data->delete();    
      $res = [
              "success" => true,                    
          ]; 
      echo json_encode($res); 
    }

    
}