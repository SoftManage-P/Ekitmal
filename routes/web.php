<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middlewareGroups' => 'web'], function () {

////frontend
    Route::get('/', 'HomeController@home');  
    Route::get('/home', 'HomeController@home'); 
    Route::get('/about-us', 'HomeController@about_us');
    Route::get('/contact', 'HomeController@contact');
////login page
    Route::get('login', 'HomeController@login_page');  
    Route::get('logout', 'LoginController@logout');
    Route::post('signin', 'LoginController@signin');
    Route::post('signup', 'LoginController@signup');

////employee
    Route::get('employee/', 'Employee\DashboardController@view_evaluation');
    Route::post('employee/evaluation_list', 'Employee\DashboardController@evaluation_list');
    Route::get('employee/edit_evaluation/{id}', 'Employee\DashboardController@edit_evaluation');
    Route::post('employee/insert_evaluation', 'Employee\DashboardController@insert_evaluation');

////manager
    Route::get('manager/', 'Manager\DashboardController@index');
////manager/user
    Route::get('manager/employee', 'Manager\UserController@view_employee');
    Route::post('manager/employee_list', 'Manager\UserController@employee_list');
    Route::post('manager/insert_user', 'Manager\UserController@insert');
    Route::post('manager/delete_user', 'Manager\UserController@delete');
    Route::get('manager/edit_employee/{id}', 'Manager\UserController@edit_employee');   
//// manager objective
    Route::get('manager/objective', 'Manager\SettingsController@viewObjective');
    Route::post('manager/objectivelist', 'Manager\SettingsController@objectivelist');
    Route::get('manager/editobjective/{id}', 'Manager\SettingsController@editobjective');
    Route::post('manager/insert_objective', 'Manager\SettingsController@insert_objective');
    Route::post('manager/delete_objective', 'Manager\SettingsController@delete_objective');

//// manager kpi
    Route::get('manager/kpi', 'Manager\SettingsController@view_kpi');
    Route::post('manager/kpi_list', 'Manager\SettingsController@kpi_list');
    Route::get('manager/edit_kpi/{id}', 'Manager\SettingsController@edit_kpi');
    Route::post('manager/insert_kpi', 'Manager\SettingsController@insert_kpi'); 
//// manager// assign objective  
    Route::get('manager/assign', 'Manager\PerformanceController@view_assign');
    Route::post('manager/assign_objective', 'Manager\PerformanceController@objective_list');
    Route::get('manager/edit_objective/{id}', 'Manager\PerformanceController@edit_objective');
    Route::post('manager/insert_assign', 'Manager\PerformanceController@insert_assign');
    Route::post('manager/get_employee', 'Manager\PerformanceController@get_employee');
//// manager    // evaluation performance
    Route::get('manager/evaluation', 'Manager\PerformanceController@view_evaluation');
    Route::post('manager/evaluation_list', 'Manager\PerformanceController@evaluation_list');
    Route::get('manager/edit_evaluation/{id}', 'Manager\PerformanceController@edit_evaluation');
    Route::post('manager/insert_evaluation', 'Manager\PerformanceController@insert_evaluation');

//// admin user   // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('admin/', 'Admin\DashboardController@index'); 
    Route::post('admin/get_chart', 'Admin\DashboardController@get_chart'); 

    Route::get('admin/myprofile', 'Admin\UserController@myprofile');
    Route::post('admin/update_myprofile', 'Admin\UserController@update_myprofile');
    Route::get('admin/manager', 'Admin\UserController@viewmanager');
    Route::post('admin/managerlist', 'Admin\UserController@managerlist');
    Route::post('admin/insert_user', 'Admin\UserController@insert');
    Route::post('admin/delete_user', 'Admin\UserController@delete');
    Route::get('admin/editmanager/{id}', 'Admin\UserController@editmanager');
    Route::post('admin/uploadCsvFile', 'Admin\UserController@uploadCsvFile');
    Route::get('admin/down_temp', 'Admin\UserController@down_temp');

//// admin objective
    Route::get('admin/objective', 'Admin\SettingsController@viewObjective');
    Route::post('admin/objectivelist', 'Admin\SettingsController@objectivelist');
    Route::get('admin/editobjective/{id}', 'Admin\SettingsController@editobjective');
    Route::post('admin/insert_objective', 'Admin\SettingsController@insert_objective');
    Route::post('admin/delete_objective', 'Admin\SettingsController@delete_objective');

//// admin kpi
    Route::get('admin/kpi', 'Admin\SettingsController@view_kpi');
    Route::post('admin/kpi_list', 'Admin\SettingsController@kpi_list');
    Route::get('admin/edit_kpi/{id}', 'Admin\SettingsController@edit_kpi');
    Route::post('admin/insert_kpi', 'Admin\SettingsController@insert_kpi');
//// admin rating_mechanism
    Route::get('admin/rating_mechanism', 'Admin\SettingsController@view_rating_mechanism');
    Route::post('admin/insert_mechanism', 'Admin\SettingsController@insert_mechanism');
