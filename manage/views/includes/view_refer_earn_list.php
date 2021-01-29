
  <!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Refer and Earn List</h2>
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
                          <th>Referrer Mob no.</th>
                          <th>Count Today</th>
                          <th>Count Month(till date)</th>
                          <th>Total Count till date</th>
                          <th>Point Earned till date</th>
                          <th>Points Redeemed till date</th>
                          <th>Points Unredeemed</th>

                            
                          <!--<th>Detail</th>
                          <th>Customer Referral code</th>
                          <th>Generate Referral code</th>
                          <th>Bal Amount</th>-->

                          <!--<th>Request Status</th>-->
                          <!--<th>Edit</th>-->
                         </tr>
                      </thead>
                      <tbody>
                          <?php 
        $getUsers="SELECT * FROM tbl_genrate_referral_code_for_customer where genrate_referral_code IS NOT NULL ";
  
                          $runUsers=mysqli_query($db,$getUsers);
                          $i=1;
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          $mobile_no=$rowUsers['mobile_no'];
                          $genrate_referral_code=$rowUsers['genrate_referral_code'];
                          $date = date('Y-m-d');
                          //$customer_referral_code=$rowUsers['customer_referral_code'];
                          //$genrate_referral_code=$rowUsers['genrate_referral_code'];
                          //$customer_point=$rowUsers['customer_point'];
                          //$referral_point=$rowUsers['referral_point'];
                          //$referral_point=$rowUsers['referral_point'];
                          $total_point=$rowUsers['total_point'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $i++; ?></td>
                    
                        <td><?php echo $mobile_no; ?></td>
                        <td><?php
                          
                          $count = "SELECT * FROM tbl_genrate_referral_code_for_customer where customer_referral_code='$genrate_referral_code' && date ='$date'";
                          $run = mysqli_query($db, $count);
                          $row = mysqli_num_rows($run);
                          echo $row;

                           
                        ?></td>
                        <td><?php
                          
                          $count = "SELECT * FROM tbl_genrate_referral_code_for_customer where customer_referral_code='$genrate_referral_code' && date ='$date'";
                          $run = mysqli_query($db, $count);
                          $row = mysqli_num_rows($run);
                          echo $row;
                          ?></td>
                        <td><?php 
                        $count = "SELECT * FROM tbl_genrate_referral_code_for_customer where customer_referral_code='$genrate_referral_code'";
                           
                          $run = mysqli_query($db, $count);
                          $row = mysqli_num_rows($run);
                          echo $row;
                            ?></td>

                          <td>
                          <?php
                            
                            $redeemed = 0;
                    $sql="SELECT t.total_point, t.mobile_no, r.amount,r.mobile_no from tbl_genrate_referral_code_for_customer t , redeem_request r where t.mobile_no='$mobile_no' AND r.mobile_no='$mobile_no'";
                           $runUsr=mysqli_query($db,$sql);
                          while($rowUsr=mysqli_fetch_array($runUsr))
                          {
                            
                           $amount1=$rowUsr['amount'];
                            $redeemed= $redeemed + $amount1;
                          }
                          echo $total_point + $redeemed;
                          ?>
                         </td>

                         <td><?php $getUsers1="SELECT SUM(amount) AS Total  FROM redeem_request where mobile_no='$mobile_no' AND redeem_req_status='Approved'";
                         $runUsers1=mysqli_query($db,$getUsers1);

                         $aproved = 0;
                          while($rowUsers1=mysqli_fetch_array($runUsers1))
                          {
                         $amount=$rowUsers1['Total'];
                         $aproved = $aproved+$amount;
                          } 
                          echo $aproved;
                          ?></td>
                        <td><?php
                        $getUsers2="SELECT * FROM redeem_request where mobile_no='$mobile_no' AND redeem_req_status='Pending'";
  
                          $runUsers2=mysqli_query($db,$getUsers2);
                          $pending = 0;
                          while($rowUsers2=mysqli_fetch_array($runUsers2))
                          {
                          $amount=$rowUsers2['amount'];
                          $pending = $pending+$amount;
                          }
                          echo $pending;
                          ?></td>
                       
                       
                        <!--<td><?php echo $customer_referral_code; ?></td>
                        <td><?php echo $genrate_referral_code; ?></td>
                        
                        <td><?php echo $customer_point + $referral_point; ?></td>-->
                        

                        <!--<td class='menu-action'>
                        <a data-original-title='
                        ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_redeem_request' href='redeem.php?action=edit_redeem_request&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a>
                       </td>-->
                      
                       
                      </tr>

                      <?php
                      
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
 