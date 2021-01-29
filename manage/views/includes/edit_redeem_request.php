<?php
include 'db.php';
require_once 'firebase.php';
require_once 'push.php';
require_once 'config.php';

$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
 
  if(isset($_REQUEST['submit']))
  {
    
   // print_r($_REQUEST);
    $id =$_POST['id'];
    $cust_id =$_POST['cust_id'];
    $mobile_no =$_POST['mobile_no'];
    $coupon_code =$_POST['coupon_code'];
    $expiry_date =$_REQUEST['expiry_date'];
    $redeem_req_status = $_REQUEST['redeem_req_status'];
    $after_redeem= 'Approved';


   $duplicate=mysqli_query($db,"select * from redeem_request where coupon_code='$coupon_code'");
  if (mysqli_num_rows($duplicate)>0)
  {?>
    <script>
            alert("Coupon Code Already Exist");
    </script>
 <?php }
    else{
    $string="UPDATE `redeem_request` SET coupon_code='$coupon_code', expiry_date='$expiry_date', redeem_req_status='$after_redeem', admin_id='$adminid', admin_name='$adminName' WHERE cust_id='$cust_id' AND mobile_no='$mobile_no' AND id='$id'";
    
    $updateResult=mysqli_query($db,$string);
    
    //echo $string; exit;
      
      if($updateResult)
      {
        $sql=mysqli_query($db,"SELECT notification_id FROM login_manage_custumer WHERE user_id='$cust_id' AND active_status=1");
        $fetchNotifiation=mysqli_fetch_assoc($sql);
        $notification_id=$fetchNotifiation['notification_id'];
        $firebase = new Firebase();
			         $push = new Push();
			         $payload = array();
			         $payload['team'] = 'India';
			         $payload['score'] = '5.6';
			        // notification title
			         $title ='Hawkers';
			         $message ='Your Amazon coupon has arrived.';
			          $push_type = 'individual';
			         $include_image = 'http://api.androidhive.info/images/minion.jpg' ? TRUE : FALSE;
			         $push->setTitle($title);
			         $push->setMessage($message);
			         if ($include_image) {
			            $push->setImage('http://api.androidhive.info/images/minion.jpg');
			        } else {
			            $push->setImage('');
			        }
			        $push->setIsBackground(FALSE);
			        $push->setPayload($payload);
			        $json = '';
			        $response = '';

			        if ($push_type == 'topic') {
			            $json = $push->getPush();
			            $response = $firebase->sendToTopic('global', $json);
			        } else if ($push_type == 'individual') {
			            $json = $push->getPush();
			            $regId = $notification_id;
			            $response = $firebase->send($regId, $json);
			        }

         ?>
          <script>
            alert("Coupon Code Update Successfully");
            location.href="redeem.php?action=approved_redeem_requests";
          </script>
        <?php
        }       
      
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          //location.href="listing.php?action=addUser";
        </script>
        <?php
      }
  } 
}
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Update Coupon Code</h2>
    </div>
  </div>
</div>
  <?php
  $userID=$_REQUEST['id'];
  $userQuery="SELECT * FROM redeem_request WHERE id='$userID'";
  $userResult=mysqli_query($db,$userQuery);
  $userRow=mysqli_fetch_array($userResult);
  ?> 

  <!-- page content -->
        <div class="left_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                       <input name="id" value="<?php echo $userRow['id']; ?>" type="hidden">

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Customer id">Customer Id <span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input id="" class="form-control col-md-7 col-xs-12" name="cust_id"  readonly value="<?php echo $userRow['cust_id']; ?>" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile">Mobile no.<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                        <input type="mobile" readonly="readonly" name="mobile_no" class="form-control" value="<?php echo $userRow['mobile_no']; ?>">
                        </div>
                      </div>
                    
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Amount">Amount<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                <input type="mobile" readonly="readonly" name="amount" class="form-control" value="<?php echo $userRow['amount'];?>">
                        </div>
                      </div>
                     
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Coupon Code">Coupon Code<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="text" required placeholder="Enter Coupon Code" name="coupon_code" class="form-control"  value="<?php echo $userRow['coupon_code']; ?>">
                        </div>
                      </div>
                       
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Expiry Date">Expiry Date<span class="required">*</span>
                        </label>
                      <div class="col-md-3 col-sm-3 col-xs-6">
                      <input type="date" required placeholder="Enter end date" name="expiry_date" class="form-control" value="<?php echo $userRow['expiry_date']; ?>">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Request Date">Request Date<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="text" readonly name="created_on" class="form-control"  value="<?php echo $userRow['created_on']; ?>">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Redeem Req Status">Redeem Request Status<span class="required">*</span>
                        </label>
                    <div class="col-md-3 col-sm-3 col-xs-6">
      <input type="text" readonly name="redeem_req_status" class="form-control"  value="<?php echo $userRow['redeem_req_status']; ?>">
                        </div>
                      </div>
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <!--<button type="submit" class="btn btn-primary">Cancel</button>-->
                          <button id="send" name="submit" type="submit" class="btn btn-success">Submit & Approve</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
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