//// admin force ranking
    Route::get('admin/force_ranking', 'Admin\SettingsController@view_force_ranking');
    Route::post('admin/insert_force_ranking', 'Admin\SettingsController@insert_force_ranking');
    Route::post('admin/insert_force_ranking_allow', 'Admin\SettingsController@insert_force_ranking_allow');
    Route::post('admin/percent_allow', 'Admin\SettingsController@percent_allow');
//// admin manage grade
    Route::get('admin/manage_grade', 'Admin\SettingsController@view_grade');
    Route::post('admin/grade_list', 'Admin\SettingsController@grade_list');
    Route::get('admin/edit_grade/{id}', 'Admin\SettingsController@edit_grade');
    Route::post('admin/insert_grade', 'Admin\SettingsController@insert_grade');
    Route::post('admin/delete_grade', 'Admin\SettingsController@delete_grade');
//// admin bonus review
    Route::get('admin/bonus_review', 'Admin\SettingsController@view_bonus_review');
    Route::post('admin/bonus_list', 'Admin\SettingsController@bonus_list');
    Route::post('admin/get_bonus_row', 'Admin\SettingsController@get_bonus_row');
    Route::post('admin/insert_bonus', 'Admin\SettingsController@insert_bonus');
    Route::post('admin/insert_bonus_review', 'Admin\SettingsController@insert_bonus_review');

//// admin increase review
    Route::get('admin/increase_review', 'Admin\SettingsController@view_increase_review');
//// admin achievements percent 
    Route::get('admin/percent', 'Admin\SettingsController@view_percent');
    Route::post('admin/insert_percent', 'Admin\SettingsController@insert_percent');
//// admin schedule
    Route::get('admin/schedule', 'Admin\ScheduleController@view_schedule');
    Route::post('admin/insert_schedule', 'Admin\ScheduleController@insert_schedule');

/// admin manage cute date
    Route::get('admin/cute_date', 'Admin\SettingsController@view_cute_date');
    Route::post('admin/insert_cutedate', 'Admin\SettingsController@insert_cutedate');  
//// admin performance 
    // assign objective  
    Route::get('admin/assign', 'Admin\PerformanceController@view_assign');
    Route::post('admin/assign_objective', 'Admin\PerformanceController@objective_list');
    Route::get('admin/edit_objective/{id}', 'Admin\PerformanceController@edit_objective');
    Route::post('admin/insert_assign', 'Admin\PerformanceController@insert_assign');
    Route::post('admin/get_employee', 'Admin\PerformanceController@get_employee');
    // evaluation performance
    Route::get('admin/evaluation', 'Admin\PerformanceController@view_evaluation');
    Route::post('admin/evaluation_list', 'Admin\PerformanceController@evaluation_list');
    Route::get('admin/edit_evaluation/{id}', 'Admin\PerformanceController@edit_evaluation');
    Route::post('admin/insert_evaluation', 'Admin\PerformanceController@insert_evaluation');
    Route::post('admin/insert_overall_rating', 'Admin\PerformanceController@insert_overall_rating');
    // report
    Route::get('admin/report', 'Admin\PerformanceController@view_report');
    Route::post('admin/report_kpi_list', 'Admin\PerformanceController@report_kpi_list');
    Route::post('admin/report_bonus_list', 'Admin\PerformanceController@report_bonus_list');
    Route::post('admin/report_performance_list', 'Admin\PerformanceController@report_performance_list');
    Route::get('admin/view_chart', 'Admin\PerformanceController@view_chart');
    Route::post('admin/get_chart_value', 'Admin\PerformanceController@get_chart_value');

    Route::get('admin/exportAll', 'Admin\PerformanceController@exportAll');
    Route::get('admin/exportKPI', 'Admin\PerformanceController@exportKPI');

////superadmin 
    Route::get('superadmin/', 'SuperAdmin\DashboardController@index');  
    Route::get('superadmin/myprofile', 'SuperAdmin\ProfileController@myprofile');
    Route::post('superadmin/update_myprofile', 'SuperAdmin\ProfileController@update_myprofile');
    Route::get('superadmin/profile', 'SuperAdmin\ProfileController@profile');
    Route::post('superadmin/adminlist', 'SuperAdmin\ProfileController@adminlist');
    Route::post('superadmin/insert_user', 'SuperAdmin\ProfileController@insert');
    Route::post('superadmin/delete_user', 'SuperAdmin\ProfileController@delete');
    Route::get('superadmin/editadmin/{id}', 'SuperAdmin\ProfileController@editadmin');

    Route::get('superadmin/membership', 'SuperAdmin\MembershipController@membership');
    Route::post('superadmin/membershiplist', 'SuperAdmin\MembershipController@membershiplist');
    Route::get('superadmin/editmembership/{id}', 'SuperAdmin\MembershipController@editmembership');
    Route::post('superadmin/delete_membership', 'SuperAdmin\MembershipController@delete');
    Route::post('superadmin/insert_membership', 'SuperAdmin\MembershipController@insert');
});


