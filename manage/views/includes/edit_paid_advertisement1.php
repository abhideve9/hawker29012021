<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
 $adminName=$_SESSION['adminName'];

 if(isset($_REQUEST['submit']))
  {
    
    $hawker_code =$_POST['hawker_code'];
    $ads_id = $_REQUEST['ads_id'];
    $advertisement_title =addslashes($_REQUEST['advertisement_title']);
    $detail_of_advertisement=addslashes($_REQUEST['detail_of_advertisement']);
    $start_date=$_REQUEST['start_date'];
    $end_date=$_REQUEST['end_date'];
    // echo '<pre>';print_r($_FILES["image_3"]["name"]);exit();
    $string="UPDATE `paid_advertisement_by_merchant` SET modified_user_name='$adminName',";
     
     if(isset($detail_of_advertisement) && !empty($detail_of_advertisement))
     {
      $string.="`detail_of_advertisement`='$detail_of_advertisement',";
     }
     if(isset($_FILES["banner_img"]['name']) && !empty($_FILES["banner_img"]['name']))
     {
        $base64_banner_img=base64_encode(file_get_contents($_FILES["banner_img"]["tmp_name"]));
        $string.="`banner_img`='$base64_banner_img',";
     }
     if(isset($_FILES["image_1"]['name']) && !empty($_FILES["image_1"]['name']))
     {
        $base64_image_1=base64_encode(file_get_contents($_FILES["image_1"]["tmp_name"]));
        $string.="`image_1`='$base64_image_1',";
     }
     if(isset($_FILES["image_2"]['name']) && !empty($_FILES["image_2"]['name']))
     {
        $base64_image_2=base64_encode(file_get_contents($_FILES["image_2"]["tmp_name"]));
        $string.="`image_2`='$base64_image_2',";
     }
     if(isset($_FILES["image_3"]['name']) && !empty($_FILES["image_3"]['name']))
     {
        $base64_image_3=base64_encode(file_get_contents($_FILES["image_3"]["tmp_name"]));
        $string.="`image_3`='$base64_image_3',";
     }
     if(isset($_FILES["image_4"]['name']) && !empty($_FILES["image_4"]['name']))
     {
        $base64_image_4=base64_encode(file_get_contents($_FILES["image_4"]["tmp_name"]));
        $string.="`image_4`='$base64_image_4',";
     }
    if(isset($advertisement_title) && !empty($advertisement_title))
     {
      $string.="`advertisement_title`='$advertisement_title',";
     }
     if(isset($detail_of_advertisement) && !empty($detail_of_advertisement))
     {
      $string.="`detail_of_advertisement`='$detail_of_advertisement',";
     }
    if(isset($start_date) && !empty($start_date))
     {
      $string.="`start_date`='$start_date',";
     }
       if(isset($end_date) && !empty($end_date))
     {
      $string.="`end_date`='$end_date'";
     }

    $string.="WHERE `hawker_code`='$hawker_code' AND ads_id='$ads_id'";
     //echo $string; exit;
    $updateResult=mysqli_query($db,$string);
    
    // echo $string; exit;
      
      if($updateResult)
      {
        
         ?>
          <script>
            alert("Paid Advertisement Update Successfully");
            location.href="advertisement.php?action=paid_approve_advertisement";
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
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Paid Advertisement</h2>
    </div>
  </div>
</div>
  <?php
  $userID=$_REQUEST['id'];
  $userQuery="SELECT * FROM paid_advertisement_by_merchant WHERE id='$userID'";
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
                      <?php
                      $ads_id= $userRow['ads_id'];
                       ?>
                       <input type="hidden" name="ads_id" value="<?php echo $userRow['ads_id']; ?>">
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hawker code">Hawker Code <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="userName" class="form-control col-md-7 col-xs-12" name="hawker_code" readonly value="<?php echo $userRow['hawker_code']; ?>" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile">Mobile no.<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="mobile" disabled="disabled" name="mobile_no" class="form-control" value="<?php echo $userRow['mobile_no']; ?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="advertisement_title">Advertisement title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text" required="required" placeholder="Enter Advertisement title" name="advertisement_title" class="form-control" value="<?php echo $userRow['advertisement_title']; ?>">
                        </div>
                      </div>
                     
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Detail of Advertisement<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea  rows="5" cols="100" required placeholder="Enter Detail of Advertisement" name="detail_of_advertisement" required="required" class="  form-control col-md-7 col-xs-12 " ><?php echo $userRow['detail_of_advertisement']; ?></textarea>
                        </div>
                      </div>

                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Start Date">Start Date<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                      <input type="date" required name="start_date" class="form-control" value="<?php echo $userRow['start_date']; ?>">
                        </div>
                      </div>
                       
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="End Date">End Date<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                         <input type="date" required name="end_date" class="form-control" value="<?php echo $userRow['end_date']; ?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="browse">Banner Image<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="file" name="banner_img" class="form-control" value="">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="browse">Image 1<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="file" name="image_1" class="form-control" value="">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="browse">Image 2<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="file" name="image_2" class="form-control" value="">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="browse">Image 3<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="file" name="image_3" class="form-control" value="">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="browse">Image 4<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                         <input type="file" name="image_4" class="form-control" value="">
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