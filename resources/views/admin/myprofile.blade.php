@include('template.header')
@include('template.sidebar')
<style type="text/css">
  .input{
    display:inline-block;
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
                                <h4 class="mt-0 header-title" style="display:inline-block">My Profile</h4>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <form class="" action="{{url('admin/update_myprofile')}}" autocomplete="on" method="post" role="form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="hidden" name="id" value="{{Session::get('user')['id']}}" />
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Full Name</label>
                                                        <input type="text" class="form-control col-sm-7" readonly value="{{Session::get('user')['full_name']}}" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >UserId</label>
                                                        <input type="text" class="form-control col-sm-7" name="user_name" required placeholder="userId" value="{{Session::get('user')['user_name']}}" />
                                                    </div>
                                                   
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 " >E-Mail</label>
                                                            <input type="email" class="form-control col-sm-7" required 
                                                                    parsley-type="email" name="email" placeholder="Enter a valid e-mail" value="{{Session::get('user')['email']}}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Grade</label>
                                                        <div class="col-sm-7" style="padding:0px">
                                                        <select class="form-control " name="grade_id">
                                                            <option>Select</option>
                                                            <?php foreach ($grade as $val) {?>
                                                                <option value="<?php echo $val->id?>" {!! isset($admin) && $admin[0]->grade_id == $val->id ? 'selected':'' !!}><?php echo $val->name?></option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Phone Number</label>
                                                        <input type="number" class="form-control col-sm-7 input" data-parsley-type="number" name="phone_num" required placeholder="Phone Number" value="{{Session::get('user')['phone_num']}}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4"> Date Of Joining</label>
                                                        <div class="col-sm-7 input" style="padding:0px">
                                                            <div class="input-group ">
                                                                <input type="text" class="form-control"name="DOJ" placeholder="yyyy/mm/dd"  id="datepicker-autoclose" value="{!! isset($admin)? $admin[0]->DOJ:date('Y-m-d') !!}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Basic Salary</label>
                                                        <input type="text" class="form-control col-sm-7 input" name="basic_salary" required placeholder="Basic Salary" value="{!! isset($admin)? $admin[0]->basic_salary:old('basic_salary') !!}"/>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Password</label>
                                                        <input type="password" class="form-control col-sm-7" id="pass2" data-parsley-minlength="6" name="password" placeholder="password" value="" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Confirm Password</label>
                                                        <input type="password" class="form-control col-sm-7" data-parsley-equalto="#pass2" data-parsley-minlength="6" name="rpassword" placeholder="confirm password" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div style="float:right;">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Save
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect">
                                                        Cancel
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
  var s='{{Session::get('success_msg')}}';
  if(s !=''){
    Swal.fire(s);
  }
  var e='{{Session::get('error_msg')}}';
  if(e !=''){
    Swal.fire(e);
  }
  
    $(document).ready(function() {
        $('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true,
        format:'yyyy/mm/dd'
        });
  });

</script>