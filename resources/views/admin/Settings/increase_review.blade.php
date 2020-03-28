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
                                <h4 class="mt-0 header-title" style="display:inline-block">Pay Increase Review</h4>
                            </div>
                            <table id="datatable_increase" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
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
                    <input type="hidden" class="form-control col-sm-7" name="id" id="bonus_id" />
                    <input type="hidden" class="form-control col-sm-7" name="type" id="type" />
                <div class="form-group row" >
                    <label class="col-sm-4" >Grade Name</label>
                    <input type="text" class="form-control col-sm-7" name="name" id="name" />
                </div>
                <div class="form-group row" >
                    <label class="col-sm-4" >Rating 1</label>
                    <input type="text" class="form-control col-sm-7" name="value_1" id="value_1" />
                </div>
                <div class="form-group row" >
                    <label class="col-sm-4" >Rating 2</label>
                    <input type="text" class="form-control col-sm-7" name="value_2" id="value_2"  />
                </div>
                <div class="form-group row" >
                    <label class="col-sm-4" >Rating 3</label>
                    <input type="text" class="form-control col-sm-7" name="value_3" id="value_3" />
                </div>
                <div class="form-group row" >
                    <label class="col-sm-4" >Rating 4</label>
                    <input type="text" class="form-control col-sm-7" name="value_4" id="value_4"  />
                </div>
                <div class="form-group row" >
                    <label class="col-sm-4" >Rating 5</label>
                    <input type="text" class="form-control col-sm-7" name="value_5" id="value_5"  />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick ="insert_bonus();">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /.content-wrapper -->
@include('template.footer')  
<script>

    var $table = $('#datatable_increase');
    $(document).ready(function() {
     
        var datatable = $table.DataTable({
            "ordering": false,
            "info": true,
            "searching": true,
            "ajax": {
                "type": "POST",
                "async": true,
                "url": '{{url("/admin/bonus_list")}}',
                "data": {},
                "dataSrc": "data",
                "dataType": "json",
                "cache": false,
            },
            "columnDefs": [{
                "targets": [2],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = cellData+' %'
                    $(td).html(html);
                }
            },{
                "targets": [3],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = cellData+' %'
                    $(td).html(html);
                }
            },{
                "targets": [4],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                     html = cellData+' %'
                    $(td).html(html);
                }
            },{
                "targets": [5],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = cellData+' %'
                    $(td).html(html);
                }
            },{
                "targets": [6],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = cellData+' %'
                    $(td).html(html);
                }
            },{
                "targets": [7],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = '<input class="btn btn-info" type="button" value="Edit" onclick=edit_increase('+rowData.id+',"'+rowData.name+'")></a>'
                    $(td).html(html);
                }
            }],

            "columns": [
                {"title": "No", "data": "no", "class": "text-center", "width": "5%"},
                {"title": "Name", "data": "name", "class": "text-center", "width": "*"},
                {"title": "1", "data": "increase_1", "class": "text-center", "width": "*"},
                {"title": "2", "data": "increase_2", "class": "text-center", "width": "*"},
                {"title": "3", "data": "increase_3", "class": "text-center", "width": "*"},
                {"title": "4", "data": "increase_4", "class": "text-center", "width": "*"},
                {"title": "5", "data": "increase_5", "class": "text-center", "width": "*"},
                {"title": "Action", "data": "id", "class": "text-center", "width": "10%"},
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

    function edit_increase(id, name){
    $.ajax({
        url:'{{url("/admin/get_bonus_row")}}',
        type: 'POST',
        data: {id: id},
        cache: false,
        success: function (result) {
                $('#type').val('increase');
                $('#myModalLabel').html('Pay Increase Rating ');
            if(result.success==true){
                var data = result.data;
                $('#bonus_id').val(data.id);
                $('#name').val(name);
                $('#value_1').val(data.increase_1);
                $('#value_2').val(data.increase_2);
                $('#value_3').val(data.increase_3);
                $('#value_4').val(data.increase_4);
                $('#value_5').val(data.increase_5);
            }else{
                $('#bonus_id').val(0);
                $('#name').val(name);
                $('#value_1').val(0);
                $('#value_2').val(0);
                $('#value_3').val(0);
                $('#value_4').val(0);
                $('#value_5').val(0);
            }
            $('#myModal').modal('show');
        }
    });
    }
   
    function insert_bonus(){
    $.ajax({
        url:'{{url("/admin/insert_bonus")}}',
        type: 'POST',
        data: {id:      $('#bonus_id').val(),
               name:      $('#name').val(),
               value_1: $('#value_1').val(),
               value_2: $('#value_2').val(),
               value_3: $('#value_3').val(),
               value_4: $('#value_4').val(),
               value_5: $('#value_5').val(), 
               type:    $('#type').val()
                },
        cache: false,
        success: function (result) {
            if(result.result == 'success'){
                $('#myModal').modal('hide');
                
                    setTimeout(function () {
                    $table.DataTable().ajax.reload('', false);
                }, 200);
                
             
            }
            
        }
    });
    }
    
</script>