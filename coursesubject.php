<?php

if (isset($_POST['btnCartSubmit'])) {
  # code...
  $query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
            $result = mysqli_query($mydb->conn,$query) or die(mysqli_error($mydb->conn));
            $row = mysqli_fetch_assoc($result);

$sql = "SELECT sum(UNIT) as 'Unit' FROM subject WHERE COURSE_ID =".$row['COURSE_ID']." AND SEMESTER='" .$_SESSION['SEMESTER']."'";
$result = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
$totunits = mysqli_fetch_assoc($result);


// echo $totunits['Unit']; 
// units to be taken
$totunit =0;

            $query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
            $result = mysqli_query($mydb->conn,$query) or die(mysqli_error($mydb->conn));
            $row = mysqli_fetch_assoc($result);

            $query = "SELECT * 
                      FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID
                      AND COURSE_NAME='".$row['COURSE_NAME']."' AND COURSE_LEVEL=".$row['YEARLEVEL']."
                      AND  SEMESTER ='".$_SESSION['SEMESTER']."' AND
                      NOT FIND_IN_SET(  `PRE_REQUISITE` , ( 
                      SELECT GROUP_CONCAT(SUBJ_CODE SEPARATOR ',') FROM tblstudent s,grades g,subject sub
                      WHERE s.IDNO=g.IDNO AND g.SUBJ_ID=sub.SUBJ_ID AND AVE <=74.5 
                      AND  s.IDNO =" .$_SESSION['IDNO'].")
                      )";

                $mydb->setQuery($query);
                $cur = $mydb->loadResultList(); 
                foreach ($cur as $result) {  
                   $totunit +=  $result->UNIT ;
                }
 
            if (isset( $_SESSION['gvCart'])){ 

             $count_cart = count($_SESSION['gvCart']);

                for ($i=0; $i < $count_cart  ; $i++) {  

                    $query = "SELECT * FROM `subject` s, `course` c 
                    WHERE s.COURSE_ID=c.COURSE_ID AND SUBJ_ID=" . $_SESSION['gvCart'][$i]['subjectid'];
                     $mydb->setQuery($query);
                     $cur = $mydb->loadResultList(); 
                      foreach ($cur as $result) {   
                           $totunit +=  $result->UNIT ;
                      }  
                }
  
              } 


    if ($totunit > $totunits['Unit']) {
      # code...
    message("Warning....! Your total units have exceeded, ".$totunits['Unit'] ." units are only allowed to taken.","error");
    redirect("index.php?q=cart"); 
    } 
}


//  if (isset($_POST['regsubmit'])) {

// $_SESSION['STUDID']     =  $_POST['IDNO'];
// $_SESSION['FNAME']        =  $_POST['FNAME'];
// $_SESSION['LNAME']      =  $_POST['LNAME'];
// $_SESSION['MI']           =  $_POST['MI'];
// $_SESSION['PADDRESS']     =  $_POST['PADDRESS'];
// $_SESSION['SEX']          =  $_POST['optionsRadios'];
// $_SESSION['BIRTHDATE']    = date_format(date_create($_POST['BIRTHDATE']),'Y-m-d'); 
// $_SESSION['NATIONALITY']  =  $_POST['NATIONALITY'];
// $_SESSION['BIRTHPLACE']   =  $_POST['BIRTHPLACE'];
// $_SESSION['RELIGION']     =  $_POST['RELIGION'];
// $_SESSION['CONTACT']      =  $_POST['CONTACT'];
// $_SESSION['CIVILSTATUS']  =  $_POST['CIVILSTATUS'];
// $_SESSION['GUARDIAN']     =  $_POST['GUARDIAN'];
// $_SESSION['GCONTACT']     =  $_POST['GCONTACT'];
// $_SESSION['COURSEID']     =  $_POST['COURSE'];
// // $_SESSION['SEMESTER']     =  $_POST['SEMESTER'];  
// $_SESSION['USER_NAME']    =  $_POST['USER_NAME']; 
// $_SESSION['PASS']       =  $_POST['PASS']; 



//   $student = New Student();
//   $res = $student->find_all_student($_POST['LNAME'],$_POST['FNAME'],$_POST['MI']);

// if ($res) {
//   # code...
//     message("Student already exist.", "error");
//     redirect(web_root."index.php?q=enrol");

//  }else{

// $sql="SELECT * FROM tblstudent WHERE ACC_USERNAME='" . $_SESSION['USER_NAME'] . "'";
// $userresult = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
// $userStud  = mysqli_fetch_assoc($userresult);

// if($userStud){
//   message("Username is already taken.", "error");
//     redirect(web_root."index.php?q=enrol");
// }else{
//   if($_SESSION['COURSEID']=='Select' || $_SESSION['SEMESTER']=='Select' ){
//     message("Select course and semester exactly" , "error");
//     redirect("index.php?q=enrol");

//   }else{


//     $age = date_diff(date_create($_SESSION['BIRTHDATE']),date_create('today'))->y;

