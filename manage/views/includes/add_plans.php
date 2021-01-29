<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];

  if(isset($_REQUEST['submit']))
  {
    $plan_type=$_REQUEST['plan_type'];
    $value=$_REQUEST['value'];
    $amount=$_REQUEST['amount'];
    //$password1=md5($password
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');

      $duplicate=mysqli_query($db,"select * from ads_plans where plan_type='$plan_type'");
     if (mysqli_num_rows($duplicate)>0)
     {?>
    <script>
            alert("Plan type Already Exist");
           
           
          </script>
      <?php }

       $insertQuery="INSERT INTO ads_plans SET plan_type='$plan_type',value='$value',amount='$amount',create_date='$now',admin_id='$adminid',admin_name='$adminName'";
     
      $insertResult=mysqli_query($db,$insertQuery);
    
      if($insertResult)
      {
         ?>
        <script>
          alert("Advertisement Plan Add successfully");
          location.href="ads_plan.php?action=AddPlan";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="ads_plan.php?action=AddPlan";
        </script>
        <?php
      }
    
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Add Ads Plans</h2>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Plan Type <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" name="plan_type" placeholder="Enter Plan Type" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Value In Days <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" required placeholder="Enter Value In Days" name="value" class="form-control">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Amount <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                         <input type="text" required placeholder="Enter Amount" name="amount" class="form-control">
                        </div>
                      </div>
                     
                       
                    
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                         <!-- <button type="submit" class="btn btn-primary">Cancel</button>-->
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