@include('template.header')
@include('template.sidebar')
<link rel="stylesheet" href="{{ URL::asset('assets/back/plugins/chartist/css/chartist.min.css')}}">

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
		
			<div class="container-fluid" style="padding-top:15px;">
		    	<div class="row">
					<div class="col-xl-6 col-md-6">
					<a href="{{ url('admin/manager') }}"> 
			            <div class="card mini-stat bg-primary">
			                <div class="card-body mini-stat-img">
			                    <div class="mini-stat-icon">
			                        <!-- <i class="mdi mdi-cube-outline float-right"></i> -->
			                        <i class="mdi mdi-account-multiple float-right"></i>
			                    </div>
			                    <div class="text-white">
			                        <h6 class="text-uppercase mb-3">Manage User</h6>
			                        <h4 class="mb-4">{{  isset($total_user) ? $total_user : '0' }}</h4>
			                        <!-- <span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span> -->
			                    </div>
			                </div>
			            </div>
			        </a>
			        </div>
			        <div class="col-xl-6 col-md-6">
			        <a href="{{ url('admin/objective') }}"> 
			            <div class="card mini-stat bg-primary">
			                <div class="card-body mini-stat-img">
			                    <div class="mini-stat-icon">
			                        <i class="mdi mdi-buffer float-right"></i>
			                    </div>
			                    <div class="text-white">
			                        <h6 class="text-uppercase mb-3">Manage Objective</h6>
			                        <h4 class="mb-4">{{ isset($total_objective[0]->objective_num) ? $total_objective[0]->objective_num:'0'}}</h4>
			                        <!-- <span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span> -->
			                    </div>
			                </div>
			            </div>
			        </a>
			        </div>
			        <div class="col-xl-6 col-md-6">
					<a href="{{ url('admin/schedule') }}"> 
			            <div class="card mini-stat bg-primary">
			                <div class="card-body mini-stat-img">
			                    <div class="mini-stat-icon">
			                        <!-- <i class="mdi mdi-cube-outline float-right"></i> -->
			                        <i class="mdi mdi-calendar-clock float-right"></i>
			                    </div>
			                    <div class="text-white">
			                        <h6 class="text-uppercase mb-3">Evaluation Schedule</h6>
			                        <h4 class="mb-4"></h4>
			                        <!-- <span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span> -->
			                    </div>
			                </div>
			            </div>
			        </a>
			        </div>
			        <div class="col-xl-6 col-md-6">
			        <a href="{{ url('admin/assign') }}"> 
			            <div class="card mini-stat bg-primary">
			                <div class="card-body mini-stat-img">
			                    <div class="mini-stat-icon">
			                        <i class="mdi mdi-table-edit float-right"></i>
			                    </div>
			                    <div class="text-white">
			                        <h6 class="text-uppercase mb-3">Performance View</h6>
			                        <h4 class="mb-4"></h4>
			                        <!-- <span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span> -->
			                    </div>
			                </div>
			            </div>
			        </a>
			        </div>
			    </div>
			    <div class="row">
                    <div class="col-lg-8">
                        <div class="card m-b-20">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Objective Performance</h4>
                                <br>
                                <br>
                                <br>
                                <br>
                                <table style="position:absolute;top:53px;left:34px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #7a6fbe;overflow:hidden"></div></div></td><td class="legendLabel">Target</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #28bbe3;overflow:hidden"></div></div></td><td class="legendLabel">Achieved</td></tr></tbody></table>

                                <div id="overlapping-bars" class="ct-chart ct-golden-section"></div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                <!-- </div>
				<div class="row"> -->
                	<div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Overall Rating</h4>
								<br>
                                <br>
                                <br>
                                <br>
                                <!-- <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                                    <li class="list-inline-item">
                                        <h5 class="mb-0">5484</h5>
                                        <p class="text-muted">Activated</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5 class="mb-0">964984</h5>
                                        <p class="text-muted">Pending</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5 class="mb-0">98498</h5>
                                        <p class="text-muted">Deactivated</p>
                                    </li>
                                </ul> -->

                                <div id="donut-chart">
                                    <div id="donut-chart-container" class="flot-chart flot-chart-height">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
               </div>

		    </div>


    </div> <!-- content -->

    
    
</div>

<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


@include('template.footer')  
<script src="{{ URL::asset('assets/back/plugins/chartist/js/chartist.min.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/chartist/js/chartist-plugin-tooltip.min.js')}}"></script>
 <script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.min.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.time.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.resize.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.pie.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.selection.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.stack.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/curvedLines.js')}}"></script>
<script src="{{ URL::asset('assets/back/plugins/flot-chart/jquery.flot.crosshair.js')}}"></script>

<script type="text/javascript">
$(function(){
	$.ajax({
            url: '{{url("admin/get_chart")}}',
            type: 'POST',
            data: {},  
            async:false,
            success: function (data, status, xhr) {
                var data1 = JSON.parse(data)	

				var data = {
				  labels: data1.name,
				  series: [
				    data1.target,
				    data1.achived
				  ]
				};

				var options = {
				  seriesBarDistance: 10
				};

				var responsiveOptions = [
				  ['screen and (max-width: 640px)', {
				    seriesBarDistance: 5,
				    axisX: {
				      labelInterpolationFnc: function (value) {
				        return value[0];
				      }
				    }
				  }]
				];
				new Chartist.Bar('#overlapping-bars', data, options, responsiveOptions);

				var FlotChart = function() {
			        this.$body = $("body")
			        this.$realData = []
			    };
			    FlotChart.prototype.createDonutGraph = function(selector, labels, datas, colors) {
			        var data = [{
			            label: labels[0],
			            data: datas[0]
			        }, {
			            label: labels[1],
			            data: datas[1]
			        }, {
			            label: labels[2],
			            data: datas[2]
			        },
			        {
			            label: labels[3],
			            data: datas[3]
			        }, {
			            label: labels[4],
			            data: datas[4]
			        }
			        ];
			        var options = {
			            series: {
			                pie: {
			                    show: true,
			                    innerRadius: 0.7
			                }
			            },
			            legend : {
							show : true,
							labelFormatter : function(label, series) {
								return '<div style="font-size:14px;">&nbsp;' + label + '</div>'
							},
							labelBoxBorderColor : null,
							margin : 40,
							width : 30,
							padding : 1
						},
						grid : {
							hoverable : true,
							clickable : true
						},
						colors : colors,
						tooltip : true,
						tooltipOpts : {
							content : "%s, %p.0%"
						}
			        };

			        $.plot($(selector), data, options);
			    },
			    FlotChart.prototype.init = function() {
		            //Donut pie graph data
		          var donutlabels = ["Rating 1","Rating 2","Rating 3","Rating 4","Rating 5"];
		          var donutdatas = data1.overall_rating;
		          var donutcolors = ['#f0f1f4', '#f5b225', '#29bbe3', '#58db83', '#e93c58'];
		          this.createDonutGraph("#donut-chart #donut-chart-container", donutlabels , donutdatas, donutcolors);
		        },

			    //init flotchart
			    $.FlotChart = new FlotChart, $.FlotChart.Constructor = FlotChart
			    $.FlotChart.init()
				},
            error: function(){ 
            
            }
        });
});


</script>