<?php
include 'db.php';
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
    $name=$_REQUEST['name'];
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $query="SELECT * FROM hawker_app_action WHERE name_type='$name'";
    $result=mysqli_query($db,$query);
    if(mysqli_num_rows($result)>0)
    {
      ?>
      <script>
        alert("Record Already in Database.");
      </script> 
      <?php
    }
    else
    { 
       $insertQuery="INSERT INTO hawker_app_action (name_type,status,create_date,modified_user_name)VALUES ('$name','1','$now','$adminName')";
      $insertResult=mysqli_query($db,$insertQuery);
      if($insertResult)
      {
         ?>
        <script>
          alert("Action add successfully");
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
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Add Action</h2>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Action Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter  Name" required="required" type="text">
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