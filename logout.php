<?php 
require_once 'include/initialize.php';
// Four steps to closing a session
// (i.e. logging out)





// 1. Find the session
@session_start();


 $sql="INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
          VALUES (".$_SESSION['IDNO'].",'".date('Y-m-d H:i:s')."','Student','Logged out')";
          $mydb->setQuery($sql);
          $mydb->executeQuery();

// 2. Unset all the session variables
unset( $_SESSION['STUDID']);
// unset($_SESSION['STUDID']);
unset($_SESSION['FNAME']);
unset($_SESSION['LNAME']);
unset($_SESSION['MI']);
unset($_SESSION['PADDRESS']);
unset($_SESSION['SEX']);
unset($_SESSION['BIRTHDATE']);
// unset($_SESSION['MONTH']);
// unset($_SESSION['DAY']);
unset($_SESSION['NATIONALITY']);
unset($_SESSION['BIRTHPLACE']);
unset($_SESSION['RELIGION']);
unset($_SESSION['CONTACT']);
unset($_SESSION['CIVILSTATUS']);
unset($_SESSION['GUARDIAN']);
unset($_SESSION['GCONTACT']);
unset($_SESSION['COURSEID']);
unset($_SESSION['SEMESTER']);
// unset($_SESSION['SY']);
unset($_SESSION['USER_NAME']);
unset($_SESSION['GCONTACT']);
unset($_SESSION['GUARDIAN']);
unset($_SESSION['PASS']);
unset( $_SESSION['SUBTOT']);
unset( $_SESSION['ENTRANCEFEE']);
unset( $_SESSION['COURSE_YEAR']);
unset( $_SESSION['TOTSEM']);
unset($_SESSION['IDNO']);
unset($_SESSION['gvCart']);
 
// unset( $_SESSION['USERID'] );
// unset( $_SESSION['CUSNAME'] );
// unset( $_SESSION['CUSUNAME'] );
// unset( $_SESSION['CUSUPASS'] ); 
// unset($_SESSION['gcCart']);
// unset($_SESSION['gcCart']);
// unset( $_SESSION['fixnmixConfiremd']);
// unset($_SESSION['gcNotify']);
// unset($_SESSION['orderdetails']);

// unset($_SESSION['FIRSTNAME']);
// unset($_SESSION['LASTNAME']);
// unset($_SESSION['ADDRESS']);
// unset($_SESSION['CONTACTNUMBER']);
 	
// 4. Destroy the session
// session_destroy();
redirect("index.php?logout=1");
?> 	 