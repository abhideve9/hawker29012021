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
                <li>Action</li>
              </ul>
            </div>
          </div>
          
    <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'addaction') 
        {
            include 'views/includes/addaction.php';
        }
        else if($link==='activeaction')
        {
          include 'views/includes/activeaction.php';
        }
        else  if($link=='editdata')
        {
          include 'views/includes/editaction.php';
        }
        else  if($link=='show_mapped')
        {
          include 'views/includes/show_mapped.php';
        }
        else  if($link=='show_reports')
        {
          include 'views/includes/show_reports.php';
        }
        else if($link=='show_all_reports')
        {
          include 'views/includes/show_all_reports.php';
        }

        else if($link=='show_attendence_report')
        {
          include 'views/includes/show_attendence_report.php';
        }

        else if($link=='show_productivity_report')
        {
          include 'views/includes/show_productivity_report.php';
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
