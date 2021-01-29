<?php
include 'db.php';
require_once'firebase.php';
require_once 'push.php';
require_once 'config.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
    $sub_cat_name=$_REQUEST['sub_cat_name'];
    $category = $_REQUEST['category'];
    $priority=$_REQUEST['priority'];
    $iconImage=$_FILES['iconimage']['name'];
    $uploadDir = "catImages/";
     date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
    move_uploaded_file($_FILES['iconimage']['tmp_name'],$uploadDir.$iconImage);
    $query="SELECT * FROM fixer_sub_category WHERE subcategory='$sub_cat_name'";
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
      $getUsers="SELECT * FROM login_manage_custumer where status='1'";
      $runUsers=mysqli_query($db,$getUsers);
      while($rowUsers=mysqli_fetch_array($runUsers))
      {
        $cus_id=$rowUsers['user_id'];
        $mobile_no=$rowUsers['mobile_no'];
        $notification_id=$rowUsers['notification_id'];
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';

        // notification title
        $title ='Hawkers';
        
        // notification message
        $message ='We have added a new category : '.$sub_cat_name;
        
        // push type - single user / topic
        $push_type = 'individual';
        
        // whether to include to image or not
        $include_image = 'http://api.androidhive.info/images/minion.jpg' ? TRUE : FALSE;


        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image) {
            $push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = $notification_id;
            $response = $firebase->send($regId, $json);
        }
       $insertnotified="INSERT INTO tbl_add_sub_category_notified (cus_id,mobile_no,notification_id,title,message,date_time,status) VALUES ('$cus_id','$mobile_no','$notification_id','$title','$message','$now','1')"; 
      $insertresultdata=mysqli_query($db,$insertnotified);
        }

      $insertQuery="INSERT INTO fixer_sub_category(sub_cat_name,category,sub_cat_image,status,position_key,create_date,modified_user_name) VALUES ('$sub_cat_name','$category','$iconImage','3','$category','$now','$adminName')";
      
      $insertResult=mysqli_query($db,$insertQuery);
      if($insertResult)
      {
         ?>
        <script>
          alert("Sub Category add successfully");
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
  }
?>
<!--<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Add Sub Category</h2>
    </div>
  </div>
</div>-->

  <!-- page content -->
        <div class="left_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
          <div class="x_title">
           <h2>Add Sub Category</h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  
                  <div class="x_content">

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                  <div class="item form-group">

                   <label class="control-label col-md-3 col-sm-3 col-xs-12"> Category</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="cat1" class="form-control col-md-7 col-xs-12" name="category" required>                     
                       <option value="">Select a Category<?php
                            $get_cats = "select * from fixer_category";
                            $run_cats = mysqli_query($db, $get_cats);
                            while($row_cats=mysqli_fetch_array($run_cats))
                            {
                              $id=$row_cats['id'];
                              $cat_name = $row_cats['cat_name'];
                              $type=$row_cats['type'];
                              echo "<option value='$id'>$cat_name $type</option>";
                            }
                          ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="cat1" class="form-control col-md-7 col-xs-12" name="priority">
                       <option value="">Select a priority
                        <!-- <option value='Top'>Top priority</option>
                        <option value='High'>High priority</option>
                        <option value='Medium'>Medium priority</option> 
                        <option value='Low'>Low priority</option> -->
                        <option value='Trending'>Trending priority</option>
                      </option>
                          </select>
                    </div>
                      </div>
                  
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sub Category Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" required placeholder="Enter Sub  Category Name" name="sub_cat_name" class="form-control col-md-7 col-xs-12" id="name_m">
                        </div>
                      </div>
                      <div  class="item form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Icon Image <span class="required">*</span>
                        </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="file" required name="iconimage" style="width:265px !important;"   class="btn vd_btn vd_bg-green fileinput-button" />
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