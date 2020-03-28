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
                            <div class="" style="padding:25px;">
                                <h4 class="mt-0 header-title" style="display:inline-block">Performance Rating Mechanism</h4>
 </a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width: 30%;">Rate</th>
                                        <th style="width: 30%;">Result</th>
                                        <th>Achivements %  (ex.  50-75  or  > 110)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            <a href="#" id="result_5" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[5]->result_des) ? $rate[5]->result_des:'' !!}</a>
                                        </td>
                                        <td>
                                            > <a href="#" id="achive_5" data-type="number" data-pk="1" data-title="Enter username">{!! isset($rate[5]->achivement) ? $rate[5]->achivement:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            <a href="#" id="result_4" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[4]->result_des) ? $rate[4]->result_des:'' !!}</a>
                                        </td>
                                        <td>
                                            <a href="#" id="achive_4" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[4]->achivement) ? $rate[4]->achivement:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <a href="#" id="result_3" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[3]->result_des) ? $rate[3]->result_des:'' !!}</a>
                                        </td>
                                        <td>
                                            <a href="#" id="achive_3" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[3]->achivement) ? $rate[3]->achivement:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <a href="#" id="result_2" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[2]->result_des) ? $rate[2]->result_des:'' !!}</a>
                                        </td>
                                        <td>
                                            <a href="#" id="achive_2" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[2]->achivement) ? $rate[2]->achivement:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <a href="#" id="result_1" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[1]->result_des) ? $rate[1]->result_des:'' !!}</a>
                                        </td>
                                        <td>
                                            < <a href="#" id="achive_1" data-type="text" data-pk="1" data-title="Enter username">{!! isset($rate[1]->achivement) ? $rate[1]->achivement:'' !!}</a>
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

    $('#result_5').editable({
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
    $('#result_4').editable({
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
    $('#result_3').editable({
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
    $('#result_2').editable({
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
    $('#result_1').editable({
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

    $('#achive_5').editable({
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
    $('#achive_4').editable({
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
    $('#achive_3').editable({
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
    $('#achive_2').editable({
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
    $('#achive_1').editable({
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
        // return $process=true;
        $.ajax({
            url: "{{url('admin/insert_mechanism')}}",
            type: 'POST',
            data: {name:params.name,
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
</script>