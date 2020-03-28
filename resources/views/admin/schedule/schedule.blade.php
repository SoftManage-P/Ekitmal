@include('template.header')
@include('template.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-page">
                <!-- Start content -->
   <div class="content">
        <div class="container-fluid" style="padding-top:15px;">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="row" style="padding:25px;margin-bottom:100px;">
                                <h4 class="mt-0 header-title">Evaluation Schedule</h4>
                            </div>
                            

                            <form class="" action="{{url('admin/insert_schedule')}}" autocomplete="on" method="post" role="form">
                                <div class="row">
                                    <input type="hidden" name="id" value="{!! isset($schedule[0])? $schedule[0]->id:'' !!}">
                                    <div class="form-group col-sm-12 row">
                                        <div class="col-sm-1"></div>
                                        <label class="col-sm-2">Mid Year Evaluation</label>
                                        <div class="col-sm-7">
                                            <div class="input-daterange input-group" id="date-range_1">
                                                <input type="text" class="form-control" name="mid_year_eval_start" required value="{!! isset($schedule[0])? $schedule[0]->mid_year_eval_start:date('Y-m-d') !!}" />&nbsp;&nbsp;&nbsp;<span style="padding-top:5px;font-size:16px;">to</span>&nbsp;&nbsp;
                                                <input type="text" class="form-control" name="mid_year_eval_end" required value="{!! isset($schedule[0])? $schedule[0]->mid_year_eval_end:date('Y-m-d') !!}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 row">
                                        <div class="col-sm-1"></div>
                                        <label class="col-sm-2">End Year Evaluation</label>
                                        <div class="col-sm-7">
                                            <div class="input-daterange input-group" id="date-range_2">
                                                <input type="text" class="form-control" name="end_year_eval_start" required value="{!! isset($schedule[0])? $schedule[0]->end_year_eval_start:date('Y-m-d') !!}" />&nbsp;&nbsp;&nbsp;<span style="padding-top:5px;font-size:16px;">to</span>&nbsp;&nbsp;
                                                <input type="text" class="form-control" name="end_year_eval_end" required value="{!! isset($schedule[0])? $schedule[0]->end_year_eval_end:date('Y-m-d') !!}"/>
                                            </div>
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
            </div> <!-- end row -->



        </div> <!-- container-fluid -->

    </div> <!-- content -->

    



<!-- /.content-wrapper -->
@include('template.footer')  


<script type="text/javascript">

    $('#date-range_1').datepicker({
        autoclose: true,
        todayHighlight: true,
        format:'yyyy/mm/dd',
        toggleActive: true
        });
    $('#date-range_2').datepicker({
        autoclose: true,
        todayHighlight: true,
        format:'yyyy/mm/dd',
        toggleActive: true
        });
    
    var s='{{Session::get('success_msg')}}';
      if(s !=''){
        Swal.fire(s);
      }

</script>