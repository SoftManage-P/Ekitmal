@include('template.header')
@include('template.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-page">

  <div class="content">
        <div class="container-fluid" style="padding-top:15px;">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="row" style="padding:30px;margin-bottom:120px;">
                                <h4 class="mt-1 header-title">Manage Cute date</h4>
                            </div>
                            

                            <form class="" action="{{url('admin/insert_cutedate')}}" autocomplete="on" method="post" role="form">
                            <div class="row">
                                
                                <input type="hidden" name="id" value="{!! isset($cutedate[0])? $cutedate[0]->id:'' !!}">
                                <div class="col-sm-3"></div>
                                <label class="col-sm-1">Cute Date</label>
                                <div class="col-sm-3">
                                    <div class="input-daterange input-group" id="date-range_1">
                                        <input type="text" class="form-control" name="cute_date" required value="{!! isset($cutedate[0])? $cutedate[0]->cute_date:date('Y-m-d') !!}"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
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

<div>        
    



<!-- /.content-wrapper -->
@include('template.footer')  


<script type="text/javascript">

    $('#date-range_1').datepicker({
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