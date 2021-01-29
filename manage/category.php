<!DOCTYPE html>
<html lang="en">
  <?php  include 'includes/head.php'; ?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
         <div class="left_col scroll-view">
           <?php include 'includes/nav_left.php'; ?>
          </div>
        </div>

        <!-- top navigation -->
        <?php 
          include 'includes/top_nav.php';
          ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

                <!-- Middle Content Start -->
    
    <div class="vd_content-wrapper">
      <div class="vd_container">
        <div class="vd_content clearfix">
          <div class="vd_head-section clearfix">
            <div class="vd_panel-header">
              <ul class="breadcrumb">
                <li><a href="index.php">Home</a> </li>
                <li>Category</li>
              </ul>
            </div>
          </div>
          
   <?php 
    if (isset($_GET['action'])) 
    {
        $link = $_GET['action'];
        if ($link === 'AddCategory') 
        {
            include 'views/includes/addcategory.php';
        }
        else if($link==='ActiveCategory')
        {
          include 'views/includes/activecategory.php';
        }
        else if($link==='editcategory')
        {
           include 'views/includes/editcategory.php';
        }
        else if($link==='AddSubCat')
        {
           include 'views/includes/addsubcat.php';
        }
        else if ($link === 'ActiveSubCat') 
        {
            include 'views/includes/activesubcat.php';
        }
        else if ($link === 'editsubcategory') 
        {
            include 'views/includes/editsubcategory.php';
        }
        else if($link==='AddSupersubcat')
        {
          include 'views/includes/add_super_sub_category.php';
        }
        else if($link==='ActiveSupersubcat')
        {
          include 'views/includes/active_super_subcat.php';
        }
        else if($link==='editsupercategory')
        {
           include 'views/includes/editsupercategory.php';
        }
      
    } 
 ?>

        </div>
      </div>
    </div>
    
          </div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
       <?php include 'includes/footer.php'; ?>
        <!-- /footer content -->
      </div>
    </div>
  </body>
</html>
