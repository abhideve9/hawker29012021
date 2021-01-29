<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
$id=$_GET['id'];
  if(isset($_REQUEST['submit']))
  {
  $id=$_GET['id'];
  $reason_of_reject=$_REQUEST['reason_of_reject'];
 
  $updateQuery="UPDATE tbl_request_for_hawker_advertisement SET rejection_status='1',reason_of_reject='$reason_of_reject',modified_user_name='$adminName' where id='$id'";
   
    $updateResult=mysqli_query($db,$updateQuery);
    if($updateResult)
    {
    ?>
    <script>
      alert("Free Advertisement Reject successfully");
      location.href="advertisement.php?action=free_pending_advertisement";
    </script>
    <?php       
     }
     else
     {
     ?>
    <script>
      alert("Some-thing went wrong please try again..");
      location.href="advertisement.php?action=free_pending_advertisement";
    </script>
    <?php
    }
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Rejection of Free Advertisement</h2>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Reason Of Rejection<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea  rows="5" cols="100" required placeholder="Enter Reason Of Rejection" name="reason_of_reject" class="form-control col-md-7 col-xs-12 "></textarea>
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