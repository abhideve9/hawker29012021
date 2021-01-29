<?php
include 'db.php';
require_once'firebase.php';
require_once 'push.php';
require_once 'config.php';
  if(isset($_REQUEST['submit']))
  {
    $name=$_REQUEST['catname'];
    $typedata=$_REQUEST['typedata'];
    $priority=$_REQUEST['priority'];
    $iconImage=$_FILES['iconimage']['name'];
    $uploadDir = "catImages/";
    move_uploaded_file($_FILES['iconimage']['tmp_name'],$uploadDir.$iconImage);
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
        $message ='We have added a new category : '.$name;
        
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
       $insertnotified="INSERT INTO tbl_add_category_notified (cus_id,mobile_no,notification_id,title,message,date_time,status) VALUES ('$cus_id','$mobile_no','$notification_id','$title','$message','$now','1')"; 
      $insertresultdata=mysqli_query($db,$insertnotified);
        }
      $insertQuery="INSERT INTO fixer_category (cat_name,cat_icon_Image,priority,type,status,sales_status,create_date) VALUES ('$name','$iconImage','$priority','$typedata','3','3','$now')"; 
        
    
      $insertResult=mysqli_query($db,$insertQuery);
      if($insertResult)
      {
         ?>
        <script>
          alert("Category add successfully");
          location.href="category.php?action=ActiveCategory";
        </script>
        <?php       
      }
    
/*  }
*/      /*else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="category.php?action=ActiveCategory";
        </script>
        <?php
      }*/
    }
  
?>
<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Show Mapped </h2>
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

                    <form class="form-horizontal" action="mapped.php" method="GET" enctype="multipart/form-data">
                   
                    <div class="form-group">
                     <label class="control-label col-lg-3">Sales Person</label>
                    <div class="col-lg-3">
                      <select id="cat1" class="form-control" width="50px" name="sales" required>
                       <option value="">Select a Sales Person
                        <?php
                            $get_cats = "select name,sales_id from registration_sales";
                            $run_cats = mysqli_query($db, $get_cats);
                            while($row_cats=mysqli_fetch_array($run_cats))
                            {
                              $sales_id=$row_cats['sales_id'];
                              $name = $row_cats['name'];
                              echo "<option value='$sales_id'>$name</option>";
                            }
                          ?>
                      </option>
                          </select>
                    </div>
                      </div>
                       <div class="navbar1">
                      
                        <b style=" color: #000000; padding-left: 187px;">Start Date:</b>
                         <input  type="date" name="fromdate" id="date" value="<?php if($_POST['fromdate']==''){echo date('Y-m-d');}  else {echo $_POST['fromdate'] ;}  ?>" required="">
                         
                        <!-- <input type="submit" name="submit" value="submit" style="border-radius: 10px;border: none;width: 5%;"> -->
                    </div>
                    <br>
                    <div class="navbar1">
                        
                        <b style=" color: #000000; padding-left: 187px;">End Date:</b>
                         <input  type="date" name="todate" id="date" value="<?php if($_POST['todate']==''){echo date('Y-m-d');}  else {echo $_POST['todate'] ;}  ?>" required="">
                         
                        <!-- <input type="submit" name="submit" value="submit" style="border-radius: 10px;border: none;width: 5%;"> -->
                    </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                         <!--  <button type="submit" class="btn btn-primary">Cancel</button> -->
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