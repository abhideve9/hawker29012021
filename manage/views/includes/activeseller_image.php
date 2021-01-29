<?php
error_reporting(0);
?>
<style type="text/css">
  .pagination1 a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination1 a.active {
  background-color: dodgerblue;
  color: white;
}
</style> 
<link href="bootstrap3.css" rel="stylesheet">  
<form method="GET" action="getimagedata.php" enctype="multipart/form-data">
     <div class="col-md-4">
     
          <table class="table table-bordered">
              <thead class="thead-light">
                 <tr>
                     <th>Search</th>
                     <th>Action</th>
                 </tr>
            </thead>
            <tbody>
            <tr>   
                    <td><input name="mobileNumber" class="form-control" type="text" placeholder="Search" aria-label="Search">
                    </td>
                   <td><input  type="submit" id="sendNewSms1" name="submit" value="Submit"/></td>
                
            </tr>
         </tbody>
      </table>
     </div>
     </form> 
<!-- page content -->
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
                  <?php
                 $showRecordPerPage = 10;
                  if (isset($_GET["page"]))
                  {
                $currentPage  = $_GET["page"];
                    }
                  else 
                  {
                   $currentPage=1; 
                 };  
               $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
               
                $sql = "SELECT * FROM registration_sellers_1 LIMIT $startFrom, $showRecordPerPage";  
                  $rs_result = mysqli_query($db, $sql); 
                  ?>
                  <div class="x_content">
                      <table class="table table-bordered table-striped">  
                     
                      
                      <thead>
                      <tr>
                    <!--   <th>Name</th>
                      <th>Date</th>
                      <th>Hawker Type</th>
                      <th>Business Name</th> -->
                      <th>Mobile Number</th>
                      <th>Profile Image</th>
                      <th>Identity Proof Image Front</th>
                      <th>Identity Proof Image Back</th>
                      <th>Shop Image_1</th>
                      <th>Shop Image_2</th>

                     
                     
                      </tr>
                      </thead>
                      <tbody>
                       <?php 
                     while($rowUsers=mysqli_fetch_array($rs_result))
                     {
                     $id=$rowUsers['id'];
/*                     $sales_id=$rowUsers['sales_id'];
                     $Name=$rowUsers['name'];
                     $Hawker_type=$rowUsers['user_type'];
                     $HawkerCode=$rowUsers['hawker_code'];
                     $mobile_number=$rowUsers['mobile_no_contact'];
                     $business_name=$rowUsers['business_name'];
                     $city_address=$rowUsers['city_address'];
                     $shop_id=$rowUsers['shop_id'];
                     $duty_status=$rowUsers['duty_status'];
                     $registered_time=$rowUsers['registered_time'];
                     $adhar_image_validation_status=$rowUsers['adhar_image_validation_status'];
                     $shop_image_validation_status=$rowUsers['shop_image_validation_status'];*/

                  /*  $getUsers1="SELECT profile_image,aadhar_card_image,aadhar_card_image_back,shop_image_1,shop_image_2 FROM registration_sellers_1 where mobile_no_contact='$mobile_number' limit 50";
                     $runUsers1=mysqli_query($db,$getUsers1);
                     while($rowUsers1=mysqli_fetch_array($runUsers1))
                     {*/
                      $mobile_number=$rowUsers['mobile_no_contact'];
                      $profile_image=$rowUsers['profile_image'];
                      $aadhar_card_image=$rowUsers['aadhar_card_image'];
                      $aadhar_card_image_back=$rowUsers['aadhar_card_image_back'];
                      $shop_image_1=$rowUsers['shop_image_1'];
                      $shop_image_2=$rowUsers['shop_image_2'];
                     
                     ?>
                       
                        <td><?php echo $mobile_number; ?></td>

                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $profile_image; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $profile_image; ?>"/></a></td>

                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $aadhar_card_image; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $aadhar_card_image; ?>"/></a></td>

                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $aadhar_card_image_back; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $aadhar_card_image_back; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $shop_image_1; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $shop_image_1; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $shop_image_2; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $shop_image_2; ?>"/></a></td>

                      
                        <!--  Pop Up model  -->
                          </tr>
                          <?php
                          
                        }
                        ?>   
                      </tbody>
                    </table>
                       <?php  
                      $sql = "SELECT COUNT(id) FROM registration_sellers_1";  
                      $rs_result = mysqli_query($db, $sql);  
                      $row = mysqli_fetch_array($rs_result);  
                      $total_records = $row[0];  
                      $total_pages = ceil($total_records / $showRecordPerPage);  

                      $firstPage = 1;
                      $nextPage = $currentPage + 1;
                      $previousPage = $currentPage - 1;
                      ?>
                       <nav aria-label="Page navigation">
<ul class="pagination">
<?php if($currentPage != $firstPage) { ?>
<li class="page-item">
  
                                  <!--  $pagLink .= "<li><a href='seller.php?action=activeseller&&page=".$i."'>".$i."</a></li>";   -->
<a class="page-link" href="seller.php?action=activeseller_image&&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
<span aria-hidden="true">First</span>
</a>
</li>
<?php } ?>
<?php if($currentPage >= 2) { ?>
<li class="page-item"><a class="page-link" href="seller.php?action=activeseller_image&&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
<?php } ?>
<li class="page-item active"><a class="page-link" href="seller.php?action=activeseller_image&&page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
<?php if($currentPage != $lastPage) { ?>
<li class="page-item"><a class="page-link" href="seller.php?action=activeseller_image&&page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
<li class="page-item">
<a class="page-link" href="seller.php?action=activeseller_image&&page=<?php echo $lastPage ?>" aria-label="Next">
<span aria-hidden="true">Last</span>
</a>
</li>
<?php } ?>
</ul>
</nav>
                  </div>
                </div>
              </div>
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%; height: 100%" >
      </div>
    </div>
  </div>
</div>
<script>
$(function() {
    $('.pop').on('click', function() {
      $('.imagepreview').attr('src', $(this).find('img').attr('src'));
      $('#imagemodal').modal('show');   
    });   
});
</script>
        <!-- /page content -->
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

 