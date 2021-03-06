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
                                <h4 class="mt-0 header-title" style="display:inline-block">Edit Objective</h4>
                                <a href="{{url('manager/assign')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12 ">
                                <div class="card m-b-20 ">
                                    <div class="card-body">
                                        <form class="" action="{{url('manager/insert_assign')}}" autocomplete="on" method="post" role="form">
                                            <input type="hidden" name="id" value="{!! isset($objective)? $objective[0]->id:''  !!}" />
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Objective Type</label>
                                                        <div class="col-sm-7 input"  style="padding:0px">
                                                        <select class="form-control " name="type" disabled>
                                                            <option value="Financial" {!! isset($objective) && $objective[0]->type == "Financial" ? 'selected':'' !!}>Financial</option>
                                                            <option value="Non-Financial" {!! isset($objective) && $objective[0]->type == "Non-Financial" ? 'selected':'' !!}>Non-Financial</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4">Objective Name</label>
                                                        <input type="text" class="form-control col-sm-7" name="name" disabled placeholder="Objective Name" value="{!! isset($objective)? $objective[0]->name:'' !!}"/>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-4">Main Objective</label>
                                                        <div class="col-sm-7 input" style="padding:0px">
                                                        <select class="form-control " name="parent_id" disabled>
                                                            <option value="0">This is Main Objective</option>
                                                            <?php foreach ($mainobjective as $val) {
                                                                  ?>
                                                                  <option value="<?php echo $val->id?>" {!! isset($objective) && $objective[0]->parent_id == $val->id ? 'selected':'' !!}><?php echo $val->name?></option>
                                                                  <?php
                                                              }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-4 input" >Employee</label>
                                                        <div class="col-sm-7 input"  style="padding:0px">
                                                        <select class="form-control " name="employee_id" id="employee_id" required>
                                                        <option value="0">Department</option>
                                                        <?php foreach ($employee as $value) { ?>
                                                            <option value="<?php echo $value->id?>" {!! isset($objective) && $objective[0]->employee_id == $value->id ? 'selected':'' !!}><?php echo $value->full_name?></option>
                                                        <?php }?>
                                                        </select>
                                                        </div>
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