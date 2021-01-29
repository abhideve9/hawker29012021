
  <!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Redeem Requests <small>By Customer</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Customer Id</th>
                          <th>Mobile No.</th>
                          <th>Amount</th>
                          <!--<th>Detail</th>-->
                          <th>Coupon Code</th>
                          <th>Expiry Date</th>
                          <th>Request Date</th>
                          <th>Request Status</th>
                          <th>Edit</th>
                          
                          
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM redeem_request";
                          $runUsers=mysqli_query($db,$getUsers);
                          $i=1;
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          $cus_id=$rowUsers['cust_id'];
                          $mobile_no=$rowUsers['mobile_no'];
                          $amount=$rowUsers['amount'];
                          $coupon_code=$rowUsers['coupon_code'];
                          $expiry_date=$rowUsers['expiry_date'];
                          $request_date=$rowUsers['created_on'];
                          $redeem_req_status=$rowUsers['redeem_req_status'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $cus_id; ?></td>
                        <td><?php echo $mobile_no; ?></td>
                        <td><?php echo $amount; ?></td>
                        <td><?php echo $coupon_code; ?></td>
                        <td><?php echo $expiry_date; ?></td>
                        <td><?php echo $request_date; ?></td>
                        <td><?php echo $redeem_req_status; ?></td>

                        <td class='menu-action'>
                        <a data-original-title='
                        ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_redeem_request' href='redeem.php?action=edit_redeem_request&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a>
                       </td>
                      
                       
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
 