//     if ($age < 15){
//        message("Invalid age. 15 years old and above is allowed to enrol.", "error");
//        redirect("index.php?q=enrol");

//     }else{
//       # code...
   
//     $student = New Student();
//     $student->IDNO        = $_SESSION['STUDID'];
//     $student->FNAME       = $_SESSION['FNAME'];
//     $student->LNAME       = $_SESSION['LNAME'];
//     $student->MNAME       = $_SESSION['MI'];
//     $student->SEX         = $_SESSION['SEX'];
//     $student->BDAY        = $_SESSION['BIRTHDATE'];
//     $student->BPLACE      = $_SESSION['BIRTHPLACE'];
//     $student->STATUS      = $_SESSION['CIVILSTATUS'];
//     $student->NATIONALITY = $_SESSION['NATIONALITY'];
//     $student->RELIGION    = $_SESSION['RELIGION'];
//     $student->CONTACT_NO  = $_SESSION['CONTACT'];
//     $student->HOME_ADD    = $_SESSION['PADDRESS'];
//     $student->ACC_USERNAME  = $_SESSION['USER_NAME'];
//     $student->ACC_PASSWORD  = sha1($_SESSION['PASS']);
//     $student->COURSE_ID     = $_SESSION['COURSEID'];
//     $student->SEMESTER      = $_SESSION['SEMESTER']; 
//     $student->student_status ='New';
//     $student->YEARLEVEL     = 1; 
//     $student->NewEnrollees  = 1; 
//     $student->create();

//     $studentdetails = New StudentDetails();
//     $studentdetails->IDNO = $_SESSION['STUDID'];
//     $studentdetails->GUARDIAN = $_SESSION['GUARDIAN'];
//     $studentdetails->GCONTACT = $_SESSION['GCONTACT']; 
//     $studentdetails->create(); 

//     $studAuto = New Autonumber();
//     $studAuto->studauto_update();

//     @$_SESSION['IDNO'] = $_SESSION['STUDID'];
//    }
//     // redirect("index.php?q=profile");
//   }
//  }
// }
// } 


