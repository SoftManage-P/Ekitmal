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
                                <h4 class="mt-0 header-title" style="display:inline-block">Bonus Review</h4>
                            </div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" id="num">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Identify number </span> 
                                    </a>
                                </li>
                                <li class="nav-item" id="amount">
                                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Bonus amount</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Prorate formula</span>   
                                    </a>
                                </li>
                                
                            </ul>
        
                                        <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="home" role="tabpanel">
                                    <table id="datatable_num" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                                    </table>
                                </div>
                                <div class="tab-pane p-3" id="profile" role="tabpanel">
                                    <table id="datatable_amount" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                                    </table>
                                </div>
                                <div class="tab-pane p-3" id="messages" role="tabpanel">
                                    <h3 class="mb-0" style="padding:100px; text-align: center;">
                                        Bonus = bonus/ 365 * work days
                                    </h3>
                                </div>
                                
                            </div>

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

    var $table1 = $('#datatable_num');
    var $table2 = $('#datatable_amount');
    $(document).ready(function() {
     
        var num_datatable = $table1.DataTable({
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
            "columnDefs": [
                {
                "targets": [7],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = '<input class="btn btn-info" type="button" value="Edit" onclick=edit_num('+rowData.id+',"'+rowData.name+'")></a>'
                    $(td).html(html);
                }
            }],

            "columns": [
                {"title": "No", "data": "no", "class": "text-center", "width": "5%"},
                {"title": "Name", "data": "name", "class": "text-center", "width": "*"},
                {"title": "1", "data": "num_1", "class": "text-center", "width": "*"},
                {"title": "2", "data": "num_2", "class": "text-center", "width": "*"},
                {"title": "3", "data": "num_3", "class": "text-center", "width": "*"},
                {"title": "4", "data": "num_4", "class": "text-center", "width": "*"},
                {"title": "5", "data": "num_5", "class": "text-center", "width": "*"},
                {"title": "Action", "data": "id", "class": "text-center", "width": "10%"},
            ],
            "lengthMenu": [
                [5, 10, 20, 50, 150, -1],
                [5, 10, 20, 50, 150, "All"] // change per page values here
            ],
            "scrollY": false,
            "scrollX": true,
            "scrollCollapse": true,
            "jQueryUI": true,

            "paging": true,
            "pagingType": "full_numbers",
            "pageLength": 20, // default record count per page
            bProcessing: true,
            autoWidth: true,
        });
        
        var amount_datatable = $table2.DataTable({
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
            "columnDefs": [
                {
                "targets": [7],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    html = '<input class="btn btn-info" type="button" value="Edit" onclick=edit_amount('+rowData.id+',"'+rowData.name+'")></a>'
                    $(td).html(html);
                }
            }],

            "columns": [
                {"title": "No", "data": "no", "class": "text-center", "width": "5%"},
                {"title": "Name", "data": "name", "class": "text-center", "width": "*"},
                {"title": "1", "data": "amount_1", "class": "text-center", "width": "*"},
                {"title": "2", "data": "amount_2", "class": "text-center", "width": "*"},
                {"title": "3", "data": "amount_3", "class": "text-center", "width": "*"},
                {"title": "4", "data": "amount_4", "class": "text-center", "width": "*"},
                {"title": "5", "data": "amount_5", "class": "text-center", "width": "*"},
                {"title": "Action", "data": "id", "class": "text-center", "width": "10%"},
            ],
            "lengthMenu": [
                [5, 10, 20, 50, 150, -1],
                [5, 10, 20, 50, 150, "All"] // change per page values here
            ],
            "scrollY": false,
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

    $('#amount').click(function(){
        $table2.DataTable().ajax.reload('', false);
    });
    $('#num').click(function(){
        $table1.DataTable().ajax.reload('', false);
    });
    function edit_num(id, name){
    $.ajax({
        url:'{{url("/admin/get_bonus_row")}}',
        type: 'POST',
        data: {id: id},
        cache: false,
        success: function (result) {
                $('#type').val('num');
                $('#myModalLabel').html('Bonus With Identify Number ');
            if(result.success==true){
                var data = result.data;
                $('#bonus_id').val(data.id);
                $('#name').val(name);
                $('#value_1').val(data.num_1);
                $('#value_2').val(data.num_2);
                $('#value_3').val(data.num_3);
                $('#value_4').val(data.num_4);
                $('#value_5').val(data.num_5);
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
    function edit_amount(id, name){
    $.ajax({
        url:'{{url("/admin/get_bonus_row")}}',
        type: 'POST',
        data: {id: id},
        cache: false,
        success: function (result) {
                $('#type').val('amount');
                $('#myModalLabel').html('Bonus With Amount ');
            if(result.success==true){
                var data = result.data;
                $('#bonus_id').val(data.id);
                $('#name').val(name);
                $('#value_1').val(data.amount_1);
                $('#value_2').val(data.amount_2);
                $('#value_3').val(data.amount_3);
                $('#value_4').val(data.amount_4);
                $('#value_5').val(data.amount_5);
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
               name:    $('#name').val(),
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
                if(result.type == 'num'){
                    setTimeout(function () {
                    $table1.DataTable().ajax.reload('', false);
                }, 200);
                } else if(result.type == 'amount'){
                    setTimeout(function () {
                    $table2.DataTable().ajax.reload('', false);
                }, 200);
                }
                
             
            }
            
        }
    });
    }
    
</script>