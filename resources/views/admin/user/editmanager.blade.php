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
                                <h4 class="mt-0 header-title" style="display:inline-block">Edit Manager</h4>
                                <a href="{{url('admin/manager')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12 ">
                                <div class="card m-b-20 ">
                                    <div class="card-body">
                                        <form class="" action="{{url('admin/insert_user')}}" autocomplete="on" method="post" role="form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="hidden" name="id" value="{!! isset($user)? $user[0]->id:''  !!}" />
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >User Role</label>
                                                        <div class="col-sm-7" style="padding:0px">
                                                        <select class="form-control " name="user_role" id="user_role">
                                                            <option value="admin" {!! isset($user) && $user[0]->user_role == 'admin' ? 'selected':'' !!}>Admin</option>
                                                            <option value="manager" {!! isset($user) && $user[0]->user_role == 'manager' ? 'selected':'' !!}>Manager</option>
                                                            <option value="employee" {!! isset($user) && $user[0]->user_role == 'employee' ? 'selected':'' !!}>Employee</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >UserId</label>
                                                        <input type="text" class="form-control col-sm-7" name="user_name" required placeholder="userId" value="{!! isset($user) ? $user[0]->user_name:old('user_name') !!}" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Full Name</label>
                                                        <input type="text" class="form-control col-sm-7" name="full_name" required placeholder="Full Name" value="{!! isset($user)? $user[0]->full_name:old('full_name') !!}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4" >E-Mail</label>
                                                            <input type="email" class="form-control col-sm-7" required
                                                                    parsley-type="email" name="email" placeholder="Enter a valid e-mail" value="{!! isset($user)? $user[0]->email:old('email') !!}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Grade</label>
                                                        <div class="col-sm-7" style="padding:0px">
                                                        <select class="form-control " name="grade_id">
                                                            <option>Select</option>
                                                            <?php foreach ($grade as $val) {?>
                                                                <option value="<?php echo $val->id?>" {!! isset($user) && $user[0]->grade_id == $val->id ? 'selected':'' !!}><?php echo $val->name?></option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Password</label>
                                                        <input type="password" class="form-control col-sm-7" id="pass2" data-parsley-minlength="6" name="password" placeholder="password" value="" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4" >Department</label>
                                                        <div class="col-sm-7" style="padding:0px"  id="department">
                                                            <input type="text" class="form-control" name="department" required placeholder="Department Name" value="{!! isset($user)? $user[0]->department:'' !!}"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4"> Date Of Joining</label>
                                                        <div class="col-sm-7" style="padding:0px">
                                                            <div class="input-group " >
                                                                <input type="text" class="form-control"name="DOJ" placeholder="yyyy/mm/dd"  id="datepicker-autoclose" value="{!! isset($user)? $user[0]->DOJ:old('DOJ') !!}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Level</label>
                                                        <input type="text" class="form-control col-sm-7" name="level" id="level" readonly value="department" />
                                                    </div>
                                                    
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Basic Salary</label>
                                                        <input type="text" class="form-control col-sm-7" name="basic_salary" required placeholder="Basic Salary" value="{!! isset($user)? $user[0]->basic_salary:old('basic_salary') !!}"/>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Phone Number</label>
                                                        <input type="number" class="form-control col-sm-7 input" data-parsley-type="number" name="phone_num" required placeholder="Phone Number" value="{!! isset($user)? $user[0]->phone_num:old('phone_num') !!}"/>
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
  var e='{{Session::get('error_msg')}}';
  if(e !=''){
    Swal.fire(e);
  }
  
$(document).ready(function() {
    var user_role = $('#user_role').val();
    reset_departmetn(user_role);

    $('#datepicker-autoclose').datepicker({
      autoclose: true,
      todayHighlight: true,
      format:'yyyy/mm/dd'
    });

        
});

    function  reset_departmetn(user_role){
        $('#department').empty();
        if(user_role == 'manager'){
            $('#department').append('<input type="text" class="form-control" name="department" required placeholder="Department Name" value="{!! isset($user)? $user[0]->department:'' !!}"/>');
            $('#level').val('department');
        }else if(user_role == 'employee'){
            $('#department').append('<select class="form-control " name="department">'+
                '<option>Select</option>'+
                '<?php foreach ($manager as $val) {?>'+
                '    <option value="<?php echo $val->id?>" {!! isset($user) && $user[0]->parent_id == $val->id ? 'selected':'' !!}><?php echo $val->department?></option>'+
                '<?php }?>'+
            '</select>');
            $('#level').val('individual');
        }
    } 

$('#user_role').on('change',function(){
    var user_role = $('#user_role').val();
    reset_departmetn(user_role);
})

</script>