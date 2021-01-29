a<?php
include 'db.php';
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
     date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $userID=$_REQUEST['id'];
    $name=$_REQUEST['name'];
    $updateQuery="UPDATE hawker_app_action SET name_type='$name',modified_date='$now',modified_user_name='$adminName',admin_status='1' WHERE id='$userID'";
    
      $updateResult=mysqli_query($db,$updateQuery);
      
      if($updateResult)
      {
         ?>
        <script>
          alert("Hawker App data update Successfully");
            location.href="action.php?action=activeaction";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="action.php?action=activeaction";
        </script>
        <?php
      }
    
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Add Action</h2>
    </div>
  </div>
</div>
 <?php
  $userID=$_REQUEST['id'];
  $userQuery="SELECT name_type FROM hawker_app_action WHERE id='$userID'";
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

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Action Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter  Name" value="<?php echo $userRow['name_type']; ?>" required="required" type="text">
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