<?php


$student = New Student();
$res = $student->find_all_student($_POST['LNAME'],$_POST['FNAME']);

if ($res) {
	# code...
	message("Student already exist.", "error");
      redirect(web_root."index.php?q=enrol");
}else{
// unset($_SESSION['STUDID']);
// unset($_SESSION['FNAME']);
// unset($_SESSION['LNAME']);
// unset($_SESSION['MI']);
// unset($_SESSION['PADDRESS']);
// unset($_SESSION['SEX']);
// unset($_SESSION['BIRTHDATE']);
// // unset($_SESSION['MONTH']);
// // unset($_SESSION['DAY']);
// // unset($_SESSION['YEAR']);
// unset($_SESSION['BIRTHPLACE']);
// unset($_SESSION['RELIGION']);
// unset($_SESSION['CONTACT']);
// unset($_SESSION['CIVILSTATUS']);
// unset($_SESSION['GUARDIAN']);
// unset($_SESSION['GCONTACT']);
// unset($_SESSION['COURSEID']); 
// // unset($_SESSION['SY']);
// unset($_SESSION['USER_NAME']);
// unset($_SESSION['PASS']);


// echo $_SESSION['IDNO'] 	      =  $_POST['IDNO'];
// echo $_SESSION['FNAME'] 	      =  $_POST['FNAME'];
// echo $_SESSION['LNAME']  	  =  $_POST['LNAME'];
// echo $_SESSION['MI']           =  $_POST['MI'];
// echo $_SESSION['PADDRESS']     =  $_POST['PADDRESS'];
// echo $_SESSION['SEX']          =  $_POST['optionsRadios'];
// echo $_SESSION['MONTH']        =  $_POST['MONTH'];
// echo $_SESSION['DAY']          =  $_POST['DAY'];
// echo $_SESSION['YEAR']         =  $_POST['YEAR'];
// echo $_SESSION['BIRTHPLACE']   =  $_POST['BIRTHPLACE'];
// echo $_SESSION['RELIGION']     =  $_POST['RELIGION'];
// echo $_SESSION['CONTACT']      =  $_POST['CONTACT'];
// echo $_SESSION['CIVILSTATUS']  =  $_POST['CIVILSTATUS'];
// echo $_SESSION['GUARDIAN']     =  $_POST['GUARDIAN'];
// echo $_SESSION['GCONTACT']     =  $_POST['GCONTACT'];
// echo $_SESSION['COURSEID'] 	   =  $_POST['COURSE'];
// echo $_SESSION['SEMESTER']     =  $_POST['SEMESTER']; 
// echo $_SESSION['SY']  		  =  '';



$_SESSION['STUDID'] 	  =  $_POST['IDNO'];
$_SESSION['FNAME'] 	      =  $_POST['FNAME'];
$_SESSION['LNAME']  	  =  $_POST['LNAME'];
$_SESSION['MI']           =  $_POST['MI'];
$_SESSION['PADDRESS']     =  $_POST['PADDRESS'];
$_SESSION['SEX']          =  $_POST['optionsRadios'];
$_SESSION['BIRTHDATE']    = date_format(date_create($_POST['BIRTHDATE']),'Y-m-d');
// $_SESSION['MONTH']        =  $_POST['MONTH'];
// $_SESSION['DAY']          =  $_POST['DAY'];
$_SESSION['NATIONALITY']  =  $_POST['NATIONALITY'];
$_SESSION['BIRTHPLACE']   =  $_POST['BIRTHPLACE'];
$_SESSION['RELIGION']     =  $_POST['RELIGION'];
$_SESSION['CONTACT']      =  $_POST['CONTACT'];
$_SESSION['CIVILSTATUS']  =  $_POST['CIVILSTATUS'];
$_SESSION['GUARDIAN']     =  $_POST['GUARDIAN'];
$_SESSION['GCONTACT']     =  $_POST['GCONTACT'];
$_SESSION['COURSEID'] 	  =  $_POST['COURSE']; 
// $_SESSION['SY']  		  =  '';
$_SESSION['USER_NAME']    =  $_POST['USER_NAME']; 
$_SESSION['PASS']    	  =  $_POST['PASS']; 


if($_SESSION['COURSEID']=='Select' || $_SESSION['SEMESTER']=='Select' ){
	message("Select course and semester exactly","error");
	redirect("index.php?q=enrol");

}else{
	redirect("index.php?q=subject");
}
}
?>