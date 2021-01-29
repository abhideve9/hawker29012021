<?php
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['submit']))
  {
    $hawkername=$_REQUEST['hawkername'];
    $hawker_type=$_REQUEST['hawker_type'];
    
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $insertQuery="INSERT INTO hawkers_sub_type (hawker__sub_type_name,hawker_type_code,create_date,status) VALUES ('$hawkername','$hawker_type','$now','1')";
      $insertResult=mysqli_query($db,$insertQuery);
      if($insertResult)
      {
         ?>
        <script>
          alert("HawkersType  add successfully");
          location.href="hawker.php?action=addhawkertype";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="hawker.php?action=addhawkertype";
        </script>
        <?php
      }
    
  }
?>
<!--<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Hawker Type</h2>
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
           <h2>Add Hawker Type</h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  
                  <div class="x_content">

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                   <div class="item form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12">Hawker Type</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="cat1" width="50px" class="form-control col-md-7 col-xs-12" name="hawker_type" required>                     
                       <option value="">Select a Type<?php
                            $get_type = "select * from hawker_type";
                            $run_type = mysqli_query($db, $get_type);
                            while($row_type=mysqli_fetch_array($run_type))
                            {
                              $id=$row_type['id'];
                              $hawker_type = $row_type['hawker_type'];
                              $code = $row_type['code'];
                              echo "<option value='$code'>$hawker_type</option>";
                            }
                          ?>
                        </option>
                      </select>
                    </div>
                  </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Hawkers Type Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="catname" class="form-control col-md-7 col-xs-12" name="hawkername" placeholder="Enter hawker type" required="required" type="text">
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