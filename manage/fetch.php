<?php  
 //fetch.php  
 if(isset($_POST["id"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "Goolean@123#", "fixer");  
      $query = "SELECT * FROM tbl_request_for_hawker_advertisement WHERE id='".$_POST["id"]."'";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_array($result))  
      {  
           $output = '  
                <p><img src="data:image/png;base64,'.$row["image_1"].'" class="img-responsive img-thumbnail" /></p> 
                <p><img src="data:image/png;base64,'.$row["image_2"].'" class="img-responsive img-thumbnail" /></p>  
               
           ';  
      }  
      echo $output;  
 }  
 ?>  