.<?php
include "db.php";
$locations=array();
$query = "SELECT  sales_id,shop_latitude,shop_longitude,registered_time,user_type,business_name FROM registration_sellers where verification_status='1'";
/*$query1="SELECT sales_id,shop_latitude,shop_longitude FROM registration_sellers WHERE user_type='Moving'";*/
$run_type = mysqli_query($db, $query);
/*$run_type1 = mysqli_query($db, $query1);*/
?>
<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <!-- <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script> -->

          <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChKniIN58_YEQOlqOTdzFjY7o8hLqKaX8"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
body, html {
  height: 98.5%;
  width: 99.5%;
}

div#content {
  width: 100%; height: 100%;
}
</style>
  </head> 
<body>
  <div id="map" style="width: 100%; height: 100%;"></div>

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
          $sales_id=$row_type['sales_id'];
          $query1="SELECT name FROM login_manage_sales WHERE user_id='$sales_id'";
          $run_type1 = mysqli_query($db, $query1);
           while($row_type1=mysqli_fetch_array($run_type1))
           {

            $name=$row_type1['name'];
             //$business_name=$row_type['business_name'];
             $registered_time=$row_type['registered_time'];
             $user_type=$row_type['user_type'];
             $datacat="Name : ".$name." <br> Shop Name: ".$business_name." <br> Registration Time: ".$registered_time." <br> User type: ".$user_type."";
              echo '["'.$datacat.'",'.$row_type['shop_latitude'].', '.$row_type['shop_longitude'].'],';
            }
           }
        
        ?>
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 09,
      center: new google.maps.LatLng(28.40697738, 77.04223911),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    $.ajax({
      url : 'http://15.206.105.254/hawker/index.php/customer/api/location_mapped',
      type : "get",
      data : {},
      success:function(response)
      {
        console.log(response);
      }
    });
    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
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
  </script>

</body>
</html>