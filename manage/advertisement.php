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
                <li>Advertisement</li>
              </ul>
            </div>
          </div>
          
   <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'free_approve_advertisement') 
        {
            include 'views/includes/ViewFreeApprovedAdvertisement.php';
        }
        else if($link==='free_pending_advertisement')
       {
          include 'views/includes/ViewFreePendingAdvertisement.php';
       }
         else if($link==='paid_approve_advertisement')
       {
          include 'views/includes/ViewPaidApprovedAdvertisement.php';
       }
        else if($link==='paid_pending_advertisement')
       {
          include 'views/includes/ViewPaidPendingAdvertisement.php';
       }
        else if($link==='approve_free_advertisement')
        {
          include 'views/includes/approve_free_advertisement.php';
        }
       else if($link==='edit_free_advertisement')
       {
          include 'views/includes/edit_free_advertisement.php';
       }
        else if($link==='edit_free_advertisement1')
       {
          include 'views/includes/edit_free_advertisement1.php';
       }
        else if($link==='approve_paid_advertisement')
        {
           include 'views/includes/approve_paid_advertisement.php';
       }
        else if ($link === 'edit_paid_advertisement') 
        {
            include 'views/includes/edit_paid_advertisement.php';
        }
        else if ($link === 'edit_paid_advertisement1') 
        {
            include 'views/includes/edit_paid_advertisement1.php';
        }
        else if ($link === 'disapprove_paid_advertisement') 
        {
            include 'views/includes/disapprove_paid_advertisement.php';
        }
        else if ($link === 'disapprove_free_advertisement') 
        {
            include 'views/includes/disapprove_free_advertisement.php';
        }
        else if($link==='Expired_free_advertisement')
       {
          include 'views/includes/ViewExpiredFreeAdvertisement.php';
       }
        else if($link==='Expired_paid_advertisement')
       {
          include 'views/includes/ViewExpiredPaidAdvertisement.php';
       }
        else if($link==='Reject_free_advertisement')
       {
          include 'views/includes/reject_reason_free_advertisement.php';
       }
        else if($link==='Rejected_free_advertisement')
       {
          include 'views/includes/ViewFreeRejectedAdvertisement.php';
       }
         else if($link==='Reject_paid_advertisement')
       {
          include 'views/includes/reject_reason_paid_advertisement.php';
       }
        else if($link==='Rejected_paid_advertisement')
       {
          include 'views/includes/ViewPaidRejectedAdvertisement.php';
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
        <script src="lightbox-plus-jquery.min.js"></script>
       <?php include 'includes/footer.php'; ?>
        <!-- /footer content -->
      </div>
    </div>
  </body>
</html>
