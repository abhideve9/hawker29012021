<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
$id=$_GET['id'];
  if(isset($_REQUEST['submit']))
  {
  $id=$_GET['id'];
  $name=$_REQUEST['category'];
  $sub_cat_name=$_REQUEST['sub_cat_name'];
 // $priority=$_REQUEST['priority'];
  $Image = $_FILES['iconimage']['name'];
  $type=pathinfo($Image,PATHINFO_EXTENSION);
  $typearr = array("jpg","jpeg", "pjpeg", "gif", "png", "x-png");
   date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
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
    $insertQuery= $query="UPDATE fixer_sub_category  SET sub_cat_name='$sub_cat_name',category='$name',sub_cat_image='$Image',modified_date='$now',modified_user_name='$adminName',admin_status='1' where id='$id'";
  
    $insertResult=mysqli_query($db,$insertQuery);
      if($insertResult)
      {
         ?>
        <script>
          alert("Sub Category update successfully");
          location.href="category.php?action=ActiveSubCat";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="category.php?action=ActiveSubCat";
        </script>
        <?php
      }
    
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Edit Sub Category</h2>
    </div>
  </div>
</div>
  <?php
  $catID=$_REQUEST['cat_id'];
  $id=$_REQUEST['id'];
  $userQuery="SELECT * FROM fixer_category WHERE id='$catID'";
  $userResult=mysqli_query($db,$userQuery);
  $userRow=mysqli_fetch_array($userResult);

  $subcatdata="SELECT * FROM fixer_sub_category WHERE id='$id'";
  $userdata=mysqli_query($db,$subcatdata);
  $userdata=mysqli_fetch_array($userdata);
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
                   <label class="control-label col-lg-3">Category</label>
                    <div class="col-lg-3">
                      <select id="cat1" width="50px" name="category" required>                     
                       <option value="">Select a Category </option><?php
                            $get_cats = "select * from fixer_category";
                            $run_cats = mysqli_query($db, $get_cats);
                            while($row_cats=mysqli_fetch_array($run_cats))
                            {
                              $id=$row_cats['id'];
                              $cat_name = $row_cats['cat_name'];
                              ?>
                              <option value='<?php echo $id; ?>' <?php if($id==$userRow['id']){echo 'selected';} ?> ><?php echo $cat_name; ?></option>
                              <?php
                            }
                          ?>
                      </select>
                        </div>
                      </div>
                     <!--  <div class="form-group">
                     <label class="control-label col-lg-3">Priority</label>
                    <div class="col-lg-3">
                      <select id="cat1" class="form-control" width="50px" name="priority">
                       <option value="">Select a priority
                        <option value='Top'>Top priority</option>
                        <option value='High'>High priority</option>
                        <option value='Medium'>Medium priority</option> 
                        <option value='Low'>Low priority</option>
                        <option value='Trending'>Trending priority</option>
                      </option>
                          </select>
                    </div>
                      </div> -->
                  
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sub Category Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" style="width:260px" required placeholder="Enter Sub  Category Name" name="sub_cat_name" value="<?php echo $userdata['sub_cat_name']; ?>" class="form-control" id="name_m">
                        </div>
                      </div>
                    <div  class="item form-group">
                     <input type="hidden" name="oldImage" value="<?php echo $userdata['sub_cat_image']; ?>">  
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Icon Image <span class="required">*</span>
                        </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="file" name="iconimage" style="width:265px !important;"   class="btn vd_btn vd_bg-green fileinput-button" /><img style='width:50px; height:70px;' src="catImages/<?php echo $userdata['sub_cat_image']; ?>"><br/><br/>
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