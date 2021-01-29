
  <!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Sales<small>Users</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                        <th>Name</th>
                        <th>Hawker Type</th>
                        <th>Hawker Code</th>
                        <th>Mobile Number</th>
                        <th>Shop Name</th>
                        <th>City Address</th>
                        <th>Profile Image</th>
                        <th>Aadhar Card Image</th>
                        <th>Address Proof Image</th>
                        <th>Shop Image</th>
                        <th>View</th>
                        </tr>
                      </thead>
                      <tbody>
                     <?php 
                     $getUsers="SELECT * FROM registration_sellers where active_status='0'";
                     $runUsers=mysqli_query($db,$getUsers);
                     while($rowUsers=mysqli_fetch_array($runUsers))
                     {
                     $id=$rowUsers['id'];
                     $sales_id=$rowUsers['sales_id'];
                     $Name=$rowUsers['name'];
                     $Hawker_type=$rowUsers['user_type'];
                     $HawkerCode=$rowUsers['hawker_code'];
                     $mobile_number=$rowUsers['mobile_no_contact'];
                     $Shop_name=$rowUsers['shop_name'];
                     $city_address=$rowUsers['city_address'];
                     $shop_id=$rowUsers['shop_id'];
                     ?>
                        <tr class='odd gradeX'>
                        <td><?php echo ucfirst($Name); ?></td>
                        <td><?php echo ucfirst($Hawker_type); ?></td>
                        <td><?php echo $HawkerCode; ?></td>
                        <td><?php echo $mobile_number; ?></td>
                        <td><?php echo ucfirst($Shop_name); ?></td>
                        <td><?php echo ucfirst($city_address); ?></td>
                        <td><a  class="example-image-link" href="../assets/upload/profile_image/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="../assets/upload/profile_image/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>
                      
                        <td><a class="example-image-link" href="../assets/upload/identity_proof_image/back/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img style='width:50px; height:70px;' class='example-image' src="../assets/upload/identity_proof_image/back/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>

                        <td><a class="example-image-link" href="../assets/upload/identity_proof_image/front/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img style='width:50px; height:70px;' class='example-image' src="../assets/upload/identity_proof_image/front/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>

                        <td><a class="example-image-link" href="../assets/upload/shop_image/<?php echo "".$mobile_number.".jpeg"; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img style='width:50px; height:70px;' class='example-image' src="../assets/upload/shop_image/<?php echo "".$mobile_number.".jpeg"; ?>"/></a></td>
                         <td>
                              <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $rowUsers['id']; ?>" id="getUser" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                         </td>
                        <!--  Pop Up model  -->
                          <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog"> 
                             <div class="modal-content">  
                           
                                <div class="modal-header"> 
                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
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
                           
                       <!--  <td class='menu-action'>
                            <a  href='seller.php?action=seller_reject&id=<?php echo $id; ?>'><button type="button" class="btn btn-danger">Rejected</button> </a>
                        </td> -->
                            
                          </tr>
                          <?php
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
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
 