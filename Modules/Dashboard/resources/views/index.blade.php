@extends('admin.master')
@section('content')
<section class="dashboard-top-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="bg-white top-chart-earn">
                    <div class="row">
                        <div class="col-sm-4 my-2 pe-0">
                            <div class="last-month">
                                <h5>Dashboard</h5>
                                <p>Overview of Latest Month</p>

                                <div class="earn">
                                    <h2>$3367.98</h2>
                                    <p>Current Month Saler</p>
                                </div>
                                <div class="sale mb-3">
                                    <h2>95</h2>
                                    <p>Current Month Sales</p>
                                </div>
                                <a href="#" class="di-btn purple-gradient">Last Month Summary</a>
                            </div>
                        </div>

                        <div class="col-sm-8 my-2 ps-0">

                            <div class="classic-tabs">
                                <!-- Nav tabs -->
                                <div class="tabs-wrapper">
                                    <ul class="nav nav-tabs chart-header-tab mb-3" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="week-tab" data-bs-toggle="tab" data-bs-target="#week" type="button" role="tab" aria-controls="week" aria-selected="true">Week</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button" role="tab" aria-controls="month" aria-selected="false">Month</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year" type="button" role="tab" aria-controls="year" aria-selected="false">Year</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="week" role="tabpanel" aria-labelledby="week-tab">
                                            <div class="widget-content">
                                                <canvas id="chart"></canvas>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                                            Đang cập nhập ....
                                        </div>
                                        <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="year-tab">
                                            Đang cập nhập ....
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="wre-sec">
                        <div class="row">

                            <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                <div class="earn-view">
                                    <span class="fas fa-crown earn-icon wallet"></span>

                                    <div class="earn-view-text">
                                        <p class="name-text">
                                            Wallet Ballance
                                        </p>
                                        <h6 class="balance-text">
                                            $1684.54
                                        </h6>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                <div class="earn-view">
                                    <span class="fas fa-heart earn-icon referral"></span>

                                    <div class="earn-view-text">
                                        <p class="name-text">
                                            Referral Earning
                                        </p>
                                        <h6 class="balance-text">
                                            $1204.54
                                        </h6>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                <div class="earn-view">
                                    <span class="fab fa-salesforce earn-icon estimate"></span>

                                    <div class="earn-view-text">
                                        <p class="name-text">
                                            Estimate Sales
                                        </p>
                                        <h6 class="balance-text">
                                            $184.54
                                        </h6>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                <div class="earn-view">
                                    <span class="fas fa-chart-line earn-icon earning"></span>

                                    <div class="earn-view-text">
                                        <p class="name-text">
                                            Earning
                                        </p>
                                        <h6 class="balance-text">
                                            $16984.54
                                        </h6>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>




            </div>

            <div class="col-lg-4">
                <div class="bg-white top-chart-earn">
                    <div class="traffice-title">
                        <p>Traffuice</p>
                    </div>
                    <div class="traffice">
                        <div id="chart-2">
                            <canvas id="countries"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="sm-chart-sec my-5">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 sol-sm-6 my-2">
                   <div class="revinue revinue-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <span class="fas fa-users"></span>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">
                                        31.9k
                                    </p>
                                    <h5>Flollowers</h5>
                                </div>
                            </div>
                        </div>

                        <div class="revinue-content">
                            <div id="hybrid_followers">
                                <canvas id="followersChart"></canvas>
                            </div>
                        </div>

                   </div>
                </div>


                <div class="col-lg-3 col-md-6 sol-sm-6 my-2">
                    <div class="revinue page-one_hybrid">
                         <div class="revinue-hedding">
                             <div class="w-title">
                                 <div class="w-icon">
                                     <span class="fas fa-users"></span>
                                 </div>
                                 <div class="sm-chart-text">
                                     <p class="w-value">
                                         654k
                                     </p>
                                     <h5>Page view</h5>
                                 </div>
                             </div>
                         </div>

                         <div class="revinue-content">
                             <div id="hybrid_followers">
                                 <canvas id="followersChart2"></canvas>
                             </div>
                         </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 sol-sm-6 my-2">
                    <div class="revinue bonuce-one_hybrid">
                         <div class="revinue-hedding">
                             <div class="w-title">
                                <div class="w-icon">
                                     <span class="fas fa-users"></span>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">
                                        $432
                                    </p>
                                    <h5>Bonuce Rate</h5>
                                </div>
                             </div>
                         </div>

                         <div class="revinue-content">
                             <div id="hybrid_followers">
                                 <canvas id="followersChart3"></canvas>
                             </div>
                         </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 sol-sm-6 my-2">
                    <div class="revinue rv-status-one_hybrid">
                         <div class="revinue-hedding">
                             <div class="w-title">
                                <div class="w-icon">
                                     <span class="fas fa-users"></span>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">
                                        $765 <small>Jan 01 - Jan 10</small>
                                    </p>
                                    <h5> Revinue Status</h5>
                                </div>
                             </div>
                         </div>

                         <div class="revinue-content">
                             <div id="hybrid_followers">
                                 <canvas id="followersChart4"></canvas>
                             </div>
                         </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
