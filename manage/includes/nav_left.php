<?php
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
include 'db.php';
?>
  <div class="navbar nav_title" style="border: 0;">
              <a href="javascript:void(0)" class="site_title"><i class="fa fa-paw"></i> <span>Hawker</span></a>
            </div>
  <div class="clearfix"></div>

  <!-- menu profile quick info -->
  <div class="profile clearfix">
    <div class="profile_pic">
      <img src="images/img.jpg" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
      <span>Welcome</span>
        <?php 
        $getUsers="SELECT name FROM admin where status='1'";
        $runUsers=mysqli_query($db,$getUsers);
        $rowUsers=mysqli_fetch_array($runUsers);
        ?>
      <h2><?php echo $adminName;?></h2>
    </div>
  </div>
  <!-- /menu profile quick info -->
  <br />
 <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                   <li><a href="index.php"><i class="fa fa-laptop"></i>Home<span class="label label-success pull-right">Coming Soon</span></a></li>
                    <!-- <ul class="nav child_menu">
                      <li><a href="index.html">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul> -->
                    <li><a><i class="fa fa-binoculars"></i>Ads Plans<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       <li><a href="ads_plan.php?action=AddPlan">Add Ads Plan</a></li>
                       <li><a href="ads_plan.php?action=ViewAdsPlan">View Ads Plan</a></li>
                      <!-- <li><a href="advertisement.php?action=paid_advertisement">Paid Advertisement</a></li>-->
                       <!--<li><a href="action.php?action=show_productivity_report">ProductivityReport for Sales</a></li>-->
                    </ul>
                   </li>
                     <li><a><i class="fa fa-binoculars"></i>Paid Advertisement<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                      <li><a href="advertisement.php?action=paid_approve_advertisement">Approved Paid Advertisement</a></li>
                      <li><a href="advertisement.php?action=paid_pending_advertisement">Pending Paid Advertisement</a></li>
                      <li><a href="advertisement.php?action=Expired_paid_advertisement">Expired Paid Advertisement</a></li>
                      <li><a href="advertisement.php?action=Rejected_paid_advertisement">Rejected Paid Advertisement</a></li>

                   </ul>
                   </li>
                       <li><a><i class="fa fa-binoculars"></i>Free Advertisement<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="advertisement.php?action=free_approve_advertisement">Approved Free Advertisement</a></li>
                      <li><a href="advertisement.php?action=free_pending_advertisement">Pending Free Advertisement</a></li>
                      <li><a href="advertisement.php?action=Expired_free_advertisement">Expired Free Advertisement</a></li>
                      <li><a href="advertisement.php?action=Rejected_free_advertisement">Rejected Free Advertisement</a></li>
                       <!--<li><a href="advertisement.php?action=paid_advertisement">Paid Advertisement</a></li>-->
                       <!--<li><a href="action.php?action=show_productivity_report">ProductivityReport for Sales</a></li>-->
                    </ul>
                   </li>
                   <li><a><i class="fa fa-binoculars"></i>Redeem Requests<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       <!--<li><a href="redeem.php?action=view_redeem_request">All Redeem Requests</a></li>-->
                       <li><a href="redeem.php?action=approved_redeem_requests">Approved Redeem Requests</a></li>
                       <li><a href="redeem.php?action=pending_redeem_request">Pending Redeem Requests</a></li>
                       <li><a href="redeem.php?action=view_refer_earn_list">Refer & Earn list</a></li>
                       <!--<li><a href="advertisement.php?action=paid_advertisement">Paid Advertisement</a></li>-->
                       <!--<li><a href="action.php?action=show_productivity_report">ProductivityReport for Sales</a></li>-->
                    </ul>
                   </li>
                     <li><a><i class="fa fa-binoculars"></i>Sales Report <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       <li><a href="action.php?action=show_reports">City Wise Sales Report</a></li>
                       <li><a href="action.php?action=show_attendence_report">Attendence Report for Sales</a></li>
                        <li><a href="action.php?action=show_productivity_report">ProductivityReport for Sales</a></li>
                    </ul>
                   </li>
                   <li><a><i class="fa fa-binoculars"></i>Sales Report On Map<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="mappeds.php">All Sales Person</a></li>
                       <li><a href="action.php?action=show_mapped">Report for Particular Sales</a></li>
                    </ul>
                   </li>
                  <li><a><i class="fa fa-user"></i>Sales Users<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="sales.php?action=AddSale">Add Sales Users</a></li>
                      <li><a href="sales.php?action=Activesales">Active Sales User</a></li>
                    </ul>
                   </li>


                    <li><a><i class="fa fa-shopping-basket"></i>Category<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="category.php?action=AddCategory">Add New Category</a></li>
                      <li><a href="category.php?action=ActiveCategory">Active Category</a></li>
                    </ul>
                   </li>

                   <li><a><i class="fa fa-shopping-basket"></i>Sub Category<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="category.php?action=AddSubCat">Add New Sub Category</a></li>
                      <li><a href="category.php?action=ActiveSubCat">Active Sub Category</a></li>
                    </ul>
                   </li>
                    <li><a><i class="fa fa-shopping-basket"></i>Super Sub Category<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="category.php?action=AddSupersubcat">Add New Super Sub Category</a></li>
                      <li><a href="category.php?action=ActiveSupersubcat">Active Super Sub Category</a></li>
                    </ul>
                   </li>
                   <li><a><i class="fa fa-shopping-basket"></i>Level for Sales<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="level.php?action=categorylevel">Change Category Level</a></li>
                    </ul>
                  </li>

                   <li><a><i class="fa fa-shopping-basket"></i>Level for Customer<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="level.php?action=category_level_for_customer">Change Category Level</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-user"></i>Seller Users<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="seller.php?action=seller_user_referral">Seller User for Referral</a></li>
                      <li><a href="seller.php?action=ListingSeller">Seller User Listing</a></li>
                      <li><a href="seller.php?action=activeseller">Active Seller</a></li>
                      <li><a href="seller.php?action=activeseller_image">Active Seller Image</a></li>
                      <li><a href="seller.php?action=rejectseller">Rejected Seller</a></li>
                    </ul>
                   </li>

                  <li><a><i class="fa fa-user"></i>Hawker User location <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="seller.php?action=Listingseller_location">Hawker User Location</a></li>
                    </ul>
                   </li>


                  <li><a><i class="fa fa-rocket"></i>Hawkers Type<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="hawker.php?action=addhawkertype">Add Hawkers Type</a></li>
                      <li><a href="hawker.php?action=ActiveHawkerType">Active Hawkers Type</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-rocket"></i>Hawker App Action<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="action.php?action=addaction">Add Action</a></li>
                      <li><a href="action.php?action=activeaction">Active All Action</a></li>
                    </ul>
                  </li>

                    <li><a><i class="fa fa-binoculars"></i>Hawker State<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="state.php?action=addstate">Add State</a></li>
                      <li><a href="state.php?action=activestate">Active All State</a></li>
                    </ul>
                  </li>


                   <li><a><i class="fa fa-binoculars"></i>Hawker City<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     <!--  <li><a href="hawker.php?action=AddSale">Add Sales Users</a></li> -->
                      <li><a href="city.php?action=Activecity">Active city for  User</a></li>
                    </ul>
                   </li>

                   <li><a><i class="fa fa-binoculars"></i>sales Version<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="version.php?action=showsales_version">Chnage Version </a></li>
                    </ul>
                   </li>

                   <li><a><i class="fa fa-binoculars"></i>Hawker Version<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="version.php?action=showversion">Change Version </a></li>
                    </ul>
                   </li>

                   <li><a><i class="fa fa-binoculars"></i>Customer Version<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="version.php?action=show_customer_version">Change Version </a></li>
                    </ul>
                   </li>
                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
             <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
