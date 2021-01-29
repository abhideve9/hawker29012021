<?php
include 'db.php';
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
    $version_name=$_REQUEST['version_name'];
    $version_code=$_REQUEST['version_code'];
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $updateQuery="UPDATE check_version_for_hawker SET version_name='$version_name',version_code='$version_code',status='1',modified_date='$now',modified_user_name='$adminName',admin_status='1'";
    $updateResult=mysqli_query($db,$updateQuery);
    if($updateResult)
    {
     ?>
      <script>
        alert("Hawker Version  update Successfully");
          location.href="version.php?action=showversion";
      </script>
    <?php       
    }
    else{
        ?>
      <script>
        alert("Some-thing went wrong please try again..");
        location.href="version.php?action=showversion";
      </script>
        <?php
      }
     }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Update Hawker Version</h2>
    </div>
  </div>
</div>
  <?php
  $userQuery="SELECT version_name,version_code FROM check_version_for_hawker";
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Version Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="version" class="form-control col-md-7 col-xs-12" name="version_name" placeholder="Enter Version Name" value="<?php echo $userRow['version_name']; ?>" required="required" type="text">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Version Code <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="versionCode" class="form-control col-md-7 col-xs-12" name="version_code" placeholder="Enter Version Code" value="<?php echo $userRow['version_code']; ?>" required="required" type="text">
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