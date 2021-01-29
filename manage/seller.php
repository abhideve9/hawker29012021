<!DOCTYPE html>
<html lang="en">
  <?php  include 'includes/head.php'; ?>
  <link rel="stylesheet" type="text/css" href="lightbox.min.css">
  <link href="css/fSelect.css" rel="stylesheet">
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
                <li>Seller</li>
              </ul>
            </div>
          </div>
          
   <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'ListingSeller') 
        {
            include 'views/includes/listingseller.php';
        }
        else if($link==='activeseller')
        {
          include 'views/includes/activeseller.php';
        }
        else if($link==='seller_user_referral')
        {
          include 'views/includes/seller_user_referral.php';
        }
        else if($link==='activeseller_image')
        {
           include 'views/includes/activeseller_image.php';
        }

        else if($link==='activeseller_image&&page')
        {
           include 'views/includes/activeseller_image.php';
        }
        else if($link==='rejectseller')
        {
           include 'views/includes/rejectseller.php';
        }
        else if($link==='AddSubCat')
        {
           include 'views/includes/addsubcat.php';
        }
        else if ($link === 'ActiveSubCat') 
        {
            include 'views/includes/activesubcat.php';
        }
        else if ($link === 'Listingseller_location') 
        {
          include 'views/includes/Listingseller_location.php';
        }
      
    } 
 ?>

        </div>
      </div>
    </div>
    
          </div>
        </div>
        <script src="lightbox-plus-jquery.min.js"></script>
        <!-- /page content -->
        <!-- footer content -->
       <?php include 'includes/footer.php'; ?>
        <!-- /footer content -->
      </div>
    </div>
  </body>
</html>
