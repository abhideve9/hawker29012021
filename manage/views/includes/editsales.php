<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
 $adminName=$_SESSION['adminName'];


  if(isset($_REQUEST['submit']))
  {
    
    //$email=$_REQUEST['email'];
    $userID=$_REQUEST['id'];
    $name=$_REQUEST['userName'];
    $email=$_REQUEST['email'];
    $password=$_REQUEST['password'];
    $mobile=$_REQUEST['mobile'];
  /*  $empid=$_REQUEST['empid'];*/
    $description=$_REQUEST['description'];
    $profileImage=$_FILES['profileImage']['name'];
    $type=pathinfo($profileImage,PATHINFO_EXTENSION);
    $typearr = array("jpg","jpeg", "pjpeg", "gif", "png", "x-png");
    date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
    if($profileImage!="")
    {
      if(in_array($type,$typearr))
      {
        $profileImage =$profileImage;
        $uploadDir = "salesuser_image/";
        move_uploaded_file($_FILES['profileImage']['tmp_name'],$uploadDir.$profileImage);
      }
      else{
        $profileImage=$_REQUEST['oldImage'];
      }
    } 
    else{
      $profileImage=$_REQUEST['oldImage'];
    }
    
    
      $updateQuery="UPDATE registration_sales SET name='$name',email_id='$email',password='$password',mobile_no='$mobile',address='$description',image='$profileImage',modified_user_name='$adminName',modified_date='$now',admin_status='1' WHERE id='$userID'";
      $updateResult=mysqli_query($db,$updateQuery);
      
      if($updateResult)
      {
        
          ?>
          <script>
            alert("Sales User Update Successfully");
            location.href="sales.php?action=Activesales";
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
      <h2>Sales User</h2>
    </div>
  </div>
</div>
  <?php
  $userID=$_REQUEST['id'];
  $userQuery="SELECT * FROM registration_sales WHERE id='$userID'";
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="userName" class="form-control col-md-7 col-xs-12" name="userName" placeholder="Enter Name" required="required" value="<?php echo $userRow['name']; ?>" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="email"  required placeholder="Enter email" name="email" class="form-control" value="<?php echo $userRow['email_id']; ?>" id="name_m">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="password"  required placeholder="Enter password" name="password" class="form-control" id="name_m" value="<?php echo $userRow['password']; ?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Mobile <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text"   pattern="[789][0-9]{9}" maxlength="10" required placeholder="Mobile Number" value="<?php echo $userRow['mobile_no']; ?>" name="mobile" class="form-control" id="name_m">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea  rows="5" cols="100" required placeholder="Enter Permanent Address" name="description" class="  form-control col-md-7 col-xs-12 " id="description"><?php echo $userRow['address']; ?></textarea>
                        </div>
                      </div>
                      <div  class="item form-group">
                        <input type="hidden" name="oldImage" value="<?php echo $userRow['image']; ?>">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Image <span class="required">*</span>
                        </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="file" name="profileImage" style="width:260px !important;"   class="btn vd_btn vd_bg-green fileinput-button" /><img style='width:50px; height:70px;' src="salesuser_image/<?php echo $userRow['image']; ?>"><br/><br>
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