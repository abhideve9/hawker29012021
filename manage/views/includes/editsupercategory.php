<?php
include 'db.php';
session_start();
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
    $insertQuery= $query="UPDATE fixer_sub_category  SET sub_cat_name='$sub_cat_name',category='$name',sub_cat_image='$Image',modified_date='$now',modified_user_name='$adminName' where id='$id'";
  
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
      <h2>Add Super Sub Category</h2>
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

                   <div class="form-group" id='show1'>
                   <label class="control-label col-lg-3">SubCategory</label>
                    <div class="col-lg-3">
                      <select id="cat2" width="50px" class="form-control"  name="sub_category" required>
                         <option value="">Select a Sub Category </option><?php
                            $get_cats = "select * from fixer_sub_category where category = '$sub1' and status='1'";
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
                  
                      <div class="form-group">
                    <label for="name_m" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip">Super Sub Category Name</span> </label>
                    <div class="col-lg-5">
                      <div class="row mgbt-xs-0">
                        <div class="col-lg-5 col-sm-5 col-xs-5 col-md-5">
                          <input type="text" style="width:260px" required placeholder="Enter Super  Sub  Category Name" name="super_sub_cat_name" class="form-control" id="name_m">
                        </div>
                      </div>
                    </div>
                  </div>
                       <div class="form-group">    
                <label for="name_m" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip">Icon Image</span> </label> 
                    <input type="file" name="iconimage" style="width:265px !important;"   class="btn vd_btn vd_bg-green fileinput-button" /><br/><br/>

                   <div class="form-group control-label col-lg-4 required">
                    <table id="imageTable" class="table table-dragable">
                      <tr id="4">                                  
                        <button class="btn vd_btn vd_bg-yellow right" type="submit" name="submit" >Submit</button>
                      </tr>
                    </table>
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