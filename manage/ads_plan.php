<!DOCTYPE html>
<html lang="en">
  <?php  include 'includes/head.php'; ?>
  
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
         <div class="left_col scroll-view">
           <?php include 'includes/nav_left.php'; ?>
          </div>
        </div>

        <!-- top navigation -->
        <?php 
          include 'includes/top_nav.php';
          ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

                <!-- Middle Content Start -->
    
    <div class="vd_content-wrapper">
      <div class="vd_container">
        <div class="vd_content clearfix">
          <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
              <ul class="breadcrumb">
                <li><a href="index.php">Home</a> </li>
                <li>Ads Plan</li>
              </ul>
            </div>
          </div>
          
   <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'AddPlan') 
        {
        include 'views/includes/add_plans.php';
        }
        else if($link==='ViewAdsPlan')
        {
        include 'views/includes/ViewAdsPlan.php';
         }
        else if($link==='approve_ads_plan')
        {
        include 'views/includes/approve_ads_plan.php';
        }
        else if($link==='deactivate_ads_plan')
        {
           include 'views/includes/deactivate_ads_plan.php';
        }
       // else if ($link === 'deactivate') 
       // {
        //    include 'views/includes/deactivatesales.php';
       // }
      
    } 
 ?>

        </div>
      </div>
    </div>
    
          </div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        
       <?php include 'includes/footer.php'; ?>
        <!-- /footer content -->
      </div>
    </div>
  </body>
</html>
