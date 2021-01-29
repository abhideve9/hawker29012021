<?php
error_reporting(0);
include '../config.php';
include 'header.php';
require_once'firebase.php';
require_once 'push.php';
require_once 'config.php';
 $mobile_no=$_GET['mobile_no'];
 $getUsers="SELECT notification_id  FROM tbl_manage_login_user WHERE mobile_no='$mobile_no'";
 $runUsers=mysqli_query($conn,$getUsers);
 while($rowUsers=mysqli_fetch_array($runUsers))
 {
   $notification_id=$rowUsers['notification_id'];
 }

  if(isset($_POST['submit']))
  {
  $firebase = new Firebase();
  $push = new Push();

  // optional payload
  $payload = array();
  $payload['team'] = 'India';
  $payload['score'] = '5.6';

   // notification title
  $title = isset($_POST['title']) ? $_POST['title'] : '';
   
  // notification message
  $message = isset($_POST['message']) ? $_POST['message'] : '';
   
  // push type - single user / topic
  $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
   
  // whether to include to image or not
  $include_image = isset($_POST['include_image']) ? TRUE : FALSE;


 $push->setTitle($title);
  $push->setMessage($message);
  if ($include_image) {
      $push->setImage('https://api.androidhive.info/images/minion.jpg');
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
      $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
      $response = $firebase->send($regId, $json);
      ?>
       <script>
    alert("notification send successfully");
    location.href="sales.php?action=Activesales";
  </script>
  <?php
  }

 }
  ?>
        
<!DOCTYPE html>
<html lang="en">
  <?php  include 'includes/head.php'; ?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
         <div class="left_col scroll-view">
           <?php include 'includes/nav_left.php'; ?>
          </div>
        </div>
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<!--  <script src="http://cdn.tinymce.com/4/tinymce.min.js"></script> -->
  <script>tinymce.init({ selector:'textarea' });</script>
        <!-- top navigation -->
        <?php 
          include 'includes/top_nav.php';
          ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

                <!-- Middle Content Start -->
    
    <div class="vd_content-wrapper">
      <div class="vd_container">
        <div class="vd_content clearfix">
          <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
              <ul class="breadcrumb">
                <li><a href="index.php">Home</a> </li>
                <li>Send Notification</li>
              </ul>
            </div>
          </div>
          
           <div class="vd_title-section clearfix">
            <div class="vd_panel-header">
              <h1>Send Notification</h1>
              <div class="vd_panel-menu hidden-xs">
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12" id="ecommerce-product-add">
           <div class="left_col" role="main">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
            <div class="fl_window">
               <!--  <div><img src="http://api.androidhive.info/images/firebase_logo.png" width="200" alt="Firebase"/></div> -->
                <br/>
                <?php if ($json != '') { ?>
                    <label><b>Request:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($json) ?></pre>
                    </div>
                <?php } ?>
                <br/>
                <?php if ($response != '') { ?>
                    <label><b>Response:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($response) ?></pre>
                    </div>
                <?php } ?>

            </div>

            <form class="pure-form pure-form-stacked" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Send to Single Device</legend>

                    <label for="redId">Firebase Reg Id</label>
                    <input type="text" id="redId" readonly name="regId" class="pure-input-1-2" placeholder="Enter firebase registration id" value="<?php echo $notification_id; ?>">

                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="pure-input-1-2" placeholder="Enter title">

                    <label for="message">Message</label>
                    <textarea class="pure-input-1-2" rows="5" name="message" id="message" placeholder="Notification message!"></textarea>
 

                    <label for="include_image" class="pure-checkbox">
                        <input name="include_image" id="include_image" type="checkbox"> Include image
                    </label>
                    <input type="hidden" name="push_type" value="individual"/>
                    <button type="submit" name="submit" class="pure-button pure-button-primary btn_send">Send</button>
                </fieldset>
            </form>
            <br/><br/><br/><br/>

            <form class="pure-form pure-form-stacked" method="get">
                <fieldset>
                    <legend>Send to Topic `global`</legend>

                    <label for="title1">Title</label>
                    <input type="text" id="title1" name="title" class="pure-input-1-2" placeholder="Enter title">

                    <label for="message1">Message</label>
                    <textarea class="pure-input-1-2" name="message" id="message1" rows="5" placeholder="Notification message!"></textarea>

                    <label for="include_image1" class="pure-checkbox">
                        <input id="include_image1" name="include_image" type="checkbox"> Include image
                    </label>
                    <input type="hidden" name="push_type" value="topic"/>
                    <button type="submit" class="pure-button pure-button-primary btn_send">Send to Topic</button>
                </fieldset>
            </form>
        </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    
          </div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
       <?php include 'includes/footer.php'; ?>
        <!-- /footer content -->
      </div>
    </div>
  </body>
</html>
