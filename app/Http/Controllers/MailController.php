<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use Mail;

class MailController extends Controller
{
    //
    public static function send_email_newClient($user_id, $password) {
        $user = DB::select('SELECT email, full_name, user_name FROM users WHERE id = '.$user_id);
        if(count($user) < 1)
            return;
        $user_email = $user[0]->email;
        $user_name = $user[0]->full_name;
        $data = array('name'=>$user_name, 'user_name'=>$user[0]->user_name, 'password'=>$password);

        Mail::send('mail', $data, function($message) use ($user_email, $user_name) {
            $message->to($user_email, $user_name)->subject
            ('Notification Account Creation ');
            $message->from('pms@sps-hris.com','Ektimal');
        });
//        echo "Basic Email Sent. Check your inbox.";
    }

    public static function send_email_assignedUser($objective_id) {

        $objective = DB::select('SELECT company_id, manager_id, employee_id, name FROM objective
                                WHERE id = ' . $objective_id);

        if(count($objective) < 1)
            return;

        $objective_name = $objective[0]->name;
        $company_id = $objective[0]->company_id;
        $manager_id = $objective[0]->manager_id;
        $employee_id = $objective[0]->employee_id;

        $kpi = DB::select('SELECT completion_date, weights FROM kpi WHERE objective_id = ' . $objective_id);

        if(count($kpi) < 1)
            return;

        $completion_date = $kpi[0]->completion_date;
        $weights = $kpi[0]->weights;

        $query = 'SELECT email, full_name FROM users WHERE id = ';

        if($employee_id != 0)
            $query .= $employee_id;
        else if($manager_id != 0)
            $query .= $manager_id;
        else if($company_id != 0)
            $query .= $company_id;

        $user = DB::select($query);
        if(count($user) < 1)
            return;

        $user_email = $user[0]->email;
        $user_name = $user[0]->full_name;

//        $body = '<h2>Objective ' . $objective_name. ' has been assigned to you with weights of ' . $weights.'.</h2>
//                <br>You are required to achieve the target before ' . $completion_date;

        $data = array('name'=>$user_name, 'objective_name' => $objective_name, 'weights' => $weights, 'completion_date' => $completion_date);

        Mail::send('mail_assign', $data, function($message) use ($user_email, $user_name) {
            $message->to($user_email, $user_name)->subject
            ('Objective Assigned');
            $message->from('pms@sps-hris.com','Ektimal');
        });
//        echo "Basic Email Sent. Check your inbox.";
    }
}
