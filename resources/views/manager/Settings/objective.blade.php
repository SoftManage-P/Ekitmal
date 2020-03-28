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
                                <h4 class="mt-0 header-title" style="display:inline-block">Manage Objectives</h4>
                                <a href="{{url('manager/editobjective/0')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-table-edit"></i>&nbsp;New</button>
 </a>
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

    var base_url = "{{url('/')}}";
    var $table = $('#datatable');
    function data_delete(id) {
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
                    url: "{{url('manager/delete_objective')}}",
                    type: 'POST',
                    data: {id:id},
                    // processData:false,
                    // contentType: false,
                    success: function (result) {
                        var res = $.parseJSON(result);
                        if(res.success==true){
                            Swal.fire("Deleted!", "Your file has been deleted.", "success");
                            $table.DataTable().ajax.reload('', false);
                            setTimeout(function () {
                                var $table = $('#datatable');
                                var datatable = $table.dataTable();
                                $table.find( 'tbody tr' ).each(function() {
                                    var objective=datatable.fnGetData( this );
                                    if(objective.is_sub==1)
                                        $(this).css({"display": "none"});
                                });
                            },500)
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
                    "url": '{{url("/manager/objectivelist")}}',
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
                            if(rowData.has_sub==1){
                                $(td).html('<i data-toggle class="far fa-plus-square text-primary h5 m-0" style="cursor: pointer;"></i>');
                            }else if(rowData.has_sub==0) $(td).html('<i class="far fa-minus-square text-primary h5 m-0" style="cursor: pointer;"></i>');
                            else $(td).html('');
                       }
                    },{
                    "targets": [4],
                    orderable: false,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        html = '<a href="{{url('manager/editobjective/')}}/'+cellData+'"><input class="btn btn-info" type="button" value="Edit"></a> <input class="btn btn-danger" type="button" value="Delete" onclick="data_delete('+cellData+')">'
                        $(td).html(html);
                    }
                }],

                "columns": [
                    {"title": "#", "data": "id", "class": "text-center", "width": "5%"},
                    {"title": "Objective Type", "data": "type", "class": "text-center", "width": "*"},
                    {"title": "Main Objective Name", "data": "name", "class": "text-center", "width": "*"},
                    {"title": "Created At", "data": "created_at", "class": "text-center", "width": "*"},
                    {"title": "Active", "data": "id", "class": "text-center", "width": "10%"},
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

        setTimeout(function () {
        var $table = $('#datatable');
        $table.find( 'tbody tr' ).each(function() {
            var objective=datatable.fnGetData( this );
            if(objective.is_sub==1)
                $(this).css({"display": "none"});
        });
        },500)

        var datatableInit = function() {
            var $table = $('#datatable');

            $table.on('click', 'i[data-toggle]', function() {


                var $this = $(this),
                    tr = $(this).closest( 'tr' ).get(0);
                    var main=datatable.fnGetData(tr);
                if ($this.hasClass('fa-minus-square')) {
                    $this.removeClass( 'fa-minus-square' ).addClass( 'fa-plus-square' );
                    $table.find( 'tbody tr' ).each(function() {
                        var sub=datatable.fnGetData( this );
                        if(sub.parent_id==main.id)
                            $(this).css({"display": "none"});
                    });
                } else {
                    $this.removeClass( 'fa-plus-square' ).addClass( 'fa-minus-square' );
                    
                    $table.find( 'tbody tr' ).each(function() {
                        var sub=datatable.fnGetData( this );
                        if(sub.parent_id==main.id)
                            $(this).css({"display": ""});
                    });
                }
            });
        };

        $(function() {
            datatableInit();
        });
    });
</script>