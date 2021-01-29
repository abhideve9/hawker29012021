<style type="text/css">
  .pagination1 a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination1 a.active {
  background-color: dodgerblue;
  color: white;
}
</style> 

<link href="bootstrap3.css" rel="stylesheet">  
  <!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Advertisement Plans <small>View Plans</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Plan Type</th>
                          <th>Value In Days</th>
                          <th>Amount</th>
                          <!-- <th>Edit</th>-->
                          <th>Option</th>
                          <!--<th>Notification</th>-->
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM ads_plans";
                          $runUsers=mysqli_query($db,$getUsers);
                          $i=1;
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          $plan_type=$rowUsers['plan_type'];
                          $value=$rowUsers['value'];
                          $amount=$rowUsers['amount'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $plan_type; ?></td>
                        <td><?php echo $value; ?></td>
                        <td><?php echo $amount; ?></td>
                       
                        <!--<td class='menu-action'>
                        <a data-original-title='
                        ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_free_advertisement' href='advertisement.php?action=edit_free_advertisement&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a>
                       </td>-->
                       <?php 
                       if($rowUsers['status']==0)
                       {
                       ?>
                       <td>
                        <a href='ads_plan.php?action=approve_ads_plan&id=<?php echo $id; ?>'><button type="submit" class="btn btn-danger"value="submit">Activate</button></a> 
                       </td>
                        <?php
                         }
                            else 
                         {
                          ?>
                          <td>
                          <a href='ads_plan.php?action=deactivate_ads_plan&id=<?php echo $id; ?>'><button type="submit" class="btn btn-success">Deactivate</button> </a> 
                        </td>
                           <!--<td>
                          <a href='ads_plan.php?action=deactivate&id=<?php echo $id; ?>'><button type="button" disabled="disabled" class="btn btn-success">Activated</button> </a> 
                        </td>-->
                          
                         <?php}
                         else
                         {
                         ?>
                         
                         
                        <?php
                         }
                      
                         ?> 
                      <!-- <td>
                        <a href='sendnotification.php?id=<?php echo $SalesID; ?>'><button type="button" class="btn btn-primary">Notification</button></a> 
                       </td> -->
                      </tr>

                      <?php
                      $i++;
                       }

                       ?>   
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        <!-- /page content -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%; height: 100%" >
      </div>
    </div>
  </div>
</div>
<script>
$(function() {
    $('.pop').on('click', function() {
      $('.imagepreview').attr('src', $(this).find('img').attr('src'));
      $('#imagemodal').modal('show');   
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
 