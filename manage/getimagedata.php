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
  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Hawker<small>Users</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                     <div class="x_content table-responsive">
                      <table id="peopleindex" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                      
                      <thead>
                      <tr>
                      <th>Mobile Number</th>
                      <th>Profile Image</th>
                      <th>Identity Proof Image Front</th>
                      <th>Identity Proof Image Back</th>
                      <th>Shop Image1</th>
                       <th>Shop Image2</th>
                      
                     
                      </tr>
                      </thead>
                      <tbody>
                       <?php 
                    if(isset($_GET['mobileNumber']))
                    {
                    $mobileNumber=$_GET['mobileNumber'];
                    $getUsers1="SELECT * FROM registration_sellers_1 where mobile_no_contact='$mobileNumber' order by id limit 1";
                     $runUsers1=mysqli_query($db,$getUsers1);
                     while($rowUsers1=mysqli_fetch_array($runUsers1))
                     {
                      $sales_id=$rowUsers1['sales_id'];
                      $mobile_number=$rowUsers1['mobile_no_contact'];
                      $profile_image=$rowUsers1['profile_image'];
                      $aadhar_card_image=$rowUsers1['aadhar_card_image'];
                      $aadhar_card_image_back=$rowUsers1['aadhar_card_image_back'];
                      $shop_image_1=$rowUsers1['shop_image_1'];
                      $shop_image_2=$rowUsers1['shop_image_2'];
                     
                     ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $mobile_number; ?></td>

                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $profile_image; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $profile_image; ?>"/></a></td>

                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $aadhar_card_image; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $aadhar_card_image; ?>"/></a></td>

                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $aadhar_card_image_back; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $aadhar_card_image_back; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $shop_image_1; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $shop_image_1; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $shop_image_2; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $shop_image_2; ?>"/></a></td>
                        <!--  Pop Up model  -->
                        </tr>
                          <?php
                        }}
                        ?>   
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

        </div>
      </div>
    </div>
    <script>
 
   $(document)
    .ready(function () {
        $('#peopleindex').dataTable({

            "autoWidth": false,
            "lengthChange": false,
            "pageLength": 10,
               dom: 'Bfrtip',
              buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]

        });
});

</script>
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
