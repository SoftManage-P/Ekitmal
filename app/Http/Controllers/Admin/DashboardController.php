<?php

namespace App\Http\Controllers\Admin;
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
            $manager=DB::select('SELECT id
                                        FROM users
                                        WHERE parent_id = '.Session::get('user')['id']
                                        );
            $count = 0;
            foreach ($manager as $m) {
                $count++;
                $employee = DB::select('SELECT count(id) as user_num
                                        FROM users
                                        WHERE parent_id = '.$m->id
                                        );
                $count = $count+$employee[0]->user_num;
            }
            $total_user = $count;

            $total_objective=DB::select('SELECT count(id) as objective_num
                                        FROM objective
                                        WHERE company_id = '.Session::get('user')['id'].' AND created_at LIKE "'.date('Y').'%"');
            return view('admin.dashboard.dashboard',compact('total_user','total_objective'));
        } else {
            return redirect('login');
        } 
    }

    public function get_chart(Request $request){
        $year =date("Y");
        ////get_evalDate
        $eval_date = $this->get_evalDate();
        //// end
        $company_id = $request->session()->get('user')['id'];
        $main = DB::select('SELECT * 
                           FROM objective
                          WHERE company_id = '.$company_id.' AND is_sub = 0'); 
        $objective = array();
        foreach ($main as $key => $value) {        
          // $value->sub_name='';
          array_push($objective, $value);

          $sub = DB::select('SELECT a.name , a.is_sub, a.type, a.created_at, a.id
                                FROM objective a
                           LEFT JOIN objective b ON a.parent_id = b.id
                               WHERE a.company_id = '.$company_id.' AND a.is_sub = "1" AND a.parent_id = '.$value->id);
          foreach ($sub as $key1 => $value1) {
             array_push($objective, $value1);
          } 
        }

        $performance=array();
        $i=0;
        foreach ($objective as $key2 => $value2) {  
        $kpi=DB::select('SELECT *
                         FROM kpi
                        WHERE objective_id = '.$value2->id.' AND completion_date LIKE "'.$year.'%"');
        if($eval_date[1]='mid'){
            $kpi[0]->status = $kpi[0]->status_1;
            $kpi[0]->achived = $kpi[0]->actual_achived_1;
        }
        else{
            $kpi[0]->status = $kpi[0]->status_2;
            $kpi[0]->achived = $kpi[0]->actual_achived_2;
        } 
            
        if(count($kpi)>0 && $kpi[0]->status == 2){
            $objective[$key2]->overall_rating = $kpi[0]->overall_rating;
            $objective[$key2]->target_value = 100;
            $objective[$key2]->achived =round($kpi[0]->achived/$kpi[0]->target*100,2);
            $performance[$i]=$objective[$key2];
            $i++;
            $performance[$i-1]->no = $i;
        }else {
          continue;
        }
        }
        $result['overall_rating'] = array();
        for ($i=1; $i < 6 ; $i++) { 
            $rating_count[$i] = 0;
           foreach ($performance as $p) {
               if($i == $p->overall_rating)
               $rating_count[$i]++;
           }
           array_push($result['overall_rating'], $rating_count[$i]);
        }

        $result['name'] = array();
        $result['achived'] = array();
        $result['target'] = array();
        foreach ($performance as $key3 => $value3) {
        array_push($result['name'], $value3->name);
        array_push($result['achived'], $value3->achived);
        array_push($result['target'], $value3->target_value);

        }
        echo json_encode($result);   
    }
    
}