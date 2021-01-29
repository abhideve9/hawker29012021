<?php
session_start();
include 'db.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];

  if(isset($_REQUEST['submit']))
  {
    $super_sub_cat_name=$_REQUEST['super_sub_cat_name'];
    $category = $_REQUEST['category'];
    $sub_category=$_REQUEST['sub_category'];
    $iconImage=$_FILES['iconimage']['name'];
    $uploadDir = "catImages/";
     date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
    move_uploaded_file($_FILES['iconimage']['tmp_name'],$uploadDir.$iconImage);
    $query="SELECT * FROM fixer_super_sub_category WHERE super_sub_cat_name='$super_sub_cat_name'";
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
       $insertQuery="INSERT INTO fixer_super_sub_category(super_sub_cat_name,sub_cat_id,cat_id,super_sub_cat_image,status,create_date,modified_user_name) VALUES ('$super_sub_cat_name','$sub_category','$category','$iconImage','1','$now','$adminName')";
      $insertResult=mysqli_query($db,$insertQuery);
      if($insertResult)
      {
         ?>
        <script>
          alert("Super Sub Category add successfully");
          location.href="category.php?action=AddSupersubcat";
        </script>
        <?php       
      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="category.php?action=AddSupersubcat";
        </script>
        <?php
      }
    }
  }
?>
<!--<div class="vd_title-section clearfix">
  <div class="row">
    <div class="vd_panel-header col-sm-4">
      <h2>Add Super Sub Category</h2>
    </div>
    
  </div>
</div>-->

<div class="left_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
          <div class="x_title">
           <h2>Add Super Sub Category</h2>
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
                              echo "<option value='$id'>$cat_name</option>";
                            }
                          ?></option>
                      </select>
                    </div>
                  </div>

                   <div class="item form-group" id='show1' style="display: none;">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="cat2" class="form-control col-md-7 col-xs-12"  name="sub_category" required>
                        <option selected="selected">Select Options</option>
                      </select>
                    </div>
                  </div>
                  
                      <div class="item form-group">
                    <label for="name_m" class="control-label col-md-3 col-sm-3 col-xs-12"> <span title="" data-toggle="tooltip" class="label-tooltip">Super Sub Category Name</span> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required placeholder="Enter Super  Sub  Category Name" name="super_sub_cat_name" class="form-control col-md-7 col-xs-12" id="name_m">
                    </div>
                  </div>
                       <div class="form-group">    
                <label for="name_m" class="control-label col-lg-3 required"> <span title="" data-toggle="tooltip" class="label-tooltip">Icon Image</span> </label> 
                    <input type="file" name="iconimage" style="width:265px !important;"   class="btn vd_btn vd_bg-green fileinput-button" />

<!--                   <div class="form-group control-label col-lg-4 required">
                    <table id="imageTable" class="table table-dragable">
                      <tr id="4">                                  
                        <button class="btn vd_btn vd_bg-yellow right" type="submit" name="submit" >Submit</button>
                      </tr>
                    </table>
                  </div>
-->                  </div>
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
<script type="text/javascript">
$(function(){
    $("#cat1").change(function(){
       var txt1=$("#cat1").val();
       //alert(txt1);
           $.ajax({
               url:"cat1.php",
               type:"post",
              data:{postdata1:txt1},
               success:function(res){
                if(res==0)
              document.getElementById("#show").style.display = "none"; 
              else
                  $("#show1").show(); 
                  $("#cat2").html(res);           
               }

           });
    });
  });

</script>
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