?>
<form action="index.php?q=payment" method="POST">
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
 <!-- Main content -->
 <?php   //check_message();  ?> 
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h3 class="page-header">
            <i class="fa fa-user"></i> Student Information
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h3>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-8 invoice-col"> 
          <address>
            <b>Name : <?php echo $_SESSION['LNAME']. ', ' .$_SESSION['FNAME'] .' ' .$_SESSION['MI'];?></b><br>
            Address : <?php echo $_SESSION['PADDRESS'];?><br> 
            Contact No.: <?php echo $_SESSION['CONTACT'];?><br>
            
          </address>
        </div>
    
        <div class="col-sm-4 invoice-col">
          <b>Course/Year:  <?php 
            $course = New Course();
            $singlecourse = $course->single_course($_SESSION['COURSEID']);
            $_SESSION['Course_name'] = $singlecourse->COURSE_NAME;

          if (isset($_SESSION['STUDID'])) {
            # code...
            
               $_SESSION['COURSELEVEL'] = $singlecourse->COURSE_LEVEL ;
          }elseif(isset($_SESSION['IDNO'])){
             $stud = New Student();
              $singleStud = $stud->single_student($_SESSION['IDNO']);
              $_SESSION['COURSELEVEL'] = $singleStud->YEARLEVEL ;
          }
        

           

            echo $_SESSION['COURSE_YEAR'] = $singlecourse->COURSE_NAME.'-'.$_SESSION['COURSELEVEL'];
           
            ?></b><br>
          <b>Semester : <?php echo $_SESSION['SEMESTER']; ?></b> <br/>
          <b>Academic Year : <?php echo $_SESSION['SY']; ?></b>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <h3 class="page-header">
            <i class="fa fa-book"></i> List of Subjects
            <!-- <small class="pull-right">Date: 2/10/2014</small> -->
          </h3>
        </div>
        <!-- /.col -->
      </div>
 
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

      $query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
      $result = mysqli_query($mydb->conn,$query) or die(mysqli_error($mydb->conn));
      $row = mysqli_fetch_assoc($result);

      if ($row['student_status']=='Irregular') {
        # code...
            $totunit = 0;

            $query = "SELECT * 
                      FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID
                      AND COURSE_NAME='".$row['COURSE_NAME']."' AND COURSE_LEVEL=".$row['YEARLEVEL']."
                      AND  SEMESTER ='".$_SESSION['SEMESTER']."' AND
                      NOT FIND_IN_SET(  `PRE_REQUISITE` , ( 
                      SELECT GROUP_CONCAT(SUBJ_CODE SEPARATOR ',') FROM tblstudent s,grades g,subject sub
                      WHERE s.IDNO=g.IDNO AND g.SUBJ_ID=sub.SUBJ_ID AND AVE <=74.5 
                      AND  s.IDNO =" .$_SESSION['IDNO'].")
                      )";

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
                   $totunit +=  $result->UNIT ;
                }



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

      }else{
          $totunit = '';
          $mydb->setQuery("SELECT * FROM `subject` s, `course` c 
          WHERE s.COURSE_ID=c.COURSE_ID AND CONCAT(`COURSE_NAME` ,  '-',  `COURSE_LEVEL` ) ='".$_SESSION['COURSE_YEAR']."' AND SEMESTER='".$_SESSION['SEMESTER']."'");

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
      }
      
          ?>
           <tr>
            <td colspan="3" align="right" >Total Units</td>
            <td><?php echo $totunit;?></td>
            </tr> 
      </tbody>
     </table>  
 
   <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Tuition:</p>
        <p class="lead">

          <?php

           $subtot = '';
           $perunit = 209;
           $entrancefee = 5693;
           $totsem = 0;

           $subtot = $totunit * $perunit;
           $totsem = $entrancefee + $subtot;
           echo$totunit .' x ' . ' &#8369 ' . $perunit . ' =  &#8369 ' . $subtot ; 


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
          <!-- <p class="lead">Amount Due 2/22/2014</p> -->

         <br/>
         <br/>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Tuition Fees:</th>
                <td>  &#8369 <?php echo  $subtot; ?></td>
              </tr>
              <tr>
                <th>Miscellaneous Fee</th>
                <td> &#8369 <?php echo  $entrancefee  ; ?></td>
              </tr>
              <!-- <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr> -->
              <tr>
                <th>Total Semester:</th>
                <td> &#8369 <?php echo  $totsem; ?>
                <input type="hidden" id="totsem" name="totsem" value="<?php echo  $totsem; ?>">
                </td>
              </tr>
              <?php
              $student = New Student();
              $result = $student->single_student($_SESSION['IDNO']);

              if ($result->student_status=='Regular' || $result->student_status=='Irregular') { 
              ?>
              <tr>
                <th>Partial Payment:</th>
                <td><input type="text" id="PartialPayment" autocompete="false" name="PartialPayment" required="true"></td>
              </tr>
              <tr>
                <th>Balance:</th>
                <td> &#8369 <span id="Balance">0.00</span>
                <input type="hidden" id="txtBalance" name="txtBalance" value="">
                </td>
              </tr>
              <?php
                }
              ?>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-9">
          <a href="statementaccnt.php" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <a href="index.php?q=profile" target="_blank" class="btn btn-default"><i class="fa fa-user"></i> Go to your profile</a>
         <!--  <button type="hidden" name="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button> -->
      </div>
      <div class="col-xs-3">
         </form>
         <?php
          if ($result->student_status=='Regular' || $result->student_status=='Irregular') { 

         ?>
       
          <form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
           <input type="hidden" value="business@greenvalley.com" name="business">
          <!-- Specify a Buy Now button. -->
          <input type="hidden" value="_xclick" name="cmd">
          <input type="hidden" value="Partial Payments" name="item_name">
          <!-- <input type="hidden" value="22.16" name="amount"> -->
          <input type="hidden" id="partial" value="1600" name="amount">
          <!-- <input type="hidden" name="currency_code" value="USD"> -->
          <input type="hidden" name="currency_code" value="PHP">
          <!-- <input type="hidden" value="item_number" name="item_number"> -->
          <input type="hidden" name="return" value="http://localhost<?php echo web_root ?>index.php?q=payment">
          <input type="hidden" name="cancel_return" value="http://localhost<?php echo web_root ?>index.php">
          <!-- Display the payment button. -->
          <input type="image" name="submit" id="btnpay" border="0" src="img/BTNPAYNOW.png" alt="PayPal - The safer, easier way to pay online">
          <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
          </form> 
          <?php
}
          ?>
        </div>
      </div>
    </section> 
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
<!--  
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="48ZBBK2C2CGSE">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form> -->

<!-- <form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr"> -->
<!-- Identify your business so that you can collect the payments. -->
<!-- <input type="hidden" value="dasun_1358759028_biz@archmage.lk" name="business"> -->


<!-- <input type="hidden" value="janobe123456@business.com" name="business"> -->
<!-- Specify a Buy Now button. -->
<!-- <input type="hidden" value="_xclick" name="cmd"> -->
<!-- Specify details about the item that buyers will purchase. -->
<!-- <input type="hidden" value="AM Test Item" name="item_name"> -->
<!-- <input type="hidden" value="Partial Payments" name="item_name"> -->
<!-- <input type="hidden" value="22.16" name="amount"> -->
<!-- <input type="hidden" value="1600" name="amount"> -->
<!-- <input type="hidden" name="currency_code" value="USD"> -->
<!-- <input type="hidden" name="currency_code" value="PHP">
<input type="hidden" value="item_number" name="item_number">
<input type="hidden" name="return" value="http://localhost:8888/paypal/success.php"> -->
<!-- Display the payment button. -->
<!-- <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
<img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
</form>  -->