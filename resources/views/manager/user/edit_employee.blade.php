@include('template.header')
@include('template.sidebar')
<style type="text/css">
  .input{
    display:inline-block;
    /*float: left;*/
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-page">
                <!-- Start content -->
   <div class="content">
        <div class="container-fluid" style="padding-top:15px;">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="" style="padding:25px;">
                                <h4 class="mt-0 header-title" style="display:inline-block">Edit Employee</h4>
                                <a href="{{url('manager/employee')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button></a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12 ">
                                <div class="card m-b-20 ">
                                    <div class="card-body">
                                        <form class="" action="{{url('manager/insert_user')}}" autocomplete="on" method="post" role="form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                        <input type="hidden" name="id" value="{!! isset($employee)? $employee[0]->id:''  !!}" />
                                                        <div class="form-group row" >
                                                            <label class="col-sm-4" >User Role</label>
                                                            <input type="text" class="form-control col-sm-7" name="user_role" readonly value="employee" />
                                                        </div>
                                                        <div class="form-group row" >
                                                            <label class="col-sm-4" >UserId</label>
                                                            <input type="text" class="form-control col-sm-7" name="user_name" required placeholder="userId" value="{!! isset($employee) ? $employee[0]->user_name:'' !!}" />
                                                        </div>
                                                        <div class="form-group row" >
                                                            <label class="col-sm-4" >Full Name</label>
                                                            <input type="text" class="form-control col-sm-7" name="full_name" required placeholder="Full Name" value="{!! isset($employee)? $employee[0]->full_name:'' !!}"/>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4" >E-Mail</label>
                                                                <input type="email" class="form-control col-sm-7" required
                                                                        parsley-type="email" name="email" placeholder="Enter a valid e-mail" value="{!! isset($employee)? $employee[0]->email:'' !!}"/>
                                                        </div>
                                                         <div class="form-group row" >
                                                            <label class="col-sm-4 input" >Phone Number</label>
                                                            <input type="number" class="form-control col-sm-7 input" data-parsley-type="number" name="phone_num" required placeholder="Phone Number" value="{!! isset($employee)? $employee[0]->phone_num:'' !!}"/>
                                                        </div>
                                                </div>
                                                <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <label class="control-label col-sm-4">Grade</label>
                                                            <div class="col-sm-7" style="padding:0px">
                                                            <select class="form-control " name="grade_id">
                                                                <option>Select</option>
                                                                <?php foreach ($grade as $val) {?>
                                                                    <option value="<?php echo $val->id?>" {!! isset($employee) && $employee[0]->grade_id == $val->id ? 'selected':'' !!}><?php echo $val->name?></option>
                                                                <?php }?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="control-label col-sm-4"> Date Of Joining</label>
                                                            <div class="col-sm-7" style="padding:0px">
                                                                <div class="input-group " >
                                                                    <input type="text" class="form-control"name="DOJ" placeholder="yyyy/mm/dd"  id="datepicker-autoclose" value="{!! isset($employee)? $employee[0]->DOJ:'' !!}">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="control-label col-sm-4">Level</label>
                                                            <div class="col-sm-7" style="padding:0px">
                                                            <select class="form-control " name="level" readonly>
                                                                <!-- <option>Select</option>
                                                                <option value="company" {!! isset($manager) && $manager[0]->level == 'company' ? 'selected':'' !!}>Company</option> -->
                                                                <option value="individual" >Individual</option>
                                                                <!-- <option value="individual" {!! isset($manager) && $manager[0]->level == 'individual' ? 'selected':'' !!}>Individual</option> -->
                                                                      
                                                            </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" >
                                                            <label class="col-sm-4" >Basic Salary</label>
                                                            <input type="text" class="form-control col-sm-7" name="basic_salary" required placeholder="Basic Salary" value="{!! isset($employee)? $employee[0]->basic_salary:'' !!}"/>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div style="float:right;">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                            
                                        </form>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->

    </div> <!-- content -->

   


<!-- /.content-wrapper -->
@include('template.footer')  
<script>
  var s='{{Session::get('msg')}}';
  if(s !=''){
    Swal.fire(s);
  }
  
  // $('#sa-basic').on('click', function () {
    $(document).ready(function() {
      
    // $(".select2").select2();

    $('#datepicker-autoclose').datepicker({
      autoclose: true,
      todayHighlight: true,
      format:'yyyy/mm/dd'
    });

        
  });

</script>