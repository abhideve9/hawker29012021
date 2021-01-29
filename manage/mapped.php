<?php
include "db.php";
$locations=array();
if(isset($_GET['sales']) and isset($_GET['fromdate']) and isset($_GET['todate']))
{
  $sales=$_GET['sales'];
  $fromdate=$_GET['fromdate'];
  $todate=$_GET['todate'];
  date_default_timezone_set('Asia/kolkata'); 
  $now = date('Y-m-d');
  if($fromdate>$now)
  {
  ?>
  <script>
  alert("Please Select Correct date format");
  location.href="action.php?action=show_mapped";
</script>
    <?php
  }
  else if($fromdate >$todate)
  {
    ?>
    <script>
  alert("Please Select Correct date format");
  location.href="action.php?action=show_mapped";
</script>
  <?php
  }

 $emp_query = "SELECT sales_id,shop_latitude,shop_longitude,registered_time,user_type,business_name FROM registration_sellers WHERE sales_id='$sales' and (verification_status ='1' or  verification_by_call = '1') and duty_status='1'";
  $emp_query .= " and date_time 
                          between '".$fromdate."' and '".$todate."' ";

                           // $emp_query .= " ORDER BY date_time DESC";
$run_type = mysqli_query($db, $emp_query);

$emp_query1 = "SELECT sales_id,shop_latitude,shop_longitude,registered_time,user_type,business_name   FROM registration_sellers WHERE sales_id='$sales' and (verification_status ='1' or  verification_by_call = '1') and duty_status='0'";
  $emp_query1 .= " and date_time 
                          between '".$fromdate."' and '".$todate."' ";
                      
$run_type_data = mysqli_query($db, $emp_query1);

$emp_query2 = "SELECT sales_id,shop_latitude,shop_longitude,registered_time,user_type,business_name   FROM registration_sellers WHERE sales_id='$sales' and (verification_status ='1' or  verification_by_call = '1') and duty_status='NULL'";
  $emp_query2 .= " and date_time 
                          between '".$fromdate."' and '".$todate."' ";
                      
$run_type_data1 = mysqli_query($db, $emp_query2);

}

?>
<!DOCTYPE html>
<html> 
<head> 

  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <!-- <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script> -->
          <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChKniIN58_YEQOlqOTdzFjY7o8hLqKaX8"></script>
          <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head> 
<body>
 <!--  <div class="row">
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
                         <input  type="date" name="fromdate" id="date" value="">
                    </div>
                    <br>
                    <div class="navbar1">
                    <b style=" color: #000000; padding-left: 187px;">End Date:</b>
                         <input  type="date" name="todate" id="date" value="">
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
            </div> -->
  <div id="map" style="width: 100%; height: 1750px;"></div>

  <script type="text/javascript">
 
    /*var locations = [
      ['Bondi Beach', 28.6141793, 77.2022662],
      ['Coogee Beach', 28.43971381702788, 77.508544921875],
      ['Cronulla Beach', 27.839076094777816, 78.06884765625001]
    ];*/
     // Multiple markers location, latitude, and longitude
    var locations = [
        <?php 
        while($row_type=mysqli_fetch_array($run_type))
        {
          $sales_id=$sales;
          $query1="SELECT name FROM login_manage_sales WHERE user_id='$sales_id'";
          $run_type1 = mysqli_query($db, $query1);
           while($row_type1=mysqli_fetch_array($run_type1))
           {

             $name=$row_type1['name'];
             $business_name=$row_type['business_name'];
             $registered_time=$row_type['registered_time'];
             $user_type=$row_type['user_type'];
             $datacat="Name : ".$name." <br> Shop Name: ".$business_name." <br> Registration Time: ".$registered_time." <br> User type: ".$user_type."";
           

                echo '["'.$datacat.'",'.$row_type['shop_latitude'].', '.$row_type['shop_longitude'].'],';
            }
           }
        
        ?>
    ];

    var locationlabs = [
        <?php 
        while($row_type_data=mysqli_fetch_array($run_type_data))
        {
          $sales_id=$sales;
          $querydata="SELECT name FROM login_manage_sales WHERE user_id='$sales_id'";
          $run_type_query = mysqli_query($db, $querydata);
           while($row_type_query=mysqli_fetch_array($run_type_query))
           {

             $name=$row_type_query['name'];
             $business_name=$row_type_data['business_name'];
             $registered_time=$row_type_data['registered_time'];
             $user_type=$row_type_data['user_type'];
             $datacat="Name : ".$name." <br> Shop Name: ".$business_name." <br> Registration Time: ".$registered_time." <br> User type: ".$user_type."";
           

                echo '["'.$datacat.'",'.$row_type_data['shop_latitude'].', '.$row_type_data['shop_longitude'].'],';
            }
           }
        
        ?>
    ];


    var locationlabs1 = [
        <?php 
        while($row_type_data1=mysqli_fetch_array($run_type_data1))
        {
          $sales_id=$sales;
          $querydata1="SELECT name FROM login_manage_sales WHERE user_id='$sales_id'";
          $run_type_query1 = mysqli_query($db, $querydata1);
           while($row_type_query1=mysqli_fetch_array($run_type_query1))
           {

             $name=$row_type_query1['name'];
             $business_name=$row_type_data1['business_name'];
             $registered_time=$row_type_data1['registered_time'];
             $user_type=$row_type_data1['user_type'];
             $datacat="Name : ".$name." <br> Shop Name: ".$business_name." <br> Registration Time: ".$registered_time." <br> User type: ".$user_type."";
           

                echo '["'.$datacat.'",'.$row_type_data1['shop_latitude'].', '.$row_type_data1['shop_longitude'].'],';
            }
           }
        
        ?>
    ];


    var map = new google.maps.Map(document.getElementById('map'), {

      zoom: 15,
      center: new google.maps.LatLng(28.40697738, 77.04223911),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
   
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
          
      icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
    
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

     var marker1, i;
    

    for (i = 0; i < locationlabs.length; i++) {  
      marker1 = new google.maps.Marker({
          
      icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
    
        position: new google.maps.LatLng(locationlabs[i][1], locationlabs[i][2]),
        map: map
      });

      google.maps.event.addListener(marker1, 'click', (function(marker1, i) {
        return function() {
          infowindow.setContent(locationlabs[i][0]);
          infowindow.open(map, marker1);
        }
      })(marker1, i));
    }

     var marker2, i;
    

    for (i = 0; i < locationlabs1.length; i++) {  
      marker2 = new google.maps.Marker({
          
      icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
    
        position: new google.maps.LatLng(locationlabs1[i][1], locationlabs1[i][2]),
        map: map
      });

      google.maps.event.addListener(marker2, 'click', (function(marker2, i) {
        return function() {
          infowindow.setContent(locationlabs1[i][0]);
          infowindow.open(map, marker2);
        }
      })(marker2, i));
    }
  
  </script>
<script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

   
     <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
  
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
</body>
</html>