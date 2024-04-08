<?php
require_once ("../../include/initialize.php");
	 if (!isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;

	case 'addgrade' :
	doUpdateGrades();
	break;
	
	case 'delete' :
	doDelete();
	break;

	case 'photos' :
	doupdateimage();
	break;

 
	}
   
	function doInsert(){
		global $mydb;
		if(isset($_POST['save'])){


		if ($_POST['SUBJ_CODE'] == "" OR $_POST['SUBJ_DESCRIPTION'] == "" OR $_POST['UNIT'] == ""
			OR $_POST['PRE_REQUISITE'] == "" OR $_POST['COURSE_ID'] == "none"  OR $_POST['AY'] == ""  
			OR $_POST['SEMESTER'] == "" ) {
			$messageStats = false;
			message("All field is required!","error");
			redirect('index.php?view=add');
		}else{	
			$subj = New Subject();
			// $subj->USERID 		= $_POST['user_id'];
			$subj->SUBJ_CODE 		= $_POST['SUBJ_CODE'];
			$subj->SUBJ_DESCRIPTION	= $_POST['SUBJ_DESCRIPTION']; 
			$subj->UNIT				= $_POST['UNIT'];
			$subj->PRE_REQUISITE 	= $_POST['PRE_REQUISITE'];
			$subj->COURSE_ID		= $_POST['COURSE_ID']; 
			$subj->AY				= $_POST['AY']; 
			$subj->SEMESTER			= $_POST['SEMESTER'];
			$subj->create();

						// $autonum = New Autonumber();  `SUBJ_ID`, `SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`, `COURSE_ID`, `AY`, `SEMESTER`
						// $autonum->auto_update(2);

			message("New [". $_POST['SUBJ_CODE'] ."] created successfully!", "success");
			redirect("index.php");
			
		}
		}

	}

	function doEdit(){
		global $mydb;

	if(isset($_POST['save'])){

// $sql="SELECT * FROM tblstudent WHERE ACC_USERNAME='" . $_POST['USER_NAME'] . "'";
// $userresult = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
// $userStud  = mysqli_fetch_assoc($userresult);

// if($userStud){
// 	message("Username is already in used.", "error");
//     redirect(web_root."admin/student/index.php?view=view&id=".$_POST['IDNO']);
// }else{
	$age = date_diff(date_create($_POST['BIRTHDATE']),date_create('today'))->y;
 if ($age < 15){
       message("Invalid age. 15 years old and above is allowed.", "error");
       redirect("index.php?view=view&id=".$_POST['IDNO']);

    }else{
    	$stud = New Student();
		$stud->FNAME 				= $_POST['FNAME'];
		$stud->LNAME 				= $_POST['LNAME'];
		$stud->MNAME 				= $_POST['MI'];
		$stud->SEX 					= $_POST['optionsRadios'];
		$stud->BDAY 				= date_format(date_create($_POST['BIRTHDATE']),'Y-m-d');
		$stud->BPLACE 				= $_POST['BIRTHPLACE'];
		$stud->STATUS 				= $_POST['CIVILSTATUS'];
		$stud->NATIONALITY			= $_POST['NATIONALITY'];
		$stud->RELIGION 			= $_POST['RELIGION'];
		$stud->CONTACT_NO 			= $_POST['CONTACT'];
		$stud->HOME_ADD 			= $_POST['PADDRESS'];
		// $stud->ACC_USERNAME 		= $_POST['USER_NAME']; 
		$stud->update($_POST['IDNO']);


		$studetails = New StudentDetails();
		$studetails->GUARDIAN	 	= $_POST['GUARDIAN'];
		$studetails->GCONTACT 		= $_POST['GCONTACT'];
		$studetails->update($_POST['IDNO']);

		message("Student has been updated!", "success");
		redirect("index.php?view=view&id=".$_POST['IDNO']);
    }
			
	 
// }

		}
	}


	function doDelete(){
		global $mydb;
		
		// if (isset($_POST['selector'])==''){
		// message("Select the records first before you delete!","info");
		// redirect('index.php');
		// }else{

		// $id = $_POST['selector'];
		// $key = count($id);

		// for($i=0;$i<$key;$i++){

		// 	$subj = New User();
		// 	$subj->delete($id[$i]);

		
				$id = 	$_GET['id'];

				$subj = New Subject();
	 		 	$subj->delete($id);
			 
			message("User already Deleted!","info");
			redirect('index.php');
		// }
		// }

		
	}

	function doUpdateGrades(){
		global $mydb;

		if(isset($_POST['save'])){ 
			$remark = '';
			if($_POST['AVERAGE']>=75){
				$remark = 'Passed';
			}else{
				$remark = 'Failed';
			}

			$grade = New Grade(); 
			$grade->FIRST 				= $_POST['FIRSTGRADING'];
			$grade->SECOND				= $_POST['SECONDGRADING']; 
			$grade->THIRD				= $_POST['THIRDGRADING'];
			$grade->FOURTH 				= $_POST['FOURTHGRADING'];
			$grade->AVE					= $_POST['AVERAGE']; 
			$grade->REMARKS				= $remark;  
			$grade->update($_POST['GRADEID']);


			$studentsubject = New StudentSubjects(); 
			$studentsubject->AVERAGE	= $_POST['AVERAGE'];
			$studentsubject->OUTCOME 	=  $remark; 
			$studentsubject->updateSubject($_POST['SUBJ_ID'],$_POST['IDNO']);

// for checking the status

			$subject = New Subject();
  			$res = $subject->single_subject($_POST['SUBJ_ID']);
 

			$sql = "SELECT sum(`UNIT`) as 'Unit' FROM `subject`  WHERE COURSE_ID=".$res->COURSE_ID." AND SEMESTER='".$res->SEMESTER."'";
			$cur = mysqli_query($mydb->conn,$sql);
			$unitresult = mysqli_fetch_assoc($cur);
			 
			$sql = "SELECT sum(`UNIT`) as 'Unit' FROM `studentsubjects`  st,`subject` s 
			WHERE st.`SUBJ_ID`=s.`SUBJ_ID` AND COURSE_ID=".$res->COURSE_ID." AND s.SEMESTER='".$res->SEMESTER."' AND AVERAGE > 74 AND IDNO=".$_POST['IDNO'];
			$cur = mysqli_query($mydb->conn,$sql);
			$stufunitresult = mysqli_fetch_assoc($cur);
// echo $unitresult['Unit1'];
// echo $stufunitresult['Unit'];

				if ($unitresult['Unit']<>$stufunitresult['Unit']) {
					$student = New Student(); 
					$student->student_status ='Irregular'; 
					$student->update($_POST['IDNO']);
				}else{
						# code...
					$student = New Student(); 
					$student->student_status ='Regular'; 
					$student->update($_POST['IDNO']);
				}


// end
// for validating year level

			if ($res->SEMESTER<>'First') {
				# code...

			$sql = "SELECT (sum(unit)/2) as 'Unit' FROM `subject`  WHERE COURSE_ID=".$res->COURSE_ID;;
			$cur = mysqli_query($mydb->conn,$sql);
			$unitresult = mysqli_fetch_assoc($cur);




			$sql = "SELECT sum(`UNIT`) as 'Unit' FROM `studentsubjects`  st,`subject` s 
			WHERE st.`SUBJ_ID`=s.`SUBJ_ID` AND COURSE_ID=".$res->COURSE_ID."  AND AVERAGE > 74 AND IDNO=".$_POST['IDNO'];
			$cur = mysqli_query($mydb->conn,$sql);
			$stufunitresult = mysqli_fetch_assoc($cur);


				if ($unitresult['Unit'] < $stufunitresult['Unit']) {
					# code...
					$course = New Course();
					$courseresult = $course->single_course($res->COURSE_ID);
					switch ($courseresult->COURSE_LEVEL) {
						case 1:
							# code...
						$sql = "SELECT * FROM `course`  WHERE COURSE_NAME='".$courseresult->COURSE_NAME."' AND COURSE_LEVEL=2"; 
						$cur = mysqli_query($mydb->conn,$sql);
						$studcourse = mysqli_fetch_assoc($cur);

							$student = New Student(); 
							$student->COURSE_ID =$studcourse['COURSE_ID'];
							$student->YEARLEVEL =$studcourse['COURSE_LEVEL'];  
							$student->update($_POST['IDNO']);

							break;
						case 2:
							# code...

						$sql = "SELECT * FROM `course`  WHERE COURSE_NAME='".$courseresult->COURSE_NAME."' AND COURSE_LEVEL=3"; 
						$cur = mysqli_query($mydb->conn,$sql);
						$studcourse = mysqli_fetch_assoc($cur);

							$student = New Student(); 
							$student->COURSE_ID =$studcourse['COURSE_ID'];
							$student->YEARLEVEL =$studcourse['COURSE_LEVEL'];  
							$student->update($_POST['IDNO']);

							break;
						case 3:
							# code...

						$sql = "SELECT * FROM `course`  WHERE COURSE_NAME='".$courseresult->COURSE_NAME."' AND COURSE_LEVEL=4"; 
						$cur = mysqli_query($mydb->conn,$sql);
						$studcourse = mysqli_fetch_assoc($cur);

							$student = New Student(); 
							$student->COURSE_ID =$studcourse['COURSE_ID']; 
							$student->YEARLEVEL =$studcourse['COURSE_LEVEL']; 
							$student->update($_POST['IDNO']);

							break;
						
						default:
							# code...
							break;
							$sql = "SELECT * FROM `course`  WHERE COURSE_NAME='".$courseresult->COURSE_NAME."' AND COURSE_LEVEL=1"; 
							$cur = mysqli_query($mydb->conn,$sql);
							$studcourse = mysqli_fetch_assoc($cur);

								$student = New Student(); 
								$student->COURSE_ID =$studcourse['COURSE_ID']; 
								$student->YEARLEVEL =$studcourse['COURSE_LEVEL']; 
								$student->update($_POST['IDNO']);
					}
				
				 


				}



			}


// end











			message("[". $_POST['SUBJ_CODE'] ."] has been updated!", "success");
			 redirect("index.php?view=grades&id=".$_POST['IDNO']);
		}
	} 
 
 
?>