<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
    $id=$_REQUEST['id'];
    $message=$_REQUEST['message'];
    date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
       $UpdateQuery="UPDATE registration_sales SET message='$message', modified_date='$now',modified_user_name='$adminName', active_status='0',admin_status='1' WHERE id='".$_REQUEST['id']."'";
      $UpdateResult=mysqli_query($db,$UpdateQuery);
      if($UpdateResult)
      {
         ?>
        <script>
          alert("Sales User Deactivate successfully");
          location.href="sales.php?action=Activesales";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="sales.php?action=Activesales";
        </script>
        <?php
      }
    }
  
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Sales User</h2>
    </div>
  </div>
</div>
  <!-- page content -->
        <div class="left_col" role="main">
          <div class="">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Message <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea  rows="5" cols="100" required placeholder="Enter Message" name="message" class="  form-control col-md-7 col-xs-12 " id="message"></textarea>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button id="send" name="submit" type="submit" class="btn btn-success">Submit</button>
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