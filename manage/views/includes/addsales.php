<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];

  if(isset($_REQUEST['submit']))
  {
    $userName=$_REQUEST['userName'];
    $email=$_REQUEST['email'];
    $password=$_REQUEST['password'];
    //$password1=md5($password);
     date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
    $mobile=$_REQUEST['mobile'];
    $description1=$_REQUEST['description1'];
    $profileImage=$_FILES['profileImage']['name'];
    $type1='sales';
    $type=pathinfo($profileImage,PATHINFO_EXTENSION);
    $typearr = array("jpg","jpeg", "pjpeg", "gif", "png", "x-png");
    if($profileImage!="")
    {
      if(in_array($type,$typearr))
      {
        $profileImage = $profileImage;
        $uploadDir = "salesuser_image/";
        move_uploaded_file($_FILES['profileImage']['tmp_name'],$uploadDir.$profileImage);
      }
    } 
    
    $query="SELECT * FROM registration_sales WHERE mobile_no='$mobile'";
    $result=mysqli_query($db,$query);

    $querydata="SELECT * FROM registration_customer WHERE mobile_no='$mobile'";
    $resultdata=mysqli_query($db,$querydata);
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
       $insertQuery="INSERT INTO registration_sales SET name='$userName',email_id='$email',password='$password',mobile_no='$mobile',modified_user_name='$adminName',admin_id='$adminid',address='$description1',image='$profileImage',active_status='1',type='$type1',create_date='$now'";
     
      $insertResult=mysqli_query($db,$insertQuery);
      $id = mysqli_insert_id($db);
      $alphanumerric='SAL_0000'.$id;
      if($insertResult)
      {
        $data="UPDATE registration_sales SET sales_id='$alphanumerric' where id='$id'";
        $insertdata=mysqli_query($db,$data);
         ?>
        <script>
          alert("Sales User add successfully");
          location.href="sales.php?action=AddSale";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="sales.php?action=AddSale";
        </script>
        <?php
      }
    }
  }
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Add Sales User</h2>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="userName" class="form-control col-md-7 col-xs-12" name="userName" placeholder="Enter Name" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="email"  required placeholder="Enter email" name="email" class="form-control" id="name_m">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="password"  required placeholder="Enter password" name="password" class="form-control" id="name_m">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Mobile <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text"   pattern="[789][0-9]{9}" maxlength="10" required placeholder="Mobile Number" name="mobile" class="form-control" id="name_m">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea  rows="5" cols="100" required placeholder="Enter Permanent Address" name="description1" class="  form-control col-md-7 col-xs-12 " id="description"></textarea>
                        </div>
                      </div>
                      <div  class="item form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Image <span class="required"></span>
                        </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="file" name="profileImage"   class="btn vd_btn vd_bg-green fileinput-button" /><br/><br/>
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