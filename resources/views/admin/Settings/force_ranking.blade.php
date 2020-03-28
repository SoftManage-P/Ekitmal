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
                                <h4 class="mt-0 header-title">Force Ranking</h4>
                                <div class="col-sm-8"></div>
                                <form action="{{url('admin/insert_force_ranking_allow')}}" method="post">
                                <div class="form-group" style="font-size:18px;">
                                    <input type="checkbox" id="switch3"  switch="bool" name="check" {{ isset($ranking[5]->allowed) && $ranking[5]->allowed =='1' ? 'checked':'' }}>
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
                                        <th style="width: 50%;">Rating</th>
                                        <th>Population %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            <a href="#" id="population_5" data-type="text" data-pk="1" data-title="Enter username">{!! isset($ranking[5]->population) ? $ranking[5]->population:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            <a href="#" id="population_4" data-type="text" data-pk="1" data-title="Enter username">{!! isset($ranking[4]->population) ? $ranking[4]->population:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <a href="#" id="population_3" data-type="text" data-pk="1" data-title="Enter username">{!! isset($ranking[3]->population) ? $ranking[3]->population:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <a href="#" id="population_2" data-type="text" data-pk="1" data-title="Enter username">{!! isset($ranking[2]->population) ? $ranking[2]->population:'' !!}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <a href="#" id="population_1" data-type="text" data-pk="1" data-title="Enter username">{!! isset($ranking[1]->population) ? $ranking[1]->population:'' !!}</a>
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

    $('#population_5').editable({
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
    $('#population_4').editable({
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
    $('#population_3').editable({
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
    $('#population_2').editable({
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
    $('#population_1').editable({
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
            url: "{{url('admin/insert_force_ranking')}}",
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
    $("#switch3").on("click", function(){
        $('#submit').click();
    })

</script>