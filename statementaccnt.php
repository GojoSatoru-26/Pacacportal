<?php
require_once("include/initialize.php");
   
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
<body onload="window.print()">
<div class="wrapper"> 
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <h3 align="center">Statement of Accounts</h3>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <h4 class="page-header">
            <i class="fa fa-user"></i> Student Information
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h4>
        </div>
        <!-- /.col -->
      </div> 
      <table>
        <tr>
          <td width="75%" colspan="2" >
            <address>
            <b>Name : <?php echo $_SESSION['LNAME']. ', ' .$_SESSION['FNAME'] .' ' .$_SESSION['MI'];?></b><br>
            Address : <?php echo $_SESSION['PADDRESS'];?><br> 
            Contact No.: <?php echo $_SESSION['CONTACT'];?><br>
            
          </address>
          </td>
          <td >
             <b>Course/Year:  <?php 

            $course = New Course();
            $singlecourse = $course->single_course($_SESSION['COURSEID']);
            echo $_SESSION['COURSE_YEAR'] = $singlecourse->COURSE_NAME.'-'.$singlecourse->COURSE_LEVEL;
            $_SESSION['COURSELEVEL'] = $singlecourse->COURSE_LEVEL;
            ?></b><br>
          <b>Semester : <?php echo $_SESSION['SEMESTER']; ?></b> <br/>
          <b>Academic Year : <?php echo $_SESSION['SY']; ?></b>
          </td>
        </tr>
      </table>
         
<?php 
// if (isset($_POST['btnCartSubmit'])) {
  
  if (isset($_SESSION['gvCart'])){
  # code...
?>
<!-- Table row -->
<div class="row">
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped">
      <thead>
      <tr> 
        <th>Id</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Unit</th>  
      </tr>
      </thead>
      <tbody>
      <?php  
        $totunit = '';
          if (isset($_SESSION['gvCart'])){


             $count_cart = count($_SESSION['gvCart']);

                for ($i=0; $i < $count_cart  ; $i++) {  

                    $query = "SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND SUBJ_ID=" . $_SESSION['gvCart'][$i]['subjectid'];
                     $mydb->setQuery($query);
                     $cur = $mydb->loadResultList(); 
                      foreach ($cur as $result) { 

                         echo '<tr>';
                          // echo '<td width="5%" align="center"></td>';
                          echo '<td>' . $result->SUBJ_ID.'</a></td>';
                          echo '<td>'. $result->SUBJ_CODE.'</td>';
                          echo '<td>'. $result->SUBJ_DESCRIPTION.'</td>';
                          echo '<td>' . $result->UNIT.'</a></td>';
                          echo '</tr>';
                        
                          $totunit +=  $result->UNIT; 
                      }      
                }  
              } 
          ?>
      </tbody>
     </table>  
<?php
}else{ 
?> 
    <table class="table table-striped">
      <thead>
      <tr> 
        <th>Id</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Unit</th>  
      </tr>
      </thead>
      <tbody> 
      <?php 
       $totunit = 0;
      $mydb->setQuery("SELECT * FROM `subject` s, `course` c 
        WHERE s.COURSE_ID=c.COURSE_ID AND s.COURSE_ID=".$_SESSION['COURSEID']." AND SEMESTER='".$_SESSION['SEMESTER']."'");

      $cur = $mydb->loadResultList();

      foreach ($cur as $result) {
        echo '<tr>';
        echo '<td>'.$result->SUBJ_ID.'</td>';
        echo '<td>'.$result->SUBJ_CODE.'</td>'; 
        echo '<td>'.$result->SUBJ_DESCRIPTION.'</td>';
        echo '<td>'.$result->UNIT.'</td>';
        echo '</tr>';

        $totunit +=  $result->UNIT;
      }
      ?>
      <tr>
      <td colspan="3" align="right" >Total Units</td>
      <td><?php echo $totunit;?></td>
      </tr> 
      </tbody>
    </table> 
<?php
}
?>
   <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Tuition:</p>
        <p class="lead">

          <?php
          $totunit = $totunit <= 0 ? 0 : $totunit;
           $subtot = 0;
           $perunit = 209;
           $entrancefee = 5693;
           $totsem = 0;
           $subtot = $totunit * $perunit;
           $totsem = $entrancefee + $subtot;
           echo $totunit .' x  &#8369 ' . $perunit . ' =  &#8369 ' . $subtot ; 


           $_SESSION['SUBTOT'] = $subtot;
           $_SESSION['ENTRANCEFEE'] = $entrancefee;
           $_SESSION['TOTSEM'] = $totsem;
           $_SESSION['TOTUNIT'] = $totunit;
           ?> 
          </p>
          

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
           Description : This is the formula of amount per unit and its total.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6"> 
         <br/>
         <br/> 
            <table class="table">
              <tr>
                <th style="width:50%">Tuition Fees:</th>
                <td> &#8369 <?php echo  $subtot; ?></td>
              </tr>
              <tr>
                <th>Miscellaneous Fee</th>
                <td> &#8369 <?php echo  $entrancefee  ; ?></td>
              </tr> 
              <tr>
                <th>Total Semester:</th>
                <td> &#8369 <?php echo  $totsem; ?>
                <input type="hidden" id="totsem" name="totsem" value="<?php echo  $totsem; ?>">
                </td>
              </tr>
               
            </table>
          </div> 
        <!-- /.col -->
      </div>
      <!-- /.row --> 
    </section> 
    </div>
 </body>
 </html>