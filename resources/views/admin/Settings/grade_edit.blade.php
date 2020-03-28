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
                                <h4 class="mt-0 header-title" style="display:inline-block">Edit Grade</h4>
                                <a href="{{url('admin/manage_grade')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            <div class="row">
                            <div class="col-lg-12 ">
                                <div class="card m-b-20 ">
                                    <div class="card-body">
                                        <form class="" action="{{url('admin/insert_grade')}}" autocomplete="on" method="post" role="form">
                                            <input type="hidden" name="id" value="{!! isset($grade)? $grade[0]->id:0 !!}" />
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Grade Name</label>
                                                        <input type="text" class="form-control col-sm-7" name="name" value="{!! isset($grade) ? $grade[0]->name:'' !!}" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Description</label>
                                                        <input type="text" class="form-control col-sm-7" name="description" value="{!! isset($grade)? $grade[0]->description:'' !!}"/>
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
  var s='{{Session::get('success_msg')}}';
  if(s !=''){
    Swal.fire(s);
  }
  var e='{{Session::get('error_msg')}}';
  if(e !=''){
    Swal.fire(e);
  }
  // $('#sa-basic').on('click', function () {
    $(document).ready(function() {
      
    $('#datepicker-autoclose').datepicker({
      autoclose: true,
      todayHighlight: true,
      format:'yyyy/mm/dd'
        });
    });

</script>