<?php

@$IDNO = $_SESSION['STUDID'];
$COURSEID = $_SESSION['COURSEID'];
$COURSELEVEL = $_SESSION['COURSELEVEL'];
$SEMESTER = $_SESSION['SEMESTER'];
$TOTUNITS = $_SESSION['SUBTOT'];
$ENTRANCEFEE = $_SESSION['ENTRANCEFEE'];
$TOTSEM = $_SESSION['TOTSEM'];
// $PARTIAL = $_POST['PartialPayment'];


$query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
$result = mysqli_query($mydb->conn,$query) or die(mysqli_error($mydb->conn));
$row = mysqli_fetch_assoc($result);

if ($row['student_status']=='Irregular') {

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

			$studentsubject = New StudentSubjects();
			$studentsubject->IDNO 		= $_SESSION['IDNO'];
			$studentsubject->SUBJ_ID	= $result->SUBJ_ID;
			$studentsubject->LEVEL 		= $_SESSION['COURSELEVEL'];
			$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
			$studentsubject->SY 		= $_SESSION['SY'];
			$studentsubject->ATTEMP 	= 1; 
			$studentsubject->create();

			$grade = New Grade();
			$grade->IDNO = $_SESSION['IDNO'];
			$grade->SUBJ_ID	 = $result->SUBJ_ID;
			$grade->SEMS     = $_SESSION['SEMESTER'];
			$grade->create();
		}
 
		if (isset($_SESSION['gvCart'])) {
				 	# code... 
			$count_cart = count($_SESSION['gvCart']);

			for ($i=0; $i < $count_cart  ; $i++) {  

			    $query = "SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND SUBJ_ID=" . $_SESSION['gvCart'][$i]['subjectid'];
			     $mydb->setQuery($query);
			     $cur = $mydb->loadResultList(); 
			      foreach ($cur as $result) { 

			    //   	$sql = "SELECT * FROM `studentsubjects` WHERE  `IDNO`=". $_SESSION['IDNO']." AND `SUBJ_ID`=".$result->SUBJ_ID;
			    //   	 $mydb->setQuery($query);
			    //      $cur = $mydb->loadResultList(); 
			    //       foreach ($cur as $result) { 
			          	
			    //       	if (file_exists($result->SUBJ_ID)) {
			    //       		# code...
			    //       		 $studentsubject = New StudentSubjects();
							// $studentsubject->ATTEMP 	= $studentsubject->ATTEMP + 1; 
							// $studentsubject->LEVEL 		= $COURSELEVEL;
							// $studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
							// $studentsubject->SY 		= $_SESSION['SY'];
							// $studentsubject->updateSubject($result->SUBJ_ID,$_SESSION['IDNO']);
			    //       	}else{
			    //       		$studentsubject = New StudentSubjects();
							// $studentsubject->IDNO 		= $_SESSION['IDNO'];
							// $studentsubject->SUBJ_ID	= $result->SUBJ_ID;
							// $studentsubject->LEVEL 		= $COURSELEVEL;
							// $studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
							// $studentsubject->SY 		= $_SESSION['SY'];
							// $studentsubject->create();

			    //       	}
			    //       }

			      	$studentsubject = New StudentSubjects();
					$studentsubject->IDNO 		= $_SESSION['IDNO'];
					$studentsubject->SUBJ_ID	= $result->SUBJ_ID;
					$studentsubject->LEVEL 		= $_SESSION['COURSELEVEL'];
					$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
					$studentsubject->SY 		= $_SESSION['SY'];
					$studentsubject->ATTEMP 	= 1; 
					$studentsubject->create();

					$grade = New Grade();
					$grade->IDNO = $_SESSION['IDNO'];
					$grade->SUBJ_ID	 = $result->SUBJ_ID;
					$grade->SEMS     = $_SESSION['SEMESTER'];
					$grade->create();

					 
			      }      
			}  
		}

}else{

      	

      	$sql = "SELECT * FROM course WHERE COURSE_NAME='" .$_SESSION['Course_name']. "' AND COURSE_LEVEL =".$_SESSION['COURSELEVEL'];
      	$result = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
      	$row = mysqli_fetch_assoc($result);

		$mydb->setQuery("SELECT * FROM `subject` s, `course` c 
			WHERE s.COURSE_ID=c.COURSE_ID AND c.COURSE_ID=".$row['COURSE_ID']." AND SEMESTER='".$_SESSION['SEMESTER']."'");

			$cur = $mydb->loadResultList();

			foreach ($cur as $result) {
		 
			$studentsubject = New StudentSubjects();
			$studentsubject->IDNO 		= $_SESSION['IDNO'];
			$studentsubject->SUBJ_ID	= $result->SUBJ_ID;
			$studentsubject->LEVEL 		= $_SESSION['COURSELEVEL'];
			$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
			$studentsubject->SY 		= $_SESSION['SY'];
			$studentsubject->ATTEMP 	= 1; 
			$studentsubject->create();


			$grade = New Grade();
			$grade->IDNO = $_SESSION['IDNO'];
			$grade->SUBJ_ID	 = $result->SUBJ_ID;
			$grade->create();
		    }

		
}

	$sql = "INSERT INTO `schoolyr`
	           (`AY`, `SEMESTER`, `COURSE_ID`, `IDNO`, `CATEGORY`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`)
	    VALUES ('".$_SESSION['SY']."','".$_SESSION['SEMESTER']."','".$_SESSION['COURSEID']."','".$_SESSION['IDNO']."','ENROLLED','".date('Y-m-d')."','".date('Y-m-d')."','Old');";
	$res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));


	$sql = "INSERT INTO `tblpayment`
	 (`IDNO`, `COURSE_ID`, `COURSE_LEVEL`, `SEMESTER`, `ENTRANCEFEE`, `TOTALUNITS`, `TOTALSEMESTER`,PARTIALPAYMENT,BALANCE) 
	 VALUES(".$_SESSION['IDNO'].",".$COURSEID.",".$COURSELEVEL.",'".$SEMESTER."','".$ENTRANCEFEE."','".$TOTUNITS."','".$TOTSEM."','".@$PARTIAL."','".@$txtBalance."')";
	 $res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));

	 if($res){

	 	$query = "SELECT * FROM `tblstudent` WHERE `COURSE_ID`=". $COURSEID;
		$result = mysqli_query($mydb->conn,$query) or die(mysqli_error($mydb->conn));
		$numrow = mysqli_num_rows($result);
		// $maxrows = count($numrow);

        if ($numrow > 40) {
			# code...
			$student = New Student();   
			$student->STUDSECTION = 2;
			$student->update($_SESSION['IDNO']);
		}else{
			$student = New Student();   
			$student->STUDSECTION = 1;
			$student->update($_SESSION['IDNO']);
		}

	  
	 	unset($_SESSION['STUDID']);
	 	$studAuto = New Autonumber();
		$studAuto->studauto_update();

		
		unset($_SESSION['gvCart']);
        redirect("index.php?q=profile");
	 }

 
 
?> 
<script type="text/javascript">
	  $.getScript("http://www.site.com.br/busca_dados3.php?partial="+ Session.get("PartialPayment"), function(){

}
</script>

<?php
// @$txtBalance = $_POST['txtBalance'];
// @$PARTIAL = $_GET['partial'];

// if (isset($_POST['submit'])) {

// 	if ($PARTIAL < 1600) {
// 		# code...
// 		message("Payment is not valid. You have to pay 1000 in order to enroll.", "error");
// 		redirect("index.php?q=subject");
// 	}else{
// 	# code...



 
		// if(!isset($_SESSION['IDNO'])){
		// 		@$_SESSION['IDNO'] = $_SESSION['STUDID'];

		// 	    $student = New Student();
		// 		$student->IDNO 			= $_SESSION['IDNO'];
		// 		$student->FNAME 		= $_SESSION['FNAME'];
		// 		$student->LNAME 		= $_SESSION['LNAME'];
		// 		$student->MNAME 		= $_SESSION['MI'];
		// 		$student->SEX 			= $_SESSION['SEX'];
		// 		$student->BDAY 			= $_SESSION['BIRTHDATE'];
		// 		$student->BPLACE 		= $_SESSION['BIRTHPLACE'];
		// 		$student->STATUS 		= $_SESSION['CIVILSTATUS'];
		// 		$student->NATIONALITY 	= $_SESSION['NATIONALITY'];
		// 		$student->RELIGION 		= $_SESSION['RELIGION'];
		// 		$student->CONTACT_NO	= $_SESSION['CONTACT'];
		// 		$student->HOME_ADD 		= $_SESSION['PADDRESS'];
		// 		$student->ACC_USERNAME	= $_SESSION['USER_NAME'];
		// 		$student->ACC_PASSWORD 	= sha1($_SESSION['PASS']);
		// 		$student->COURSE_ID   	= $_SESSION['COURSEID'];
		// 		$student->SEMESTER   	= $_SESSION['SEMESTER'];
		// 		// $student->SYEAR   		= $_SESSION['SY'];
		// 		$student->student_status ='Regular';
		// 		$student->YEARLEVEL   	= $_SESSION['COURSELEVEL'];
		// 		// $student->FNAME = $_SESSION['FNAME'];
		// 		$student->create();


		// 		$studentdetails = New StudentDetails();
		// 		$studentdetails->IDNO = $_SESSION['IDNO'];
		// 		$studentdetails->GUARDIAN = $_SESSION['GUARDIAN'];
		// 		$studentdetails->GCONTACT = $_SESSION['GCONTACT']; 
		// 		$studentdetails->create(); 

		// 		$mydb->setQuery("SELECT * FROM `subject` s, `course` c 
		// 			WHERE s.COURSE_ID=c.COURSE_ID AND s.COURSE_ID=".$_SESSION['COURSEID']." AND SEMESTER='".$_SESSION['SEMESTER']."'");

		// 			$cur = $mydb->loadResultList();

		// 			foreach ($cur as $result) {
				 
		// 			$studentsubject = New StudentSubjects();
		// 			$studentsubject->IDNO 		= $_SESSION['IDNO'];
		// 			$studentsubject->SUBJ_ID	= $result->SUBJ_ID;
		// 			$studentsubject->LEVEL 		= $COURSELEVEL;
		// 			$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
		// 			$studentsubject->SY 		= $_SESSION['SY'];
		// 			$studentsubject->ATTEMP 	= 1; 
		// 			$studentsubject->create();


		// 			$grade = New Grade();
		// 			$grade->IDNO = $_SESSION['IDNO'];
		// 			$grade->SUBJ_ID	 = $result->SUBJ_ID;
		// 			$grade->create();
		// 		    }

		// 		$sql = "INSERT INTO `schoolyr`
		// 		               (`AY`, `SEMESTER`, `COURSE_ID`, `IDNO`, `CATEGORY`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`)
		// 		        VALUES ('".$_SESSION['SY']."','".$_SESSION['SEMESTER']."','".$_SESSION['COURSEID']."','".$_SESSION['IDNO']."','ENROLLED','".date('Y-m-d')."','".date('Y-m-d')."','New');";
		// 		$res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));

		// 	}else{


				 
		// 		 if (isset($_SESSION['gvCart'])) {
		// 		 	# code...
				
		// 			$count_cart = count($_SESSION['gvCart']);

		// 	                for ($i=0; $i < $count_cart  ; $i++) {  

		// 	                    $query = "SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND SUBJ_ID=" . $_SESSION['gvCart'][$i]['subjectid'];
		// 	                     $mydb->setQuery($query);
		// 	                     $cur = $mydb->loadResultList(); 
		// 	                      foreach ($cur as $result) { 

		// 	                      	$sql = "SELECT * FROM `studentsubjects` WHERE  `IDNO`=". $_SESSION['IDNO']." AND `SUBJ_ID`=".$result->SUBJ_ID;
		// 	                      	 $mydb->setQuery($query);
		// 		                     $cur = $mydb->loadResultList(); 
		// 		                      foreach ($cur as $result) { 
				                      	
		// 		                      	if (file_exists($result->SUBJ_ID)) {
		// 		                      		# code...
		// 		                      		 $studentsubject = New StudentSubjects();
		// 									$studentsubject->ATTEMP 	= $studentsubject->ATTEMP + 1; 
		// 									$studentsubject->LEVEL 		= $COURSELEVEL;
		// 									$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
		// 									$studentsubject->SY 		= $_SESSION['SY'];
		// 									$studentsubject->updateSubject($result->SUBJ_ID,$_SESSION['IDNO']);
		// 		                      	}else{
		// 		                      		$studentsubject = New StudentSubjects();
		// 									$studentsubject->IDNO 		= $_SESSION['IDNO'];
		// 									$studentsubject->SUBJ_ID	= $result->SUBJ_ID;
		// 									$studentsubject->LEVEL 		= $COURSELEVEL;
		// 									$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
		// 									$studentsubject->SY 		= $_SESSION['SY'];
		// 									$studentsubject->create();

		// 		                      	}
		// 		                      }
 
		// 							$grade = New Grade();
		// 							$grade->IDNO = $_SESSION['IDNO'];
		// 							$grade->SUBJ_ID	 = $result->SUBJ_ID;
		// 							$grade->SEMS     = $_SESSION['SEMESTER'];
		// 							$grade->create();

		// 							$sql = "INSERT INTO `schoolyr`
		// 							(`AY`, `SEMESTER`, `COURSE_ID`, `IDNO`, `CATEGORY`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`)
		// 							VALUES ('".$_SESSION['SY']."','".$_SESSION['SEMESTER']."','".$_SESSION['COURSEID']."','".$_SESSION['STUDID']."','ENROLLED','".date('Y-m-d')."','".date('Y-m-d')."','Old');";
		// 							$res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
		// 	                      }      
		// 	                }  
		// 	              }else{

			              	

		// 	              	$sql = "SELECT * FROM course WHERE COURSE_NAME='" .$_SESSION['Course_name']. "' AND COURSE_LEVEL =".$_SESSION['COURSELEVEL'];
		// 	              	$result = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
		// 	              	$row = mysqli_fetch_assoc($result);

		// 					$mydb->setQuery("SELECT * FROM `subject` s, `course` c 
		// 						WHERE s.COURSE_ID=c.COURSE_ID AND c.COURSE_ID=".$row['COURSE_ID']." AND SEMESTER='".$_SESSION['SEMESTER']."'");

		// 						$cur = $mydb->loadResultList();

		// 						foreach ($cur as $result) {
							 
		// 						$studentsubject = New StudentSubjects();
		// 						$studentsubject->IDNO 		= $_SESSION['IDNO'];
		// 						$studentsubject->SUBJ_ID	= $result->SUBJ_ID;
		// 						$studentsubject->LEVEL 		= $_SESSION['COURSELEVEL'];
		// 						$studentsubject->SEMESTER 	= $_SESSION['SEMESTER'];
		// 						$studentsubject->SY 		= $_SESSION['SY'];
		// 						$studentsubject->ATTEMP 	= 1; 
		// 						$studentsubject->create();


		// 						$grade = New Grade();
		// 						$grade->IDNO = $_SESSION['IDNO'];
		// 						$grade->SUBJ_ID	 = $result->SUBJ_ID;
		// 						$grade->create();
		// 					    }

		// 					$sql = "INSERT INTO `schoolyr`
		// 					               (`AY`, `SEMESTER`, `COURSE_ID`, `IDNO`, `CATEGORY`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`)
		// 					        VALUES ('".$_SESSION['SY']."','".$_SESSION['SEMESTER']."','".$_SESSION['COURSEID']."','".$_SESSION['IDNO']."','ENROLLED','".date('Y-m-d')."','".date('Y-m-d')."','Old');";
		// 					$res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));

		// 	              }
		// 	 }


			 // if ($_SESSION['SEMESTER']=='First' && $_SESSION['COURSELEVEL']==1 ) {
			 // 	# code...
			 // 	$student = New Student(); 
				// $student->student_status ='Regular'; 
				// $student->update($_SESSION['IDNO']);
			 // }

	// $sql = "SELECT sum(unit) as 'Unit' FROM `subject`  WHERE COURSE_ID=".$_SESSION['COURSEID'] ." AND SEMESTER'".$_SESSION['SEMESTER']."'";
	// $cur = mysqli_query($mydb->conn,$sql);
	// $unitresult = mysqli_fetch_assoc($cur);

	// $sql = "SELECT count(`UNIT`) as 'Unit' FROM `studentsubjects`  st,`subject` s 
	// WHERE st.`SUBJ_ID`=s.`SUBJ_ID` AND COURSE_ID=".$_SESSION['COURSEID']." AND s.SEMESTER'".$_SESSION['SEMESTER']."' AND IDNO=".$_SESSION['IDNO'];
	// $cur = mysqli_query($mydb->conn,$sql);
	// $stufunitresult = mysqli_fetch_assoc($cur);


	// 	if ($unitresult['Unit']==$stufunitresult['Unit']) {
	// 		# code...
	// 		$student = New Student(); 
	// 		$student->student_status ='Regular'; 
	// 		$student->update($_SESSION['IDNO']);
	// 	}else{
	// 		$student = New Student(); 
	// 		$student->student_status ='Irregular'; 
	// 		$student->update($_SESSION['IDNO']);
	// 	}
	

	// $sql = "INSERT INTO `tblpayment`
	//  (`IDNO`, `COURSE_ID`, `COURSE_LEVEL`, `SEMESTER`, `ENTRANCEFEE`, `TOTALUNITS`, `TOTALSEMESTER`,PARTIALPAYMENT,BALANCE) 
	//  VALUES(".$_SESSION['IDNO'].",".$COURSEID.",".$COURSELEVEL.",'".$SEMESTER."','".$ENTRANCEFEE."','".$TOTUNITS."','".$TOTSEM."','".@$PARTIAL."','".@$txtBalance."')";
	//  $res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));

	//  if($res){

	//  	$query = "SELECT * FROM `tblstudent` WHERE `COURSE_ID`=". $COURSEID;
	// 	$result = mysqli_query($mydb->conn,$query) or die(mysqli_error($mydb->conn));
	// 	$numrow = mysqli_num_rows($result);
	// 	// $maxrows = count($numrow);

 //        if ($numrow > 40) {
	// 		# code...
	// 		$student = New Student();   
	// 		$student->STUDSECTION = 2;
	// 		$student->update($_SESSION['IDNO']);
	// 	}else{
	// 		$student = New Student();   
	// 		$student->STUDSECTION = 1;
	// 		$student->update($_SESSION['IDNO']);
	// 	}

	  
	//  	unset($_SESSION['STUDID']);
	//  	$studAuto = New Autonumber();
	// 	$studAuto->studauto_update();

		
	// 	unset($_SESSION['gvCart']);
 //        redirect("index.php?q=profile");
	//  }


// 	} 
// } 
?>
<script>
// clear all session data
Session.clear();
  
// dump session data
Session.dump();
</script>