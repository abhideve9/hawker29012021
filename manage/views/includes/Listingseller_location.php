<style type="text/css">
  .modal-body-details b {
    color: #F30;
}
</style>
<!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Hawkers<small>Users Location</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">                      <thead>
                     <tr>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Device ID</th>
                        <th>Time</th>
                        
                     </tr>
                      </thead>
                      <tbody>
                     <?php 
                     $getUsers="SELECT * FROM gps_seller_location  ORDER BY id DESC LIMIT 10";
                     
                     $runUsers=mysqli_query($db,$getUsers);
                     while($rowUsers=mysqli_fetch_array($runUsers))
                     {
                     $id=$rowUsers['id'];
                     $latitude=$rowUsers['latitude'];
                     $longitude=$rowUsers['longitude'];
                     $shop_gps_id=$rowUsers['shop_gps_id'];
                     $registered_time=$rowUsers['registered_time'];

                     $getseller="SELECT name,mobile_no FROM login_manage_seller where device_id='$shop_gps_id'";
                     $runseller=mysqli_query($db,$getseller);
                     while($rowseller=mysqli_fetch_array($runseller))
                     {
                    
                     $name=$rowseller['name'];
                     $mobile_no=$rowseller['mobile_no'];

                     ?>
                        <tr class='odd gradeX'>
                        <td><?php echo ucfirst($name); ?></td>
                        <td><?php echo ucfirst($mobile_no); ?></td>
                        <td><?php echo $latitude; ?></td>
                        <td><?php echo $longitude; ?></td>
                        <td><?php echo ucfirst($shop_gps_id); ?></td>
                        <td><?php echo ucfirst($registered_time); ?></td>
                        </tr>
                          <?php
                          }
                        }
                        ?>   
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

        <!-- /page content -->

<script>
   $(document).ready(function(){

    $(document).on('click', '#getUser', function(e){
  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content').html(''); // leave this div blank
     $('#modal-loader').show();
     $.ajax({
          url: 'getuser.php',
          type: 'POST',
          data: 'id='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content').html(''); // blank before load.
          $('#dynamic-content').html(data); // load here
          $('#modal-loader').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader').hide();
     });

    });
});
</script>
 