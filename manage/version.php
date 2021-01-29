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
                <li> Version</li>
              </ul>
            </div>
          </div>
          
   <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'changeversion') 
        {
            include 'views/includes/changeversion.php';
        }
        else if($link==='showversion')
        {
          include 'views/includes/showversion.php';
        }
        else if($link==='showsales_version')
        {
           include 'views/includes/showsales_version.php';
        }
        else if($link==='change_sales_version')
        {
           include 'views/includes/change_sales_version.php';
        }
        else if ($link === 'deactivate') 
        {
            include 'views/includes/deactivatesales.php';
        }
        else if($link==='show_customer_version')
        {
          include 'views/includes/show_customer_version.php';
        }
        else if($link==='change_customer_version')
        {
           include 'views/includes/change_customer_version.php';
        }

      
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
