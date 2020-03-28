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
                                        <form class="" action="{{url('superadmin/update_myprofile')}}" autocomplete="on" method="post" role="form">
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
                                                    
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Phone Number</label>
                                                        <input type="number" class="form-control col-sm-7 input" data-parsley-type="number" name="phone_num" required placeholder="Phone Number" value="{{Session::get('user')['phone_num']}}"/>
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
                                                    <a href="{{url('superadmin')}}"><button type="button" class="btn btn-secondary waves-effect">
                                                        Cancel
                                                    </button></a>
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
      
  });

</script>