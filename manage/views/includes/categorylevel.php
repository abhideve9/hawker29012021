<?php
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
include 'db.php';
  if(isset($_REQUEST['submit']))
  {
    $type=$_REQUEST['type'];
    $level=$_REQUEST['level'];
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $updateQuery="UPDATE $type SET check_level='$level',modified_date='$now',modified_user_name='$adminName',admin_status='1'";
    $updateResult=mysqli_query($db,$updateQuery);
      if($updateResult)
      {
         ?>
        <script>
          alert("Level Set successfully");
          location.href="level.php?action=categorylevel";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="level.php?action=categorylevel";
        </script>
        <?php
      }
    
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Change hawker category</h2>
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

                  <div class="form-group">
                     <label class="control-label col-lg-3">Type</label>
                    <div class="col-lg-3">
                      <select id="cat1" class="form-control" width="50px" name="type" required>
                       <option value="">Select type
                       <option value='fixer_category'>Category</option>
                       <option value='fixer_sub_category'>Sub Category</option>
                      <!--  <option value='fixer_super_sub_category'>Super Sub Category</option> -->
                        </option>
                      </select>
                    </div>
                  </div>

                   <div class="form-group">
                     <label class="control-label col-lg-3">Level</label>
                    <div class="col-lg-3">
                      <select id="cat1" class="form-control" width="50px" name="level" required>
                       <option value="">Select Level
                       <option value='level_1'>level_1</option>
                       <option value='level_2'>level_2</option>
                       <option value='level_3'>level_3</option>
                        </option>
                      </select>
                    </div>
                  </div>
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