
  <!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Rejected Paid Advertisement </h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content ">
                   
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Hawker Code</th>
                          <th>Mobile No.</th>
                          <!--<th>Advertisement Title</th>-->
                          <!--<th>Detail of Advertisement</th>-->
                          <th>Banner Img</th>
                          <th>Image 1</th>
                          <th>Image 2</th>
                          <th>Image 3</th>
                          <th>Image 4</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Rejection Reason</th>
                          <!--<th>Edit</th>
                          <th>Option</th>-->
                          <!--<th>Notification</th>-->
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                $getUsers="SELECT * FROM paid_advertisement_by_merchant where payment_status='Paid' AND rejection_status='1' AND aproval_status='0'";
                          $runUsers=mysqli_query($db,$getUsers);
                          $i=1;
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                            $id=$rowUsers['id'];
                          
                          $hawker_code=$rowUsers['hawker_code'];
                          $mobile_no=$rowUsers['mobile_no'];
                          //$advertisement_title=$rowUsers['advertisement_title'];
                          //$detail_of_advertisement=$rowUsers['detail_of_advertisement'];
                          $banner_image=$rowUsers['banner_img'];
                          $image_1=$rowUsers['image_1'];
                          $image_2=$rowUsers['image_2'];
                          $image_3=$rowUsers['image_3'];
                          $image_4=$rowUsers['image_4'];
                          $start_date=$rowUsers['start_date'];
                          $end_date=$rowUsers['end_date'];
                          $reason=$rowUsers['reason_of_reject'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $hawker_code; ?></td>
                        <td><?php echo $mobile_no; ?></td>
                        <!--<td><?php// echo $advertisement_title; ?></td>-->
                        <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $banner_image; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $banner_image; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $image_1; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $image_1; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $image_2; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $image_2; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $image_3; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $image_3; ?>"/></a></td>

                         <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $image_4; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $image_4; ?>"/></a></td>

                  
                       
                        <td><?php echo $start_date; ?></td>
                        <td><?php echo $end_date; ?></td>
                        <td><?php echo $reason; ?></td>
                        <!--<td class='menu-action'>
                        <a data-original-title='
                        ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_free_advertisement' href='advertisement.php?action=edit_paid_advertisement&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a>
                       </td>-->
                       <?php 
                      //if($rowUsers['aproval_status']==0)
                       //{
                       ?>
                       <!--<td>
                        <a href='advertisement.php?action=approve_paid_advertisement&id=<?php echo $id; ?>'><button type="button" class="btn btn-danger">Approve</button></a> 
                       </td>-->
                        <?php
                        // }
                         //else
                         //{
                         ?>
                        <!-- <td>
                          <a  href='advertisement.php?action=disapprove_paid_advertisement&id=<?php echo $id; ?>'><button type="button" class="btn btn-success">Disapprove</button> </a> 
                        </td>-->
                        <?php
                        // }
                         ?> 
                       <!--<td>
                        <a href='sendnotification.php?id=<?php echo $SalesID; ?>'><button type="button" class="btn btn-primary">Notification</button></a> 
                       </td> -->   
                      </tr>
                      <?php
                      $i++;
                       }
                       ?>   
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        <!-- /page content -->

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
 