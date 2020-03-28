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
                                <h4 class="mt-0 header-title" style="display:inline-block">Evaluation Performance</h4>

                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div> <!-- content -->
   



<!-- /.content-wrapper -->
@include('template.footer')  
<script>

    var $table = $('#datatable');

    $(document).ready(function() {
      
        var manager_datatable = $table.DataTable({
                "ordering": true,
                "info": true,
                "searching": true,
                "ajax": {
                    "type": "POST",
                    "async": true,
                    "url": '{{url("/employee/evaluation_list")}}',
                    "data": {},
                    "dataSrc": "data",
                    "dataType": "json",
                    "cache": false,
                },
                "columnDefs": [
                    {
                    "targets": [6],
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
                    "targets": [10],
                    orderable: false,
                    "createdCell": function (td, cellData, rowData, row, col) {
                            html = '';
                        if(rowData.eval_date !='no'){
                           if(rowData.status == 1 || rowData.status == 2){
                                html = '<input class="btn btn-secondary waves-effect" type="button" value="Evaluate">'
                            } else if(rowData.status == 0){
                                html = '<a href="{{url('employee/edit_evaluation/')}}/'+cellData+'"><input class="btn btn-info" type="button" value="ReEvaluate"></a>'
                            }else html = '<a href="{{url('employee/edit_evaluation/')}}/'+cellData+'"><input class="btn btn-info" type="button" value="Evaluate"></a>'
                        }else {
                            html = '<input class="btn btn-secondary waves-effect" type="button" value="Evaluate">'
                        }

                        
                        $(td).html(html);
                    }
                }],

                "columns": [
                    {"title": "No", "data": "no", "class": "text-center", "width": "5%"},
                    {"title": "Type", "data": "type", "class": "text-center", "width": "*"},
                    {"title": "Main Objective", "data": "name", "class": "text-center", "width": "*"},
                    {"title": "Sub Objective", "data": "sub_name", "class": "text-center", "width": "*"},
                    {"title": "Target Description", "data": "descript_target", "class": "text-center", "width": "*"},
                    {"title": "Date to Completion", "data": "completion_date", "class": "text-center", "width": "*"},
                    {"title": "Target Type", "data": "target_type", "class": "text-center", "width": "*"},
                    {"title": "Target", "data": "target", "class": "text-center", "width": "*"},
                    {"title": "Actual achieved", "data": "actual_achived", "class": "text-center", "width": "*"},
                    {"title": "Weights", "data": "weights", "class": "text-center", "width": "*"},
                    {"title": "Active", "data": "id", "class": "text-center", "width": "10%"},
                ],
                "lengthMenu": [
                    [5, 10, 20, 50, 150, -1],
                    [5, 10, 20, 50, 150, "All"] // change per page values here
                ],
                "scrollY": true,
                "scrollX": true,
                "scrollCollapse": true,
                "jQueryUI": true,

                "paging": true,
                "pagingType": "full_numbers",
                "pageLength": 20, // default record count per page
                bProcessing: true,
                autoWidth: true,
                
            });
    });

var e='{{Session::get('eval_date_error')}}';
  if(e !=''){
    Swal.fire(e);
}
</script>