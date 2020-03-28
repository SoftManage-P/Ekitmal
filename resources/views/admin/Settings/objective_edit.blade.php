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
                                <a href="{{url('admin/objective')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-format-list-bulleted"></i>&nbsp;  List</button>
 </a>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-12 ">
                                <div class="card m-b-20 ">
                                    <div class="card-body">
                                        <form class="" action="{{url('admin/insert_objective')}}" autocomplete="on" method="post" role="form">
                                            <input type="hidden" name="id" value="{!! isset($objective)? $objective[0]->id:''  !!}" />
                                            <div class="form-group row" >
                                                <label class="col-lg-3 input" >Objective Type</label>
                                                <div class="col-lg-8 input" style="padding:5px">
                                                <select class="form-control " name="type">
                                                    <!-- <option>Select</option> -->
                                                    <option value="Financial" {!! isset($objective) && $objective[0]->type == "Financial" ? 'selected':'' !!}>Financial</option>
                                                    <option value="Non-Financial" {!! isset($objective) && $objective[0]->type == "Non-Financial" ? 'selected':'' !!}>Non-Financial</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" >
                                                <label class="col-lg-3 input">Objective Name</label>
                                                <input type="text" class="form-control col-lg-8 input" name="name" required placeholder="Objective Name" value="{!! isset($objective)? $objective[0]->name:'' !!}"/>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-lg-3">Main Objective</label>
                                                <div class="col-lg-8 input" style="padding:0px">
                                                <select class="form-control " name="parent_id">
                                                    <option value="0">Select Main Objective</option>
                                                    <?php foreach ($mainobjective as $val) {
                                                          ?>
                                                          <option value="<?php echo $val->id?>" {!! isset($objective) && $objective[0]->parent_id == $val->id ? 'selected':'' !!}><?php echo $val->name?></option>
                                                          <?php
                                                      }?>
                                                </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-lg-3 input" >Is Sub Objective</label>
                                                <input type="checkbox" id="switch3" switch="bool" name="check" {!! isset($objective) && $objective[0]->is_sub=='1' ? 'checked':'' !!}/>
                                                <label style="margin-top:10px" for="switch3" data-on-label="Yes" data-off-label="No"></label>
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
      
    // $(".select2").select2();

    

        
  });

</script>