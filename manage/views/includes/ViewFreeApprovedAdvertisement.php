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
                    <h2>Free Advertisement <b>(Approved Advertisements)</b></h2>
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
                          <th>Hawker Code</th>
                          <th>Mobile No.</th>
                          <th>Advertisement Title</th>
                          <!--<th>Detail</th>-->
                          <th>Image 1</th>
                          <th>Image 2</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Edit</th>
                          <th>Option</th>
                          <!--<th>Notification</th>-->
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM tbl_request_for_hawker_advertisement where aproval_status='1' AND status='1'";
                          $runUsers=mysqli_query($db,$getUsers);
                          $i=1;
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          //$hawker_code=$rowUsers['hawker_code'];
                          $hawker_code=$rowUsers['hawker_code'];
                          $mobile_no=$rowUsers['mobile_no'];
                          $advertisement_title=$rowUsers['advertisement_title'];
                          //$detail_of_advertisement=$rowUsers['detail_of_advertisement'];
                         
                          $image_1=$rowUsers['image_1'];
                          $image_2=$rowUsers['image_2'];
                          $start_date=$rowUsers['start_date'];
                          $end_date=$rowUsers['end_date'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $hawker_code; ?></td>
                        <td><?php echo $mobile_no; ?></td>
                        <td><?php echo $advertisement_title; ?></td>
                        <!--<td><?php echo $detail_of_advertisement; ?></td>-->
                        
                      <td><a  class="example-image-link" href="data:image/png;base64, <?php echo $image_1; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $image_1; ?>"/></a></td>


                      <td><a class="example-image-link" href="data:image/png;base64, <?php echo $image_2; ?>" data-lightbox="example-1" data-title="Click the right half of the image to move forward."><img id="myImg" style="width:50px; height:70px;" class='example-image' src="data:image/png;base64, <?php echo $image_2; ?>"/></a></td>

                        <td><?php echo $start_date; ?></td>
                        <td><?php echo $end_date; ?></td>
                        <td class='menu-action'>
                        <a data-original-title='
                        ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_free_advertisement' href='advertisement.php?action=edit_free_advertisement1&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a>
                       </td>
                       <?php 
                       if($rowUsers['aproval_status']==0)
                       {
                       ?>
                       <td>
                        <a href='advertisement.php?action=approve_free_advertisement&id=<?php echo $id; ?>'><button type="submit" class="btn btn-danger" value="submit">Approve</button></a> 
                       </td>
                        <?php
                         }
                         else
                         {
                         ?>
                         <td>
                          <a  href='advertisement.php?action=disapprove_free_advertisement&id=<?php echo $id; ?>'><button type="button" class="btn btn-success">Disapprove</button> </a> 
                        </td>
                        <?php
                         }
                         ?> 
                       <!--<td>
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
 
   $(document)
    .ready(function () {
        $('#peopleindex').dataTable({

            "autoWidth": false,
            "lengthChange": false,
            "pageLength": 10,
               dom: 'Bfrtip',
              buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]

        });
});

</script>
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
  