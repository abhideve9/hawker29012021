<?php
require_once'firebase.php';
require_once 'push.php';
require_once 'config.php';
?>
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
                  <div class="x_content">
                     <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      
                      <thead>
                      <tr>
                      <th>Add By Sales Person</th>
                      <th>Name</th>
                      <th>Duty Status</th>
                      <!-- <th>Date</th>
                      <th>Hawker Type</th>
                      <th>Hawker Code</th>
                      <th>Mobile Number</th>
                      <th>Business Name</th>
                      <th>City Address</th> -->
                      <!-- <th>Profile Image</th>
                      <th>Aadhar Card Image back</th>
                      <th>Aadhar Card Image Frunt</th>
                      <th>Shop Image</th> -->
                      <th>View</th>
                      <th>Option</th>
                      <th>Adhar Image Validation</th>
                      <th>Shop Image Validation</th>
                      </tr>
                      </thead>
                      <tbody>
                       <?php 
                      $getUsers="SELECT * FROM registration_sellers where(verification_status ='1' or  verification_by_call = '1') and active_status='1' order by registered_time desc";
                     $runUsers=mysqli_query($db,$getUsers);
                     while($rowUsers=mysqli_fetch_array($runUsers))
                     {

                     $id=$rowUsers['id'];
                     $sales_id=$rowUsers['sales_id'];
                     $get_sales_name="SELECT name FROM registration_sales where sales_id='$sales_id' and active_status='1'";
                     $getname=mysqli_query($db,$get_sales_name);
                     while($rowname=mysqli_fetch_array($getname))
                     {
                      $salesName=$rowname['name'];
                     
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
                     $shop_image_validation_status=$rowUsers['shop_image_validation_status'];
                     ?>
                        <tr class='odd gradeX'>
                         <td><?php echo ucfirst($salesName); ?></td>
                        <td><?php echo ucfirst($Name); ?></td>
                        <?php
                        if($duty_status=='')
                        {
                        ?>
                        <td>Inactive</td>
                        <?php
                        }
                        else
                        {
                        ?>
                        <td><?php echo ucfirst($duty_status); ?></td>
                        <?php
                        }
                        ?>
                       <!--  <td><?php echo ucfirst($registered_time); ?></td>
                        <td><?php echo ucfirst($Hawker_type); ?></td>
                        <td><?php echo $HawkerCode; ?></td>
                        <td><?php echo $mobile_number; ?></td>
                        <td><?php echo ucfirst($business_name); ?></td>
                        <td><?php echo ucfirst($city_address); ?></td> -->
                       <!--  <td><a  class="example-image-link" href="../assets/upload/profile_image/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="../assets/upload/profile_image/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>
                      
                        <td><a class="example-image-link" href="../assets/upload/identity_proof_image/back/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img style='width:50px; height:70px;' class='example-image' src="../assets/upload/identity_proof_image/back/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>

                        <td><a class="example-image-link" href="../assets/upload/identity_proof_image/front/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img style='width:50px; height:70px;' class='example-image' src="../assets/upload/identity_proof_image/front/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>

                        <td><a class="example-image-link" href="../assets/upload/shop_image/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img style='width:50px; height:70px;' class='example-image' src="../assets/upload/shop_image/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td> -->
                         <td>
                              <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $rowUsers['id']; ?>" id="getUser" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                         </td>
                        <!--  Pop Up model  -->
                          <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog"> 
                             <div class="modal-content">  
                           
                                <div class="modal-header"> 
                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                   </button> 
                                   <h4 class="modal-title">
                                   <i class="glyphicon glyphicon-user"></i> Hawker Details
                                   </h4> 
                                </div> 
                                    
                                <div class="modal-body">                     
                                   <div id="modal-loader" style="display: none; text-align: center;">
                                   <!-- ajax loader -->
                                   <img src="ajax-loader.gif">
                                   </div>           
                                   <!-- mysql data will be load here -->                          
                                   <div id="dynamic-content"></div>
                                </div> 
                                                
                                <div class="modal-footer"> 
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                                </div>          
                            </div> 
                          </div>
                        </div>
                        <td class='menu-action'>
                          <a href='delete_seller.php?id=<?php echo $id; ?>'><button type="button" class="btn btn-danger">Deactivate</button></a> 
                        </td>
                        <?php
                        if($adhar_image_validation_status=='1')
                        {
                        ?>
                          <td class="menu-action">
                        <a style="color:red;" data-original-title="Valid"  readonly data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate"  href="validate_adhar_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                        <?php
                         }
                         else if($adhar_image_validation_status=='2')
                         {
                          ?>
                           <td class="menu-action">
                        <a data-original-title="Valid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_adhar_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid" style="color:red;" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                         <?php
                         }
                         else if($adhar_image_validation_status=='3')
                         {
                         ?>
                          <td class="menu-action">
                        <a data-original-title="Valid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_adhar_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" style="color:red;" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                        <?php
                         }
                         else
                         {
                         ?>
                         <td class="menu-action">
                        <a data-original-title="Valid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_adhar_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_adhar_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                         <?php
                         }
                        if($shop_image_validation_status=='1')
                        {
                        ?>
                          <td class="menu-action">
                        <a style="color:red;" data-original-title="Valid"  readonly data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate"  href="validate_shop_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                        <?php
                         }
                         else if($shop_image_validation_status=='2')
                         {
                          ?>
                           <td class="menu-action">
                        <a data-original-title="Valid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_shop_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid" style="color:red;" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                         <?php
                         }
                         else if($shop_image_validation_status=='3')
                         {
                         ?>
                          <td class="menu-action">
                        <a data-original-title="Valid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_shop_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" style="color:red;" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                        <?php
                         }
                         else
                         {
                         ?>
                         <td class="menu-action">
                        <a data-original-title="Valid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_shop_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid"  data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a></td>
                         <?php
                         }
                         ?>
                         <!-- <td class="menu-action">
                         <a data-original-title="Valid" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" name="image_validate" href="validate_shop_image.php?mobile_no=<?php echo $mobile_number; ?>"> <i class="fa fa-check-square"></i> </a><a data-original-title="Invalid" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no1=<?php echo $mobile_number; ?>"> <i class="fa fa-times"></i> </a> <a data-original-title="Upload Image" data-toggle="tooltip" data-placement="top" class="btn menu-icon  vd_bd-grey vd_grey" href="validate_shop_image.php?mobile_no2=<?php echo $mobile_number; ?>"> <i class="fa fa-upload"></i> </a> </td> -->
                          </tr>
                          <?php
                          }
                        }
                        ?>   
                      </tbody>
                    </table>
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
 
   $(document).ready(function(){

    $(document).on('click', '#getUser', function(e){
  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content').html(''); // leave this div blank
     $('#modal-loader').show();
     $.ajax({
          url: 'getuser.php',
          type: 'POST',
          data: 'id='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content').html(''); // blank before load.
          $('#dynamic-content').html(data); // load here
          $('#modal-loader').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader').hide();
     });

    });
}); 
</script>
<script>
   $(document).ready(function(){
    if($(".btn-icon").hasClass("btn-warning"))
    {
      $("#iconName").val($(".btn-warning").val());
    }
  });
  $("#hours").change(function(){
      var opt=$("#hours").val();
      if(opt==1)
      {
        $("#othersDiv").show();
      }
      else{
        $("#othersDiv").hide();
      }
  });
</script>

 