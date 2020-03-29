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
                            <div class="row" style="padding:25px;">
                                <h4 class="mt-0 header-title col-sm-4" style="display:inline-block">Objective Performance</h4>
                                <div class="form-group ">
                                    <select class="form-control " id="year" >
                                        <option>Select Year</option>
                                        <?php foreach ($years as $val) {?>
                                        <option value="<?php echo $val->years?>" {!!  $val->years == date('Y')? 'selected':'' !!}><?php echo $val->years?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4"></div>
                                <a href="{{url('admin/exportKPI')}}"><button class="btn btn-outline-primary waves-effect waves-light" type="button" style="float:right;    margin-right: 5px;" ><span>Export</span></button></a><span></span>
                                <a href="{{url('admin/view_chart')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-chart-bar"></i>&nbsp;  View Chart</button>
                                </a>
                            </div>
                            <table id="kpi_datatable" class="table" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="" style="padding:25px;">
                                <h4 class="mt-0 header-title" style="display:inline-block">Bonus Review & Pay Increase</h4>
                                
                                <button type="button" class="btn btn-outline-primary waves-effect waves-light" onclick="get_bonus()" style=" float:right;    margin-right: 20px;"> Release</button>
                                <a href="{{url('admin/exportAll')}}"><button class="btn btn-outline-primary waves-effect waves-light" type="button" style="float:right;    margin-right: 5px;" ><span>Export</span></button></a><span></span>

                                <input type="hidden" id="get_bonus_value" value="no">
                            </div>
                            
                            <table id="bonus_datatable" class="table" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                            </table>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
            @if ($view_performance == 'allowed')
            <div class="row">    
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="" style="padding:25px;">
                                <h4 class="mt-0 header-title" style="display:inline-block">Performance Result </h4>
                            </div>
                            <table id="performance_datatable" class="table" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
            @endif
        </div> <!-- container-fluid -->
    </div> <!-- content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5 id="modal_title"></h5>
                    <input type="hidden" class="form-control col-sm-7" name="id" id="kpi_id" />
                
                <div class="form-group row" >
                    <label class="col-sm-4" >Overall Rating</label>
                    <input type="number" data-parsley-max="5" class="form-control col-sm-7" name="overall_rating" id="overall_rating" />
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick ="insert_overall_rating();">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    
        
<!-- /.content-wrapper -->
@include('template.footer')  


<script>

var $table = $('#kpi_datatable');
var $table1 = $('#bonus_datatable');
var $table2 = $('#performance_datatable');
setTimeout(function () {
    reload_table();},500);

    $('#year').on('change',function(){
        $table.DataTable().ajax.reload();
        $table1.DataTable().ajax.reload();
        $table2.DataTable().ajax.reload();
        setTimeout(function () {
        reload_table();},500);
    })

    function get_bonus(){
        $('#get_bonus_value').val('yes');
        $table1.DataTable().ajax.reload();
    }
        


    $(document).ready(function() {
        var kpi_datatable = $table.dataTable({
            "ordering": false,
            "info": true,
            "searching": true,
            "ajax": {
                "type": "POST",
                "async": true,
                "url": '{{url("/admin/report_kpi_list")}}',
                "data":function(d){
                        return {
                                year:$('#year').val()
                               };
                },
                "dataSrc": "data",
                "dataType": "json",
                "cache": false,
            },
            "columnDefs": [
                    {
                        "targets": [0],
                        orderable: false,

                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(rowData.has_sub==1){
                                $(td).html('<i data-toggle class="far fa-plus-square text-primary h5 m-0" style="cursor: pointer;"></i>');
                            }else if(rowData.has_sub==0) $(td).html('<i class="far fa-minus-square text-primary h5 m-0" style="cursor: pointer;"></i>');
                            else $(td).html('');
                       }
                    },
                    {
                        "targets": [4],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            html= '';
                            if(cellData=='num'){
                                html= 'Number';
                            } else if(cellData == 'percent')  {
                                html= 'Percent';
                            } else if(cellData == 'both'){
                                html= 'Both';
                            }
                            $(td).html(html);
                        }
                    },{
                "targets": [12],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = '<input class="btn btn-info" type="button" value="Edit">'
                    $(td).html(html);
                }
            }],

            "columns": [
                {"title": "#", "data": "id", "class": "text-center", "width": "5%"},
                {"title": "Type", "data": "type", "class": "text-center", "width": "*"},
                {"title": "Objective", "data": "name", "class": "text-center", "width": "*"},
                {"title": "Date to Completion", "data": "completion_date", "class": "text-center", "width": "*"},
                {"title": "Target Type", "data": "target_type", "class": "text-center", "width": "*"},
                {"title": "Target", "data": "target", "class": "text-center", "width": "*"},
                {"title": "Mid Achived", "data": "actual_achived_1", "class": "text-center", "width": "*"},
                {"title": "End Achived", "data": "actual_achived_2", "class": "text-center", "width": "*"},
                {"title": "Weights", "data": "weights", "class": "text-center", "width": "*"},
                {"title": "Mid Rate", "data": "rate_1", "class": "text-center", "width": "*"},
                {"title": "End Rate", "data": "rate_2", "class": "text-center", "width": "*"},
                {"title": "Overall Rating", "data": "overall_rating", "class": "text-center", "width": "*"},
                {"title": "Action", "data": "id", "class": "text-center", "width": "*"},
            ],
            "lengthMenu": [
                [5, 10, 20, 50, 150, -1],
                [5, 10, 20, 50, 150, "All"] // change per page values here
            ],
            "scrollY": false,
            "scrollX": true,
            "scrollCollapse": false,
            "jQueryUI": true,
            "paging": true,
            "pagingType": "full_numbers",
            "pageLength": 20, // default record count per page
            bProcessing: true,
            autoWidth: true,
        });

        
        var datatableInit = function() {
            var $table = $('#kpi_datatable');

            $table.on('click', 'i[data-toggle]', function() {


                var $this = $(this),
                    tr = $(this).closest( 'tr' ).get(0);
                    var main=kpi_datatable.fnGetData(tr);
                if ($this.hasClass('fa-minus-square')) {
                    $this.removeClass( 'fa-minus-square' ).addClass( 'fa-plus-square' );
                    $table.find( 'tbody tr' ).each(function() {
                        var sub=kpi_datatable.fnGetData( this );
                        if(sub.parent_id==main.obj_id)
                            $(this).css({"display": "none"});
                    });
                } else {
                    $this.removeClass( 'fa-plus-square' ).addClass( 'fa-minus-square' );
                    
                    $table.find( 'tbody tr' ).each(function() {
                        var sub=kpi_datatable.fnGetData( this );
                        if(sub.parent_id==main.obj_id)
                            $(this).css({"display": ""});
                    });
                }
            });
            
            $table.on('click', 'input[value="Edit"]', function() {
                var data = kpi_datatable.fnGetData($(this).parents('tr')[0]);

                $('#kpi_id').val(data.id);
                $('#overall_rating').val(data.overall_rating);
                $('#myModalLabel').html("Edit Overall Rating");
                $('#myModal').modal();
            });

        };

        $(function() {
            datatableInit();
        });

    
        
        var bonus_datatable = $table1.dataTable({
           
            "ordering": true,
            "info": true,
            "searching": true,
            "ajax": {
                "type": "POST",
                "async": true,
                "url": '{{url("/admin/report_bonus_list")}}',
                "data":function(d){
                        return {
                                year:$('#year').val(),
                                get_bonus_value:$('#get_bonus_value').val()
                               };
                },
                "dataSrc": "data",
                "dataType": "json",
                "cache": false,
            },
            "columnDefs": [
            ],

            "columns": [
                {"title": "No", "data": "no", "class": "text-center", "width": "5%"},
                {"title": "User Name", "data": "full_name", "class": "text-center", "width": "5%"},
                {"title": "Department", "data": "department_name", "class": "text-center", "width": "10%"},
                {"title": "Grade", "data": "grade", "class": "text-center", "width": "5%"},
                {"title": "DOJ", "data": "DOJ", "class": "text-center", "width": "15%"},
                {"title": "Basic Salary", "data": "basic_salary", "class": "text-center", "width": "10%"},
                {"title": "Rate", "data": "rating", "class": "text-center", "width": "10%"},
                {"title": "Bonus Identify Number", "data": "bonus_num", "class": "text-center", "width": "10%"},
                {"title": "Bonus Amount", "data": "bonus_amount", "class": "text-center", "width": "10%"},
                {"title": "Pay Increase", "data": "bonus_increase", "class": "text-center", "width": "10%"}
            ],
            "lengthMenu": [
                [5, 10, 20, 50, 150, -1],
                [5, 10, 20, 50, 150, "All"] // change per page values here
            ],
            "scrollY": true,
            "scrollX": true,
            "scrollCollapse": false,
            "jQueryUI": true,

            "paging": true,
            "pagingType": "full_numbers",
            "pageLength": 20, // default record count per page
            bProcessing: true,
            autoWidth: true,
           
        });
        
        var performance_datatable = $table2.dataTable({
            "ordering": true,
            "info": true,
            "searching": true,
            "ajax": {
                "type": "POST",
                "async": true,
                "url": '{{url("/admin/report_bonus_list")}}',
                "data":function(d){
                        return {
                                year:$('#year').val()
                               };
                },
                "dataSrc": "data",
                "dataType": "json",
                "cache": false,
            },
            "columnDefs": [],

            "columns": [
                {"title": "No", "data": "no", "class": "text-center", "width": "5%"},
                {"title": "User Name", "data": "full_name", "class": "text-center", "width": "5%"},
                {"title": "Department", "data": "department_name", "class": "text-center", "width": "10%"},
                {"title": "Grade", "data": "grade", "class": "text-center", "width": "5%"},
                {"title": "DOJ", "data": "DOJ", "class": "text-center", "width": "15%"},
                {"title": "Basic Salary", "data": "basic_salary", "class": "text-center", "width": "10%"},
                {"title": "Rate", "data": "rating", "class": "text-center", "width": "10%"},
                {"title": "Performance Result", "data": "performance", "class": "text-center", "width": "10%"},
            ],
            "lengthMenu": [
                [5, 10, 20, 50, 150, -1],
                [5, 10, 20, 50, 150, "All"] // change per page values here
            ],
            "scrollY": false,
            "scrollX": true,
            "scrollCollapse": false,
            "jQueryUI": true,

            "paging": true,
            "pagingType": "full_numbers",
            "pageLength": 20, // default record count per page
            bProcessing: true,
            autoWidth: true,
        });
    });
function insert_overall_rating(){
    $.ajax({
        url:'{{url("/admin/insert_overall_rating")}}',
        type: 'POST',
        data: {id:      $('#kpi_id').val(),
               overall_rating:    $('#overall_rating').val(),
                },
        cache: false,
        success: function (result) {
            if(result.result == 'success'){
                $('#myModal').modal('hide');
                // setTimeout(function () {
                    $table.DataTable().ajax.reload();
                // }, 200);
            }
        }
    });
}


function reload_table(){
    var $table = $('#kpi_datatable');
    var kpi_datatable = $table.dataTable();
    $table.find( 'tbody tr' ).each(function() {
        var objective=kpi_datatable.fnGetData( this );
        if(objective!=null && objective.is_sub==1)
            $(this).css({"display": "none"});
    });
}

</script>