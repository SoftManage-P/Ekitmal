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
                                <h4 class="mt-0 header-title" style="display:inline-block">{!! isset($admin)? 'Edit Admin':'New Admin'  !!}</h4>
                                <a href="{{url('superadmin/profile')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <form class="" action="{{url('superadmin/insert_user')}}" autocomplete="on" method="post" role="form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="hidden" name="id" value="{!! isset($admin)? $admin[0]->id:''  !!}" />
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >User Role</label>
                                                        <input type="text" class="form-control col-sm-7 input" name="user_role" readonly value="admin" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >UserId</label>
                                                        <input type="text" class="form-control col-sm-7 input" name="user_name" required placeholder="userId" value="{!! isset($admin) ? $admin[0]->user_name:old('user_name') !!}" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Full Name</label>
                                                        <input type="text" class="form-control col-sm-7 input" name="full_name" required placeholder="Full Name" value="{!! isset($admin)? $admin[0]->full_name:old('full_name') !!}"/>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Password</label>
                                                        <input type="password" class="form-control col-sm-7" id="pass2" data-parsley-minlength="6" name="password" placeholder="password" value="" />
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 input" >E-Mail</label>
                                                        <input type="email" class="form-control col-sm-7 input" required
                                                               parsley-type="email" name="email" placeholder="Enter a valid e-mail" value="{!! isset($admin)? $admin[0]->email:old('email') !!}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 input" >Active</label>
                                                    <input type="checkbox" id="switch3" switch="bool" name="check" {!! isset($admin) && $admin[0]->active=='1'? 'checked':'' !!}/>
                                                        <label style="margin-top:10px" for="switch3" data-on-label="Yes"
                                                                data-off-label="No"></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Company Name</label>
                                                        <input type="text" class="form-control col-sm-7 input" name="company_name" required placeholder="Company Name" value="{!! isset($admin)? $admin[0]->company_name:old('company_name') !!}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Membership</label>
                                                        <div class="col-sm-7 input" style="padding:0px">
                                                        <select class="form-control " name="membership_id">
                                                            <?php foreach ($membership as $val) {
                                                                  ?>
                                                                  <option value="<?php echo $val->id?>" {!! isset($admin) && $admin[0]->membership_id == $val->id ? 'selected':'' !!}><?php echo $val->name?></option>
                                                                  <?php
                                                              }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Level</label>
                                                        <input type="text" class="form-control col-sm-7 input" name="level" readonly value="company" />
                                                    </div>
                                                    
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Confirm Password</label>
                                                        <input type="password" class="form-control col-sm-7" data-parsley-equalto="#pass2" data-parsley-minlength="6" name="rpassword" placeholder="confirm password" value="" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Phone Number</label>
                                                        <input type="number" class="form-control col-sm-7 input" data-parsley-type="number" name="phone_num" required placeholder="Phone Number" value="{!! isset($admin)? $admin[0]->phone_num:old('phone_num') !!}"/>
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
  
  // $('#sa-basic').on('click', function () {
    $(document).ready(function() {
      
    $(".select2").select2();

    $('#datepicker-autoclose').datepicker({
      autoclose: true,
      todayHighlight: true,
      format:'yyyy/mm/dd'
    });

        
  });

</script>