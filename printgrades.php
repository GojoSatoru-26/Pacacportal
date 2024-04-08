 <?php
require_once("../../include/initialize.php");
  if(!isset($_SESSION['ACCOUNT_ID'])){
  redirect(web_root."admin/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Green Valley Foundation College INC.  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="<?php echo web_root; ?>admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo web_root; ?>admin/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo web_root; ?>admin/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo web_root; ?>admin/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
 
   <link href="<?php echo web_root; ?>admin/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo web_root; ?>admin/font/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <link href="<?php echo web_root; ?>admin/font/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="<?php echo web_root; ?>admin/css/dataTables.bootstrap.css" rel="stylesheet">
 
     <!-- datetime picker CSS -->
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
 <link href="<?php echo web_root; ?>css/datepicker.css" rel="stylesheet" media="screen">
 
 <link href="<?php echo web_root; ?>admin/css/costum.css" rel="stylesheet">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h4 class="page-header ">
          <i class="fa fa-globe"></i> Green Valley Foundation College INC.
           <small class="pull-right">Printed Date: <?php echo date('m/d/Y'); ?></small>
        </h4>
      </div>
      <!-- /.col -->
    </div>

  <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header" align="center">
            Student Grades
             
          </h2>
        </div> 
      </div> 
<?php
if (isset($_POST['IDNO'])) {
  # code...
   $stud = New Student();
   $resstud = $stud->single_student($_POST['IDNO']);

   $course = New Course();
   $rescourse = $course->single_course($resstud->COURSE_ID);
   
}
 

?> 
       <div class="container">
        <table style="max-width:100%" cellpadding="4" cellspacing="7" class="table">
          <thead>
            <th><label>Student :</label></th><th  ><label><?php echo  $resstud->FNAME .'' . $resstud->LNAME;?></label></th> 
            <th></th>
            <th>Course</th><th><?php echo $rescourse->COURSE_NAME; ?></th>
            </thead>
           <thead> 
            <th><label>Semester :</label></th><th  ><label><?php echo $_POST['SEMESTER'];?></label></th> 
            <th></th>
            <th>Year Level</th><th><?php echo $_POST['YEARLEVEL'] ?></th>
            </thead>
        </table>
      </div>
   


      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 col-md-12">
                  <table id="dash-table" class="table table-striped table-bordered table-hover table-responsive" style="font-size:12px" cellspacing="0">
        
          <thead>
            <tr>
              <th>ID</th>
              <th>
               <!-- <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');">  -->
              
               Subject</th>
              <th>Description</th> 
              <th>Unit</th> 
              <th>Average</th>
              <th>Remarks</th> 
         
            </tr> 
          </thead> 
          <tbody>
            <?php  
          
            $sql = "SELECT * FROM `tblstudent` st, `grades` g,`subject` s ,studentsubjects ss
            WHERE st.`IDNO`=g.`IDNO` and g.`SUBJ_ID`=s.`SUBJ_ID`  and s.`SUBJ_ID`=ss.`SUBJ_ID` 
            AND g.`IDNO`=ss.`IDNO` AND ss.`SEMESTER`='".$_POST['SEMESTER']."' AND LEVEL=".$_POST['YEARLEVEL']." 
            and st.`IDNO`=".$_POST['IDNO'];
              $mydb->setQuery($sql);

              $cur = $mydb->loadResultList();

            foreach ($cur as $result) {
              echo '<tr>'; 
              echo '<td>' . $result->SUBJ_ID.'</a></td>';
              echo '<td>'. $result->SUBJ_CODE.'</td>';
              echo '<td>'. $result->SUBJ_DESCRIPTION.'</td>';
              echo '<td>' . $result->UNIT.'</a></td>'; 
              echo '<td>'. $result->AVE.'</td>'; 
              echo '<td>'. $result->REMARKS.'</td>'; 
              // echo '<td>'. $result->SEMESTER.'</td>'; 
              echo '</tr>';
            } 
            ?>
          </tbody>
          
        </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

        </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
