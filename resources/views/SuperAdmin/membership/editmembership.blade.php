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
                                <h4 class="mt-0 header-title" style="display:inline-block">{!! isset($membership)? 'Edit MemberShip':'New MemberShip'  !!}</h4>
                                <a href="{{url('superadmin/membership')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right; font-size:15px;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <form class="" action="{{url('superadmin/insert_membership')}}" autocomplete="on" method="post" role="form">
                                            <input type="hidden" name="id" value="{!! isset($membership)? $membership[0]->id:''  !!}" />
                                                <div class="form-group row"  >
                                                    <label class="col-lg-3 input" >MemberShip Name</label>
                                                    <input type="text" class="form-control col-lg-8 input" name="name" required  value="{!! isset($membership) ? $membership[0]->name:'' !!}" />
                                                </div>
                                                <div class="form-group row" >
                                                    <label class="col-lg-3 input" >Description</label>
                                                    <input type="text" class="form-control col-lg-8 input" name="description" required  value="{!! isset($membership)? $membership[0]->description:'' !!}"/>
                                                </div>
                                                <div class="form-group row" >
                                                    <label class="col-lg-3 input" >Expires</label>
                                                    <input type="text" class="form-control col-lg-6 input" name="expires" required  value="{!! isset($membership)? $membership[0]->expires:'' !!}"/>
                                                    <select class="form-control col-lg-2" name="unite">
                                                        <option value="years" {!! isset($membership) && $membership[0]->unite == 'years' ? 'selected':'' !!}>Years</option>
                                                        <option value="months" {!! isset($membership) && $membership[0]->unite == 'months' ? 'selected':'' !!}>Months</option>
                                                        <option value="days" {!! isset($membership) && $membership[0]->unite == 'days' ? 'selected':'' !!}>Days</option>
                                                    </select>
                                                </div>
                                                <div class="form-group row" >
                                                    <label class="col-lg-3 input" >Number of Allowed Users</label>
                                                    <input type="number" class="form-control col-lg-8 input" name="allowed_users" required  value="{!! isset($membership)? $membership[0]->allowed_users:'' !!}"/>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 input" >Default MemberShip</label>
                                                <input type="checkbox" id="switch3" switch="bool" name="check" {!! isset($membership) && $membership[0]->is_default=='1'? 'checked':'' !!}/>
                                                    <label style="margin-top:10px" for="switch3" data-on-label="Yes"
                                                            data-off-label="No"></label>
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