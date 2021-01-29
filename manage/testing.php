 <?php  
 $connect = mysqli_connect("localhost", "root", "Goolean@123#", "fixer");  
 $query = "SELECT * FROM tbl_request_for_hawker_advertisement ORDER BY id desc";  
 $result = mysqli_query($connect, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | PHP AJAX Jquery - Load Dynamic Content in Bootstrap Popover</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:800px;">  
                <h2 align="center">PHP AJAX Jquery - Load Dynamic Content in Bootstrap Popover</h2>  
                <h3 align="center">Employee Data</h3>                 
                <br /><br />  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                          <th>Id</th>
                          <th>Hawker Code</th>
                          <th>Mobile No.</th>
                          <th>Advertisement Title</th>
                          <!--<th>Detail</th>-->
                          <th>Image 1</th>
                          <th>Image 2</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          </tr>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                          ?>  
                          <tr> 
                               <td><?php echo $row["id"]; ?></td> 
                               <td><?php echo $row["hawker_code"]; ?></td>  
                               <td><?php echo $row["mobile_no"]; ?></td> 
                               <td><?php echo $row["advertisement_title"]; ?></td> 
                              
                               <td><a href="data:image/png;base64, <?php echo $row["image_1"]; ?>" class="hover" id="<?php echo $row["id"]; ?>"><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $row["image_1"]; ?>"/></a></td> 
                               <td><a href="data:image/png;base64, <?php echo $row["image_2"]; ?>" class="hover" id="<?php echo $row["id"]; ?>"><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $row["image_2"]; ?>"/></a></td>  
                               <td><?php echo $row["start_date"]; ?></td> 
                               <td><?php echo $row["end_date"]; ?></td> 
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
      $(document).ready(function(){  
           $('.hover').popover({  
                title:fetchData,  
                html:true,  
                placement:'right'  
           });  
           function fetchData(){  
                var fetch_data = '';  
                var element = $(this);  
                var id = element.attr("id");  
                $.ajax({  
                     url:"fetch.php",  
                     method:"POST",  
                     async:false,  
                     data:{id:id},  
                     success:function(data){  
                          fetch_data = data;  
                     }  
                });  
                return fetch_data;  
           }  
      });  
 </script> 