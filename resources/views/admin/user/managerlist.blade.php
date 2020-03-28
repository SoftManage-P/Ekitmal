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
                                        
                                <h4 class="mt-0 header-title" style="display:inline-block">Manage User</h4>
                                <a href="{{url('admin/editmanager/0')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-table-edit"></i>&nbsp;New</button>
                                </a>
                                <button type="button" class="btn btn-outline-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal" style="display:inline-block; float:right;margin-right:10px"><i class="mdi mdi-table-edit"></i>&nbsp;Import Users</button>
                            </div>
                            
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 10; width: 100%;">
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->

    </div> <!-- content -->

<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="" action="{{url('admin/uploadCsvFile')}}" autocomplete="on" method="post" role="form">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12 text-center">
                        <a  href="{{url('admin/down_temp')}}" >
                            Download Template
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <label>Excel File Import</label>
                    <input type="file" class="filestyle" name="excelfile" data-buttonname="btn-secondary">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" onclick="sendfile()" class="btn btn-primary waves-effect waves-light">Import User</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    

<!-- /.content-wrapper -->
@include('template.footer') 

<script>

    var $table = $('#datatable');
    function user_delete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#58db83",
            cancelButtonColor: "#ec536c",
            confirmButtonText: "Yes, delete it!"
          }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: "{{url('admin/delete_user')}}",
                    type: 'POST',
                    data: {user_id:id},
                    // processData:false,
                    // contentType: false,
                    success: function (result) {
                        var res = $.parseJSON(result);
                        if(res.success==true){
                            Swal.fire("Deleted!", "Your file has been deleted.", "success");
                            $table.DataTable().ajax.reload('', false);
                            setTimeout(function () {
                                reload_table();} , 500);
                                }
                        
                    },
                    error: function(){ 
                       
                    }
                }); 

            }
        });
    }

    $(document).ready(function() {
      
        var datatable = $table.dataTable({
            "ordering": false,
            "info": true,
            "searching": true,
            "ajax": {
                "type": "POST",
                "async": true,
                "url": '{{url("/admin/managerlist")}}',
                "data": {},
                "dataSrc": "data",
                "dataType": "json",
                "cache": false,
            },
            "columnDefs": [
                {
                    "targets": [0],
                    orderable: false,

                    "createdCell": function (td, cellData, rowData, row, col) {
                        if(rowData.user_role=='manager'){
                            $(td).html('<i data-toggle class="far fa-plus-square text-primary h5 m-0" style="cursor: pointer;"></i>');
                        }
                        else if(rowData.has_sub==0) $(td).html('<i class="far fa-minus-square text-primary h5 m-0" style="cursor: pointer;"></i>');
                        else $(td).html('');
                   }
                },{
                "targets": [7],
                orderable: false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    var id = ''+cellData+'';
                    html = '<a href="{{url('admin/editmanager/')}}/'+cellData+'"><input class="btn btn-info" type="button" value="Edit"></a> <input class="btn btn-danger" type="button" value="Delete" onclick="user_delete('+cellData+')">'
                    $(td).html(html);
                }
            }],

            "columns": [
                {"title": "No", "data": "id", "class": "text-center", "width": "5%"},
                {"title": "Name", "data": "full_name", "class": "text-center", "width": "5%"},
                {"title": "Email", "data": "email", "class": "text-center", "width": "10%"},
                {"title": "Department", "data": "department", "class": "text-center", "width": "10%"},
                {"title": "Grade", "data": "grade", "class": "text-center", "width": "5%"},
                {"title": "DOJ", "data": "DOJ", "class": "text-center", "width": "15%"},
                {"title": "Basic Salary", "data": "basic_salary", "class": "text-center", "width": "10%"},
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

        var datatableInit = function() {
            var $table = $('#datatable');

            $table.on('click', 'i[data-toggle]', function() {
                var $this = $(this),
                    tr = $(this).closest( 'tr' ).get(0);
                    var manager=datatable.fnGetData(tr);
                if ($this.hasClass('fa-minus-square')) {
                    $this.removeClass( 'fa-minus-square' ).addClass( 'fa-plus-square' );
                    $table.find( 'tbody tr' ).each(function() {
                        var employee=datatable.fnGetData( this );
                        if(employee.parent_id==manager.id)
                            $(this).css({"display": "none"});
                        // else 
                        //     $(this).css({"display": ""});
                    });
                } else {
                    $this.removeClass( 'fa-plus-square' ).addClass( 'fa-minus-square' );
                    
                    $table.find( 'tbody tr' ).each(function() {
                        var employee=datatable.fnGetData( this );
                        if(employee.parent_id==manager.id)
                            $(this).css({"display": ""});
                    });
                }
            });
        };

        $(function() {
            datatableInit();
        });
    });

    function sendfile(){
        if($("input[name='excelfile']")[0].files.length == 0) return;
        var datas = new FormData();
        datas.append('excelfile', $("input[name='excelfile']")[0].files[0]);
        var url = "{{url('admin/uploadCsvFile')}}";
        $.ajax({
            url: url,
            data: datas,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function (data, status) {
            },
            success: function (data, status) {
                if(data.status == "1"){
                    Swal.fire(data.msg);
                }else{
                    Swal.fire(data.msg);
                }

                $('#myModal').modal('hide');
                $table.DataTable().ajax.reload('', false);
                setTimeout(function () {
                        reload_table();} , 500);
            },
            error: function (data, status, e) {
                Swal.fire("happen errors in uploading");
                $table.DataTable().ajax.reload('', false);
                $('#myModal').modal('hide')
                setTimeout(function () {
                        reload_table();} , 500);
            }
        }); 
    }

    setTimeout(function () {
    reload_table();} , 500);
    
    function reload_table(){
        var $table = $('#datatable');
        var datatable = $table.dataTable();
        $table.find( 'tbody tr' ).each(function() {
            var user=datatable.fnGetData( this );
            if(user.user_role=='employee')
                $(this).css({"display": "none"});
        });
    } 
</script>