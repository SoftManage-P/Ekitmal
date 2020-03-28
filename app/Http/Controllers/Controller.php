<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   /**
	 * This function used to check the user is logged in or not
	 */
	protected function isLogged() {
		
		$isLoggedIn = Session::get('user')['isLoggedIn'];
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != true ) 
		{
		
			return false;
		} 
		else 
		{
			return true;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	protected function isSuperAdmin() {

		if (Session::get('user')['role'] == "superadmin") 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	protected function isAdmin() {
		if (Session::get('user')['role'] == "admin") 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}


	/**
	 * This function is used to check the access
	 */
	protected function isManager() {
		if (Session::get('user')['role'] == "manager") 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	protected function isEmployee() {
		if (Session::get('user')['role'] == "employee") 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	protected function get_evalDate(){
		if($this->isAdmin()){
			$company_id = Session::get('user')['id'];
		}
		if($this->isManager()){
			$manager_id =  Session::get('user')['id'];
	        $company = DB::select('SELECT a.parent_id as company_id
	          FROM users a
	          WHERE a.id = '.$manager_id);
	        $company_id = $company[0]->company_id;
		}
		if($this->isEmployee()){
			$employee_id = Session::get('user')['id'];
	        $company = DB::select('SELECT b.parent_id as company_id
	          FROM users a
	          LEFT JOIN users b ON a.parent_id = b.id
	          WHERE a.id = '.$employee_id);
	        $company_id = $company[0]->company_id;
		}
        $year = date('Y');
        $today = date('Y-m-d');
        $schedule = DB::select('SELECT *
                              FROM evaluation_schedule
                              WHERE company_id = '.$company_id.' AND created_at LIKE "'.$year.'%"');
        $eval_date[0]='';
        $eval_date[1] = '';
        if(count($schedule)>0){
          if(strtotime($schedule[0]->mid_year_eval_start) <= strtotime($today) && strtotime($schedule[0]->mid_year_eval_end) >= strtotime($today)){
            $eval_date[0] = 'mid_date';
          }elseif(strtotime($schedule[0]->end_year_eval_start) <= strtotime($today) && strtotime($schedule[0]->end_year_eval_end) >= strtotime($today)){
            $eval_date[0] = 'end_date';
          }else{$eval_date[0] = 'no';}
          if(strtotime($schedule[0]->end_year_eval_start) <= strtotime($today)){
            $eval_date[1] = 'last';
          }else $eval_date[1] = 'mid';
        }
        
        return $eval_date;
    }

    protected function importExcelFile($file){
	    ini_set('max_execution_time', '0');
	    require_once dirname(__FILE__) . '/../../../excel/PHPExcel.php';
	    $objReader = \PHPExcel_IOFactory::createReader('Excel5');
	    $objPHPExcel = $objReader->load($file);
	    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	        foreach ($worksheet->getRowIterator() as $key=>$row) {
	            $cellIterator = $row->getCellIterator();
	            $cellIterator->setIterateOnlyExistingCells( false);
	            foreach ($cellIterator as $cell) {
	                if (!is_null($cell)) {  //如果列不给空就得到它的坐标和计算的值
	                    $rows[$key][]=   $cell->getCalculatedValue();
	                }
	            }
	        }
	    }
	    return $rows;
    }
}
