@include('template.header')
@include('template.sidebar')
<style type="text/css">
    input[switch] + label {
    width: 70px !important;}
    input[switch]:checked + label:after {
    left: 50px;}
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
                            <div class="row" style="padding:25px;">
                                <h4 class="mt-0 header-title">Department and individual achievements percent </h4>
                                <div class="col-sm-4"></div>
                                <form action="{{url('admin/percent_allow')}}" method="post">
                                <div class="form-group" style="font-size:18px;">
                                    <input type="checkbox" id="switch3"  switch="bool" name="check" {{ isset($percent_ceo[0]) && $percent_ceo[0]->allowed=='1' ? 'checked':'' }}>
                                    <label   for="switch3" data-on-label="Allow"
                                            data-off-label="Disallow"></label>
                                </div>
                                <button type="submit" hidden id="submit"></button>
                                </form>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;">Title</th>
                                        <th style="width: 10%;">Grade</th>
                                        <th style="width: 20%;">Company</th>
                                        <th style="width: 20%;">Department</th>
                                        <th style="width: 20%;">Individual</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>CEO</td>
                                        <td>1</td>
                                        <td>
                                            <a href="#" id="company_percent-1" data-type="number"  data-pk="CEO" >{!! isset($percent_ceo[0]) && isset($percent_ceo[0]->company_percent) ? $percent_ceo[0]->company_percent:'' !!}</a>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Department Manager</td>
                                        <td>2</td>
                                        <td>
                                            <a href="#" id="company_percent-2" data-type="number"  data-pk="Manager" >{!! isset($percent_manager[0]) && isset($percent_manager[0]->company_percent) ? $percent_manager[0]->company_percent:'' !!}</a>
                                        </td>
                                        <td>
                                            <a href="#" id="department_percent-2" data-type="number" data-pk="Manager" >{!! isset($percent_manager[0]) && isset($percent_manager[0]->department_percent) ? $percent_manager[0]->department_percent:'' !!}</a>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Employee</td>
                                        <td>3</td>
                                        <td>
                                            <a href="#" id="company_percent-3" data-type="number" data-pk="Employee" >{!! isset($percent_employee[0]) && isset($percent_employee[0]->company_percent) ? $percent_employee[0]->company_percent:'' !!}</a>
                                        </td>
                                        <td>
                                            <a href="#" id="department_percent-3" data-type="number" data-pk="Employee" >{!! isset($percent_employee[0]) && isset($percent_employee[0]->department_percent) ? $percent_employee[0]->department_percent:'' !!}</a>
                                        </td>
                                        <td>
                                            <a href="#" id="individual_percent-3" data-type="number" data-pk="Employee" >{!! isset($percent_employee[0]) && isset($percent_employee[0]->individual_percent) ? $percent_employee[0]->individual_percent:'' !!}</a>
                                        </td>
                                       
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->

    </div> <!-- content -->

   



<!-- /.content-wrapper -->
@include('template.footer')  
<script type="text/javascript">
    $.fn.editableform.buttons =
        '<button type="submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button>' +
        '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light"><i class="mdi mdi-close"></i></button>';

    $('#company_percent-1').editable({
        type: 'text',
        mode: 'inline',
        inputclass: 'form-control-sm',
        url: function(params) {
            var d = new $.Deferred;
            if(params.value === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                insert(params);
                d.resolve();
            }
        } 
    });
    $('#company_percent-2').editable({
        type: 'text',
        mode: 'inline',
        inputclass: 'form-control-sm',
        url: function(params) {
            var d = new $.Deferred;
            if(params.value === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                insert(params);
                d.resolve();
                return d.promise();
            }
        } 
    });
    $('#company_percent-3').editable({
        type: 'text',
        mode: 'inline',
        inputclass: 'form-control-sm',
        url: function(params) {
            var d = new $.Deferred;
            if(params.value === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                insert(params);
                d.resolve();
                return d.promise();
            }
        } 
    });
    $('#department_percent-2').editable({
        type: 'text',
        mode: 'inline',
        inputclass: 'form-control-sm',
        url: function(params) {
            var d = new $.Deferred;
            if(params.value === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                insert(params);
                d.resolve();
                return d.promise();
            }
        } 
    });
    $('#department_percent-3').editable({
        type: 'text',
        mode: 'inline',
        inputclass: 'form-control-sm',
        url: function(params) {
            var d = new $.Deferred;
            if(params.value === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                insert(params);
                d.resolve();
                return d.promise();
            }
        } 
    });
    $('#individual_percent-3').editable({
        type: 'text',
        mode: 'inline',
        inputclass: 'form-control-sm',
        url: function(params) {
            var d = new $.Deferred;
            if(params.value === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                insert(params);
                d.resolve();
                return d.promise();
            }
        } 
    });

    function insert(params){
        $.ajax({
            url: "{{url('admin/insert_percent')}}",
            type: 'POST',
            data: {level:params.pk,
                    name:params.name,
                    value : params.value},
            success: function (data, status, xhr) {
                var res = $.parseJSON(data);
                if(res.success==true){
                    // return true;
                }else {
                    // return false;
                }
            },
            error: function(){ 
                return false;
            }
        }); 
    }
    $("#switch3").on("click", function(){
        $('#submit').click();
    })

    var e='{{Session::get('performance_error_msg')}}';
      if(e !=''){
        Swal.fire(e);
      }
</script>