</section>

<!-- === Admin show and order status table === -->
<section>
    <div class="all-admin my-5 ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="admin-list">
                        <p class="admin-ac-title">All Admin</p>
                        <ul class="admin-ul">
                            <li class="admin-li">
                                <img src="{{ asset('admin/images/cr7.jpg') }}" alt="" class="admin-image">
                                <div class="admin-ac-details">
                                    <div>
                                        <a href="#" class="admin-name">Cristiano Ronaldo</a>
                                        <p class="activaty-text">Active now</p>
                                    </div>
                                    <div class="status bg-success"></div>
                                </div>
                            </li>
                            <li class="admin-li">
                                <img src="{{ asset('admin/images/cr7.jpg') }}" alt="" class="admin-image">
                                <div class="admin-ac-details">
                                    <div>
                                        <a href="#" class="admin-name">Cristiano Ronaldo</a>
                                        <p class="activaty-text">Active now</p>
                                    </div>
                                    <div class="status bg-success"></div>
                                </div>
                            </li>
                            <li class="admin-li">
                                <img src="{{ asset('admin/images/cr7.jpg') }}" alt="" class="admin-image">
                                <div class="admin-ac-details">
                                    <div>
                                        <a href="#" class="admin-name">Cristiano Ronaldo</a>
                                        <p class="activaty-text">Active now</p>
                                    </div>
                                    <div class="status bg-success"></div>
                                </div>
                            </li>
                            <li class="admin-li">
                                <img src="{{ asset('admin/images/cr7.jpg') }}" alt="" class="admin-image">
                                <div class="admin-ac-details">
                                    <div>
                                        <a href="#" class="admin-name">Cristiano Ronaldo</a>
                                        <p class="activaty-text">Active now</p>
                                    </div>
                                    <div class="status bg-success"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 col-sm-6">
                    <div class="order-list">
                        <p class="order-ac-title">Order Status</p>

                        <div class="data-table-section table-responsive">
                            <table id="order-table" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody class="order-view-tb">
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011-04-25</td>
                                        <td>
                                            <a href="" class="status-tb-btn bg-cla">Success</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011-07-25</td>
                                        <td><a href="" class="status-tb-btn bg-clb">Open</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009-01-12</td>
                                        <td><a href="" class="status-tb-btn bg-clc">On Hold</a></td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012-03-29</td>
                                        <td>
                                            <a href="" class="status-tb-btn bg-cld">Checked</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008-11-28</td>
                                        <td><a href="" class="status-tb-btn bg-cla">Process</a></td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008-11-28</td>
                                        <td><a href="" class="status-tb-btn bg-clb">Open</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- === Admin show and order status table end=== -->

@endsection
@section('js')
<script src="{{ asset('admin/js/chart/chart.js') }}"></script>
@endsection
