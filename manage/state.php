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
                <li>State</li>
              </ul>
            </div>
          </div>
          
    <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'addstate') 
        {
            include 'views/includes/addstate.php';
        }
        else if($link==='activestate')
        {
          include 'views/includes/activestate.php';
        }
        else if($link==='editstate')
        {
          include 'views/includes/editstate.php';
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
