     <!--  <div class="form-group">
        <label class="control-label col-lg-3">Hawker Type</label>
        <div class="col-lg-3">
          <select id="cat1" width="50px" name="hawker_type" required>                     
           <option value="">Select State<?php
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
      </div> -->
      
    <div class="form-group">
      <div class="col-md-3 col-sm-3 col-xs-12">
      <select id="cat1" width="50px" class=" form-control" name="hawker_type" required>
        <option value="">Select State<?php
            $get_type = "select * from hawker_lunch_state where status='1'";
            $run_type = mysqli_query($db, $get_type);
            while($row_type=mysqli_fetch_array($run_type))
            {
              $id=$row_type['id'];
              $state_name = $row_type['state_name'];
              $state_code = $row_type['state_code'];
              echo "<option value='$state_code'>$state_name</option>";
             }
             ?>
            </option>
          </select>
        </div>
    </div>
<!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>city<small>For Users</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>State</th>
                          <th>City</th>
                          <th>Action</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM city_state_code where active_status='1'";
                          $runUsers=mysqli_query($db,$getUsers);
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          $city=$rowUsers['city'];
                          $state=$rowUsers['state'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $city; ?></td>
                        <td><?php echo $state; ?></td>
                        <td> <div class="btn-group">
                      <button type="button" class="btn btn-danger">Action</button>
                      <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Launch</a>
                        </li>
                        <li><a href="#">Comming Soon</a>
                        </li>
                        <li><a href="#">Pending</a>
                        </li>
                       
                      </ul>
                    </div>
</td>
                        </tr>
                      <?php
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
 