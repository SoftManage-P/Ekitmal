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
                                <h4 class="mt-0 header-title" style="display:inline-block">Edit Evaluation</h4>
                                <a href="{{url('employee')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12 ">
                                <div class="card m-b-20 ">
                                    <div class="card-body">
                                        <form class="" action="{{url('employee/insert_evaluation')}}" autocomplete="on" method="post" role="form">
                                            <input type="hidden" name="objective_id" value="{!! isset($objective)? $objective[0]->id:'0'  !!}" />
                                            <input type="hidden" name="id" value="{!! isset($kpi)? $kpi[0]->id:'0'  !!}" />
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Objective Type</label>
                                                        <input type="text" class="form-control col-sm-7" disabled value="{!! isset($objective) ? $objective[0]->type:'' !!}" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Main Objective</label>
                                                        <input type="text" class="form-control col-sm-7" disabled value="{!! isset($objective) ? $objective[0]->main_name:'' !!}" />
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4" >Sub Objective</label>
                                                        <input type="text" class="form-control col-sm-7" disabled value="{!! isset($objective)? $objective[0]->sub_name:'' !!}"/>
                                                    </div>
                                                     <div class="form-group row">
                                                        <label class="col-sm-4" >Target Discription</label>
                                                        <div class="col-sm-8 " style="padding-left:0px;padding-right:40px;">
                                                            <textarea name="descript_target" disabled class="form-control form-control-lg"  rows="5" >{!! isset($kpi)? $kpi[0]->descript_target:'' !!}</textarea>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4">Target type</label>
                                                        <div class="col-sm-7" style="padding:0px;">
                                                        <select class="form-control " name="target_type" disabled>
                                                            <option value="num" {!! isset($kpi) && $kpi[0]->target_type == 'num' ? 'selected':'' !!}>Number</option>
                                                            <option value="percent" {!! isset($kpi) && $kpi[0]->target_type == 'percent' ? 'selected':'' !!}>Percent</option>
                                                            <option value="both" {!! isset($kpi) && $kpi[0]->target_type == 'both' ? 'selected':'' !!}>Both</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4"> Date to Completion</label>
                                                        <div class="col-sm-7" style="padding:0px;">
                                                            <div class="input-group"  >
                                                                <input type="text" class="form-control"name="completion_date" placeholder="yyyy/mm/dd"  id="datepicker-autoclose" value="{!! isset($kpi)? $kpi[0]->completion_date:'' !!}" disabled>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Weight</label>
                                                        <input type="text" class="form-control col-sm-7" name="weights" value="{!! isset($kpi)? $kpi[0]->weights:'' !!}"disabled/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Target</label>
                                                        <input type="text" class="form-control col-sm-7" name="target" value="{!! isset($kpi)? $kpi[0]->target:'' !!}"disabled/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Actual Achived</label>
                                                        <input type="text" class="form-control col-sm-7" name="actual_achived" value="{!! isset($kpi)? $kpi[0]->actual_achived:'' !!}"/>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            
                                            <br>
                                            <div class="form-group mb-0">
                                                <div style="float:right;">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Save & Update
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