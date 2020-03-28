@include('template.header')
@include('template.sidebar')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
		
			<div class="container-fluid" style="padding-top:15px;">
		    	<div class="row">
					<div class="col-xl-6 col-md-6">
					<a href="{{ url('superadmin/profile') }}"> 
			            <div class="card mini-stat bg-primary">
			                <div class="card-body mini-stat-img">
			                    <div class="mini-stat-icon">
			                        <!-- <i class="mdi mdi-cube-outline float-right"></i> -->
			                        <i class="mdi mdi-account-multiple float-right"></i>
			                    </div>
			                    <div class="text-white">
			                        <h6 class="text-uppercase mb-3">Manage Admin</h6>
			                        <h4 class="mb-4">{{ isset($total_admin[0]->admin_num) ? $total_admin[0]->admin_num:'0'}}</h4>
			                        <!-- <span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span> -->
			                    </div>
			                </div>
			            </div>
			        </a>
			        </div>
			        <div class="col-xl-6 col-md-6">
			        <a href="{{ url('superadmin/membership') }}"> 
			            <div class="card mini-stat bg-primary">
			                <div class="card-body mini-stat-img">
			                    <div class="mini-stat-icon">
			                        <i class="mdi mdi-buffer float-right"></i>
			                    </div>
			                    <div class="text-white">
			                        <h6 class="text-uppercase mb-3">Manage Membership</h6>
			                        <h4 class="mb-4">{{ isset($total_membership[0]->membership_num) ? $total_membership[0]->membership_num:'0'}}</h4>
			                        <!-- <span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span> -->
			                    </div>
			                </div>
			            </div>
			        </a>
			        </div>
			    </div>
		    </div>

    </div> <!-- content -->

    
    

<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


@include('template.footer')  