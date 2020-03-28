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
        
                                        <h4 class="mt-0 header-title">Objective Rating</h4>
                                        <a href="{{url('admin/report')}}"><button type="button" class="btn btn-outline-primary waves-effect waves-light"  style="display:inline-block; float:right;"><i class="mdi mdi-keyboard-return"></i>&nbsp;  Return</button>
                                </a>
                                        <canvas id="bar" height="500"></canvas>
        
                                    </div>
                                </div>

                </div> <!-- end col -->

            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div> <!-- content -->
    



<!-- /.content-wrapper -->
@include('template.footer')

<script>

$(function(){
        $.ajax({
            url: '{{url("admin/get_chart_value")}}',
            //url:"",
            type: 'POST',
            data: {                         
                       
              },  
            async:false,
            success: function (data, status, xhr) {
                var data = JSON.parse(data)
                    var ChartJs = function() {};

                    ChartJs.prototype.respChart = function(selector,type,data, options) {
                        // get selector by context
                        var ctx = selector.get(0).getContext("2d");
                        // pointing parent container to make chart js inherit its width
                        var container = $(selector).parent();

                        // enable resizing matter
                        $(window).resize( generateChart );

                        // this function produce the responsive Chart JS
                        function generateChart(){
                            // make chart width fit with its container
                            var ww = selector.attr('width', $(container).width() );
                            switch(type){
                                
                                case 'Bar':
                                    new Chart(ctx, {type: 'bar', data: data, options: options});
                                    break;
                            }
                            // Initiate new chart or Redraw

                        };
                        // run function - render chart at first load
                        generateChart();
                    },
                    //init
                    ChartJs.prototype.init = function() {
                      
                        //barchart
                        var barChart = {
                            labels: data.name,
                            
                            datasets: [
                                {
                                    label: "Rating",
                                    backgroundColor: "#28bbe3",
                                    borderColor: "#28bbe3",
                                    borderWidth: 1,
                                    hoverBackgroundColor: "#28bbe3",
                                    hoverBorderColor: "#28bbe3",
                                    data: data.rate
                                }
                            ]
                        };
                        var barOpts = {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        max: 5,
                                        min: 0,
                                        stepSize: 1
                                    }
                                }]
                            }
                        };
                        this.respChart($("#bar"),'Bar',barChart,barOpts );
                    },
                    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs
                    $.ChartJs.init()
                    },
            error: function(){ 
            
            }
        });
});

</script>

