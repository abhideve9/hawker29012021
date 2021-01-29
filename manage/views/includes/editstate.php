<?php
include 'db.php';
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
    $userID=$_REQUEST['id'];
    $state_name=$_REQUEST['state_name'];
    $state_code=$_REQUEST['state_code'];
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
     $updateQuery="UPDATE hawker_lunch_state SET state_name='$state_name',state_code='$state_code',modified_date='$now',modified_user_name='$adminName',admin_status='1' WHERE id='$userID'";
     $updateResult=mysqli_query($db,$updateQuery);
      if($updateResult)
      {
         ?>
        <script>
          alert("State update successfully");
          location.href="state.php?action=activestate";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="state.php?action=activestate";
        </script>
        <?php
      }
    
  }
?>
<!-- page content -->
 <?php
  $userID=$_REQUEST['id'];
  $userQuery="SELECT state_name,state_code FROM hawker_lunch_state WHERE id='$userID'";
  $userResult=mysqli_query($db,$userQuery);
  $userRow=mysqli_fetch_array($userResult);
  ?> 
        <div class="left_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">State Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="state_name" class="form-control col-md-7 col-xs-12" name="state_name" placeholder="Enter State Name" value="<?php echo $userRow['state_name']; ?>" required="required" type="text">
                        </div>
                      </div>
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">State Code <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="state_Code" class="form-control col-md-7 col-xs-12" name="state_code" placeholder="Enter State Code" value="<?php echo $userRow['state_code']; ?>" required="required" type="text">
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