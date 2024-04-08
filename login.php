 <?php
 require_once ("include/initialize.php"); 
//  if (@$_GET['page'] <= 2 or @$_GET['page'] > 5) {
//   # code...
//     // unset($_SESSION['PRODUCTID']);
//     // // unset($_SESSION['QTY']);
//     // // unset($_SESSION['TOTAL']);
// } 


 
if(isset($_POST['sidebarLogin'])){
  $email = trim($_POST['U_USERNAME']);
  $upass  = trim($_POST['U_PASS']);
  $h_upass = sha1($upass);
  
   if ($email == '' OR $upass == '') {

      message("Invalid Username and Password!", "error");
      redirect(web_root."index.php");
         
    } else {   
        $stud = new Student();
        $studres = $stud->studAuthentication($email,$h_upass);

        if ($studres==true){
          
          $sql="INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
          VALUES (".$_SESSION['IDNO'].",'".date('Y-m-d H:i:s')."','Student','Logged in')";
          $mydb->setQuery($sql);
          $mydb->executeQuery();

           redirect(web_root."index.php?q=profile");
        }else{
             message("Invalid Username and Password! Please contact administrator", "error");
             redirect(web_root."index.php");
        }
 
 }
}

if(isset($_POST['oldLogin'])){
  $email = trim($_POST['U_USERNAME']);
  $upass  = trim($_POST['U_PASS']);
  $h_upass = sha1($upass);
  
   if ($email == '' OR $upass == '') {

      message("Invalid Username and Password!", "error");
      redirect(web_root."index.php");
         
    } else {   
        $stud = new Student();
        $studres = $stud->studAuthentication($email,$h_upass);

        if ($studres==true){
          
          $sql="INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
          VALUES (".$_SESSION['IDNO'].",'".date('Y-M-d h:i:s')."','Student','Logged in')";
          mysql_query($sql) or die(mysql_error());

           redirect(web_root."index.php?q=profile");
        }else{
             message("Invalid Username and Password! Please contact administrator", "error");
             redirect(web_root."index.php?q=enrol");
        }
 
 }
}


 if(isset($_POST['modalLogin'])){
  $email = trim($_POST['U_USERNAME']);
  $upass  = trim($_POST['U_PASS']);
  $h_upass = sha1($upass);
  
   if ($email == '' OR $upass == '') { 
      message("Invalid Username and Password!", "error");
       redirect(web_root."index.php?q=profile");
         
    } else {   
        $stud = new Student();
        $studres = $stud::studAuthentication($email,$h_upass);

        if ($studres==true){
           redirect(web_root."index.php?q=orderdetails");
        }else{
             message("Invalid Username and Password! Please contact administrator", "error");
             redirect(web_root."index.php");
        }
 
 }
 }
 ?> 
 

 