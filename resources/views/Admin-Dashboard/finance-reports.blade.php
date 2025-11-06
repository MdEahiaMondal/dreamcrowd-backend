<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/admin/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/admin/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/admin/asset/css/bootstrap.min.css"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
    <!-- Fontawesome CDN -->
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <!-- GRAPH LINKS -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css"></script>
    <script src="ttps://cdn.jsdhelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Teko"
    />
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/finance-table.css">
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Google Analytics</title>
  </head>
  <style>
    .button {
      color: #0072b1 !important;
    }
  </style>
  <body>
     {{-- ===========Admin Sidebar Start==================== --}}
     <x-admin-sidebar/>
     {{-- ===========Admin Sidebar End==================== --}}
     <section class="home-section">
        {{-- ===========Admin NavBar Start==================== --}}
        <x-admin-nav/>
        {{-- ===========Admin NavBar End==================== --}}
      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row dash-notification">
          <div class="col-md-12">
            <div class="dash">
              <div class="row">
                <div class="col-md-12">
                  <div class="dash-top">
                    <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Finance & Reports</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-bar-chart-alt"></i>
                      <h2>Finance & Reports</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="finance-heading">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <h2>Finance Reports</h2>
                      <span>(Graph)</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <!-- Filter Date Section -->
          
              <div class="container-fluid graph-chart">
                <br />
                <div class="row">
                  <!-- <div class="col-md-1"></div> -->
                  <div class="col-md-12">
                    <div class="date-sections">
                      <div class="row">
                        <div class="col-md-12">
                          <h1 class="new-revenue-text">DreamCrowd New Revenue (£)</h1>
                          <div class="user-all-seller-drop seller-drop">
                            
                            <!-- first drop dawon  -->
                            <form>
                              <div class="row align-items-center calendar-sec">
                                <div class="col-auto date-selection">
                                  <div class="date-sec section-date">
                                   
                                    <select class="form-selected" id="dateFilter" style="border: none;">
                                      <option value="today">Dreamcrowd New Revenue (£)</option>
                                      <option value="yesterday">Refund Transections</option>
                                      <option value="today">Refund Amount</option>
                                      <option value="today">Sales After Refunds</option>
                                      <option value="today">DreamCrowd Revenue</option>
                                      <option value="lastMonth">Revenue Transection</option>
                                      <option value="custom">Buyer to Seller Ratio</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </form>
                             <!-- Filter Date Section -->
                             <div class="">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="user-all-seller-drop seller-drop">
                                    <!-- second drop down -->
                                    <form>
                                      <div class="row align-items-center calendar-sec">
                                        <div class="col-auto date-selection">
                                          <div class="date-sec">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <select class="form-select" id="dateFilter2">
                                              <option value="today">2001</option>
                                              <option value="yesterday">2002</option>
                                              <option value="lastWeek">2003</option>
                                              <option value="last7Days">2004</option>
                                              <option value="lifetime">2005</option>
                                              <option value="lastMonth">2006</option>
                                              <option value="year">2008</option>
                                              <option value="year">2009</option>
                                              <option value="year">2010</option>
                                              <option value="year">2011</option>
                                              <option value="year">2012</option>
                                              <option value="year">2013</option>

                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-auto" id="fromDateFields2" style="display: none">
                                          <div class="row">
                                            <label for="fromDate2" class="col-sm-3 col-form-label">From:</label>
                                            <div class="col-sm-9">
                                              <input type="date" class="form-control" id="fromDate2" />
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-auto" id="toDateFields2" style="display: none">
                                          <div class="row">
                                            <label for="toDate2" class="col-sm-2 col-form-label">To:</label>
                                            <div class="col-sm-10">
                                              <input type="date" class="form-control" id="toDate2" />
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                    </div>
                  </div>
                </div>
              </div>
                              </div>
                            </form>
                            <!-- Chart.js Canvas Tag -->
                    <canvas id="multiLineChart"></canvas>
                  </div>
                  <div class="col-md-1"></div>
                          </div>
                         
                        </div>
                        <div class="finance-heading">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="notify">
                                <h2>Finance Reports</h2>
                                <span>(Table)</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="finance-date-section">
                          <div class="row">
                            <div class="col-md-12">
                              <h1 class="new-revenue-text">DreamCrowd New Revenue (£)</h1>
                              <div class="user-all-seller-drop seller-drop">
                                <!-- first drop dawon  -->
                                <form>
                                  <div class="row align-items-center calendar-sec">
                                    <div class="col-auto date-selection">
                                      <div class="date-sec section-date">
                                       
                                        <select class="form-selected" id="dateFilter" style="border: none;">
                                          <option value="today">Dreamcrowd New Revenue (£)</option>
                                          <option value="yesterday">Refund Transections</option>
                                          <option value="today">Refund Amount</option>
                                          <option value="today">Sales After Refunds</option>
                                          <option value="today">DreamCrowd Revenue</option>
                                          <option value="lastMonth">Revenue Transection</option>
                                          <option value="custom">Buyer to Seller Ratio</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </form>
                                 <!-- Filter Date Section -->
                                 <div class="">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="user-all-seller-drop seller-drop">
                                        <!-- first drop down -->
                                        <form>
                                          <div class="row align-items-center calendar-sec">
                                            <div class="col-auto date-selection">
                                              <div class="date-sec">
                                                <i class="fa-solid fa-calendar-days"></i>
                                                <select class="form-select" id="dateFilter1">
                                                  <option value="today">2001</option>
                                              <option value="yesterday">2002</option>
                                              <option value="lastWeek">2003</option>
                                              <option value="last7Days">2004</option>
                                              <option value="lifetime">2005</option>
                                              <option value="lastMonth">2006</option>
                                              <option value="year">2008</option>
                                              <option value="year">2009</option>
                                              <option value="year">2010</option>
                                              <option value="year">2011</option>
                                              <option value="year">2012</option>
                                              <option value="year">2013</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="col-auto" id="fromDateFields1" style="display: none">
                                              <div class="row">
                                                <label for="fromDate1" class="col-sm-3 col-form-label">From:</label>
                                                <div class="col-sm-9">
                                                  <input type="date" class="form-control" id="fromDate1" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-auto" id="toDateFields1" style="display: none">
                                              <div class="row">
                                                <label for="toDate1" class="col-sm-2 col-form-label">To:</label>
                                                <div class="col-sm-10">
                                                  <input type="date" class="form-control" id="toDate1" />
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="finance-table">
                          <table>
                              <thead>
                                  <tr>
                                      <th class="sticky-col" style="padding: 12px 140px; background: var(--Colors-White, #FFF);" ></th>
                                      <th>January</th>
                                      <th>February</th>
                                      <th>March</th>
                                      <th>April</th>
                                      <th>May</th>
                                      <th>June</th>
                                      <th>July</th>
                                      <th>August</th>
                                      <th>September</th>
                                      <th>October</th>
                                      <th>November</th>
                                      <th>December</th>
                                    
                                  </tr>
                              </thead>
                              <tbody>
                                  
                                  <tr>
                                    <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                                    background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">GMV Sales (£)</td>
                                    <td >£ 492.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                                    <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 492.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                                    <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                                    <td >£ 492.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                                    <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                                    <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                                </tr>
                                <tr>
                                  <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                                  background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">GMV Growth MoM (%)</td>
                                  <td >79.48% <span class="badge service-class">60%</span></td>
                                  <td >51.34% <span class="percentage-badge">60%</span></td>
                                  <td >67.42% <span class="badge service-class">60%</span></td>
                                  <td >78.14% <span class="badge service-class">60%</span></td>
                                  <td >54.02% <span class="badge service-class">60%</span></td>
                                  <td >62.06% <span class="percentage-badge">60%</span></td>
                                  <td >68.76% <span class="badge service-class">60%</span></td>
                                  <td >52.68% <span class="badge service-class">60%</span></td>
                                  <td >71.44% <span class="percentage-badge">60%</span></td>
                                  <td >56.70% <span class="badge service-class">60%</span></td>
                                  <td >70.10% <span class="badge service-class">60%</span></td>
                                  <td >75.46% <span class="percentage-badge">60%</span></td>
                              </tr>
                              <tr>
                                <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                                background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">GMV Transactions</td>
                               <td >£ 492.00 <span class="badge service-class">60%</span></td>
                               <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                               <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                               <td >£ 492.00 <span class="badge service-class">60%</span></td>
                               <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                               <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                               <td >£ 492.00 <span class="badge service-class">60%</span></td>
                               <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                               <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                               <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                               <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                               <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                            </tr>
                            <tr>
                              <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                              background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">DreamCrowd Old Revenue</td>
                           <td >£ 492.00 <span class="badge service-class">60%</span></td>
                           <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                           <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                           <td >£ 492.00 <span class="badge service-class">60%</span></td>
                           <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                           <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                           <td >£ 492.00 <span class="badge service-class">60%</span></td>
                           <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                           <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                           <td >£ 492.00  <span class="percentage-badge">60%</span></td></td>
                           <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                           <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                          </tr>
                                  <tr>
                                      <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                                      background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Old Revenue Growth MoM (%)</td>
                                  <td >79.48% <span class="badge service-class">60%</span></td>
                                  <td >51.34% <span class="percentage-badge">60%</span></td>
                                  <td >67.42% <span class="badge service-class">60%</span></td>
                                  <td >78.14% <span class="badge service-class">60%</span></td>
                                  <td >54.02% <span class="badge service-class">60%</span></td>
                                  <td >62.06% <span class="percentage-badge">60%</span></td>
                                  <td >68.76% <span class="badge service-class">60%</span></td>
                                  <td >52.68% <span class="badge service-class">60%</span></td>
                                  <td >71.44% <span class="percentage-badge">60%</span></td>
                                  <td >56.70% <span class="badge service-class">60%</span></td>
                                  <td >70.10% <span class="badge service-class">60%</span></td>
                                  <td >75.46% <span class="percentage-badge">60%</span></td>
                                  </tr>
                                  <tr>
                                    <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                                    background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Refunded Transactions</td>
                                 <td >£ 492.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                                 <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 492.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                                 <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                                 <td >£ 492.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                                 <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                                 <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                                </tr>
                                <tr>
                                  <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF); background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Refund amounts (£)</td>
                             <td >£ 492.00    <span class="badge service-class">60%</span>   </td>
                             <td >£ 2,800.00  <span class="percentage-badge">60%</span>      </td>
                             <td >£ 2,308.00  <span class="badge service-class">60%</span>   </td>
                             <td >£ 492.00    <span class="badge service-class">60%</span>   </td>
                             <td >£ 8,000.00  <span class="percentage-badge">60%</span>      </td>
                             <td >£ 2,308.00  <span class="percentage-badge">60%</span>      </td>
                             <td >£ 492.00    <span class="badge service-class">60%</span>   </td>
                             <td >£ 8,000.00  <span class="badge service-class">60%</span>   </td>
                             <td >£ 2,308.00  <span class="badge service-class">60%</span>   </td>
                             <td >£ 492.00    <span class="percentage-badge">60%</span>      </td>
                             <td >£ 2,800.00  <span class="badge service-class">60%</span>   </td>
                             <td >£ 492.00    <span class="percentage-badge">60%</span>      </td>
                              </tr>
                              <tr>
                                <td class="sticky-col" style="padding: 20px 20px;
                                background: var(--Colors-Logo-Color, #fff);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */"></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                            </tr>
                            <tr>
                              <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                              background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">GMV After Refund (£)</td>
                              <td >£ 492.00 <span class="badge service-class">60%</span></td>
                              <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                              <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                              <td >£ 492.00 <span class="badge service-class">60%</span></td>
                              <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                              <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                              <td >£ 492.00 <span class="badge service-class">60%</span></td>
                              <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                              <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                              <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                              <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                              <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                          </tr>
                          <tr>
                            <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                            background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">GMV Growth MoM (%)</td>
                            <td >£ 492.00 <span class="badge service-class">60%</span></td>
                            <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                            <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                            <td >£ 492.00 <span class="badge service-class">60%</span></td>
                            <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                            <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                            <td >£ 492.00 <span class="badge service-class">60%</span></td>
                            <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                            <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                            <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                            <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                            <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                        </tr>
                        <tr>
                          <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                          background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">GMV Transactions</td>
                      <td >79.48% <span class="badge service-class">60%</span></td>
                      <td >51.34% <span class="percentage-badge">60%</span></td>
                      <td >67.42% <span class="badge service-class">60%</span></td>
                      <td >78.14% <span class="badge service-class">60%</span></td>
                      <td >54.02% <span class="badge service-class">60%</span></td>
                      <td >62.06% <span class="percentage-badge">60%</span></td>
                      <td >68.76% <span class="badge service-class">60%</span></td>
                      <td >52.68% <span class="badge service-class">60%</span></td>
                      <td >71.44% <span class="percentage-badge">60%</span></td>
                      <td >56.70% <span class="badge service-class">60%</span></td>
                      <td >70.10% <span class="badge service-class">60%</span></td>
                      <td >75.46% <span class="percentage-badge">60%</span></td>
                      </tr>
                      <tr>
                        <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                        background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">DreamCrowd New Revenue (£)</td>
                    <td >79.48% <span class="badge service-class">60%</span></td>
                    <td >51.34% <span class="percentage-badge">60%</span></td>
                    <td >67.42% <span class="badge service-class">60%</span></td>
                    <td >78.14% <span class="badge service-class">60%</span></td>
                    <td >54.02% <span class="badge service-class">60%</span></td>
                    <td >62.06% <span class="percentage-badge">60%</span></td>
                    <td >68.76% <span class="badge service-class">60%</span></td>
                    <td >52.68% <span class="badge service-class">60%</span></td>
                    <td >71.44% <span class="percentage-badge">60%</span></td>
                    <td >56.70% <span class="badge service-class">60%</span></td>
                    <td >70.10% <span class="badge service-class">60%</span></td>
                    <td >75.46% <span class="percentage-badge">60%</span></td>
                    </tr>
                    <tr>
                      <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                      background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Revenue Growth MoM (%)</td>
                   <td >£ 492.00 <span class="badge service-class">60%</span></td>
                   <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                   <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                   <td >£ 492.00 <span class="badge service-class">60%</span></td>
                   <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                   <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                   <td >£ 492.00 <span class="badge service-class">60%</span></td>
                   <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                   <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                   <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                   <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                   <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                  </tr>
                  <tr>
                    <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                    background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Revenue Transaction</td>
                 <td >£ 492.00 <span class="badge service-class">60%</span></td>
                 <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
                 <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                 <td >£ 492.00 <span class="badge service-class">60%</span></td>
                 <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
                 <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
                 <td >£ 492.00 <span class="badge service-class">60%</span></td>
                 <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
                 <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
                 <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                 <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
                 <td >£ 492.00  <span class="percentage-badge">60%</span></td>
                </tr>
                <tr>
                  <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                  background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Average Order Value (£)</td>
              <td >79.48% <span class="badge service-class">60%</span></td>
              <td >51.34% <span class="percentage-badge">60%</span></td>
              <td >67.42% <span class="badge service-class">60%</span></td>
              <td >78.14% <span class="badge service-class">60%</span></td>
              <td >54.02% <span class="badge service-class">60%</span></td>
              <td >62.06% <span class="percentage-badge">60%</span></td>
              <td >68.76% <span class="badge service-class">60%</span></td>
              <td >52.68% <span class="badge service-class">60%</span></td>
              <td >71.44% <span class="percentage-badge">60%</span></td>
              <td >56.70% <span class="badge service-class">60%</span></td>
              <td >70.10% <span class="badge service-class">60%</span></td>
              <td >75.46% <span class="percentage-badge">60%</span></td>
              </tr>
              <tr>
                <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
                background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Total Buyers</td>
             <td >£ 492.00 <span class="badge service-class">60%</span></td>
             <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
             <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
             <td >£ 492.00 <span class="badge service-class">60%</span></td>
             <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
             <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
             <td >£ 492.00 <span class="badge service-class">60%</span></td>
             <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
             <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
             <td >£ 492.00  <span class="percentage-badge">60%</span></td>
             <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
             <td >£ 492.00  <span class="percentage-badge">60%</span></td>
            </tr>
            <tr>
              <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
              background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Total Sellers</td>
           <td >£ 492.00 <span class="badge service-class">60%</span></td>
           <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
           <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
           <td >£ 492.00 <span class="badge service-class">60%</span></td>
           <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
           <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
           <td >£ 492.00 <span class="badge service-class">60%</span></td>
           <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
           <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
           <td >£ 492.00  <span class="percentage-badge">60%</span></td>
           <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
           <td >£ 492.00  <span class="percentage-badge">60%</span></td>
          </tr>
          <tr>
            <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
            background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Total Buyer Loss</td>
          <td >£ 492.00 <span class="badge service-class">60%</span></td>
          <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
          <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
          <td >£ 492.00 <span class="badge service-class">60%</span></td>
          <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
          <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
          <td >£ 492.00 <span class="badge service-class">60%</span></td>
          <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
          <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
          <td >£ 492.00  <span class="percentage-badge">60%</span></td>
          <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
          <td >£ 492.00  <span class="percentage-badge">60%</span></td>
          </tr>
          <tr>
            <td class="sticky-col" style="border-bottom: 1px solid var(--Colors-White, #FFF);
            background: var(--Colors-Logo-Color, #0072B1);color: var(--Colors-White, #FFF);font-family: Roboto;font-size: 14px;font-weight: 500;line-height: 20px; /* 142.857% */">Total Seller Loss</td>
          <td >£ 492.00 <span class="badge service-class">60%</span></td>
          <td >£ 2,800.00  <span class="percentage-badge">60%</span></td>
          <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
          <td >£ 492.00 <span class="badge service-class">60%</span></td>
          <td >£ 8,000.00   <span class="percentage-badge">60%</span></td>
          <td >£ 2,308.00  <span class="percentage-badge">60%</span></td>
          <td >£ 492.00 <span class="badge service-class">60%</span></td>
          <td >£ 8,000.00 <span class="badge service-class">60%</span></td>
          <td >£ 2,308.00 <span class="badge service-class">60%</span></td>
          <td >£ 492.00  <span class="percentage-badge">60%</span></td>
          <td >£ 2,800.00 <span class="badge service-class">60%</span></td>
          <td >£ 492.00  <span class="percentage-badge">60%</span></td>
          </tr>
                                  <!-- Add more rows as needed -->
                              </tbody>
                          </table>
                      </div>
                      </div>                      
                    </div>          
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
    </section>
    <script src="assets/admin/libs/jquery/jquery.js"></script>
    <script src="assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/admin/libs/aos/js/aos.js"></script>
    <script src="assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="assets/admin/asset/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.5.1/snap.svg-min.js"></script>
  </body>
</html>
<!-- responsive graph script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const data = [
      { id: "sales-growth-svg", percentage: 45 },
      { id: "saf-growth-svg", percentage: 95 },
      { id: "revenue-growth-svg", percentage: 66 },
    ];

    data.forEach((item) => {
      const svg = d3
        .select(`#${item.id}`)
        .attr("viewBox", "0 0 100 100")
        .attr("preserveAspectRatio", "xMidYMid meet");

      const arc = d3
        .arc()
        .innerRadius(40)
        .outerRadius(50)
        .startAngle(0)
        .endAngle((item.percentage / 100) * 2 * Math.PI);

      const g = svg.append("g").attr("transform", "translate(50,50)");

      g.append("path").attr("d", arc).attr("fill", "blue");
    });
  });
</script>

<!-- =========================================== CHART & GRAPH SCRIPT ========================================================= -->
<script>
var canvas = document.getElementById("multiLineChart");
var ctx = canvas.getContext('2d');

  var data = {
    labels: ["January", "February", "March", "April", "May", 'June', 'July',' August', 'September', 'October', 'November', 'December'],
    datasets: [{
      label: "Uploaded",
      data: [110, 120, 125, 138, 152, 180, 210, 260, 284, 284, 300, 318],
      backgroundColor: 'rgba(0, 114, 177, 0.12)',
      borderColor: '#0072B1',
    }]
  };

    var options = {
      tooltips: {
       enabled: true, 
       mode: 'label'
     },
       legend: {
        display: false,
      }  
    };

// Chart declaration:
var multiLineChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: options
});
</script>

<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
