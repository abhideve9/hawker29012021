<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
$id=$_GET['id'];
  if(isset($_REQUEST['submit']))
  {
  $id=$_GET['id'];
  $name=$_REQUEST['catname'];
  $typedata=$_REQUEST['typedata'];
  $priority=$_REQUEST['priority'];
  $ads_status=$_REQUEST['ads_status'];
  $Image = $_FILES['iconimage']['name'];
  $type=pathinfo($Image,PATHINFO_EXTENSION);
  date_default_timezone_set('Asia/kolkata'); 
  $now = date('Y-m-d H:i:s');
  $typearr = array("jpg","jpeg", "pjpeg", "gif", "png", "x-png");
  if($Image!="")
  {
    if(in_array($type,$typearr))
    {
      $uploadDir = "catImages/";
      move_uploaded_file($_FILES['iconimage']['tmp_name'],$uploadDir.$Image);
    }
  } 
  else 
  {
    $Image=$_REQUEST['oldImage'];
  } 
    $insertQuery="UPDATE fixer_category  SET cat_icon_Image='$Image',cat_name='$name',priority='$priority',ads_status='$ads_status',type='$typedata',modified_date='$now',modified_user_name='$adminName',admin_status='1' where id='$id'";
   
    $insertResult=mysqli_query($db,$insertQuery);
    if($insertResult)
    {
    ?>
    <script>
      alert("Category update successfully");
      location.href="category.php?action=ActiveCategory";
    </script>
    <?php       
     }
     else
     {
     ?>
    <script>
      alert("Some-thing went wrong please try again..");
      location.href="category.php?action=ActiveCategory";
    </script>
    <?php
    }
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Edit  Category</h2>
    </div>
  </div>
</div>
 <?php
  $catID=$_REQUEST['id'];
  $userQuery="SELECT * FROM fixer_category WHERE id='$catID'";
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
                    <div class="form-group">
                     <label class="control-label col-lg-3">Priority</label>
                    <div class="col-lg-3">
                      <select id="cat1" class="form-control" width="50px" name="priority" required>
                       <option value="">Select a priority
                        <option value='Top'>Top priority</option>
                        <option value='High'>High priority</option>
                        <option value='Medium'>Medium priority</option> 
                        <option value='Low'>Low priority</option>
                        <option value='Trending'>Trending priority</option>
                      </option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                     <label class="control-label col-lg-3">Type</label>
                    <div class="col-lg-3">
                      <select class="form-control" width="50px" name="typedata" required>
                       <option value="">Select a Type
                        <option value='Moving'>Moving</option>
                        <option value='Fix'>Fix</option>
                      </option>
                          </select>
                    </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" style="width:260px" required placeholder="Enter Category Name" name="catname" value="<?php echo $userRow['cat_name']; ?>" class="form-control" id="name_m">
                        </div>
                      </div>
                       <div class="form-group">
                     <label class="control-label col-lg-3">For Free Ads</label>
                    <div class="col-lg-3">
                      <select class="form-control" width="50px" name="ads_status" required>
                       <!--<option value="">Select Y/N-->
                      <option value='0'>No</option>
                      <option value='1'>Yes</option>
                      </option>
                      </select>
                    </div>
                      </div>
                      <div  class="item form-group">
                        <input type="hidden" name="oldImage" value="<?php echo $userRow['cat_icon_image']; ?>">  
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Icon Image <span class="required">*</span>
                        </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" name="iconimage" style="width:265px !important;"   class="btn vd_btn vd_bg-green fileinput-button" /><img style='width:50px; height:70px;' src="catImages/<?php echo $userRow['cat_icon_image']; ?>"><br/><br/>
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