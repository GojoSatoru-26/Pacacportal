<?php 
	if (isset($_SESSION['IDNO'])) {

		# code... 

		$sql = "SELECT * FROM `tblstudent` s,`course` c WHERE s.`COURSE_ID`=c.`COURSE_ID` AND IDNO=".$_SESSION['IDNO'];
		$result = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
		$courseres = mysqli_fetch_assoc($result);
?>



<div class="row"> 
       	 <div class="col-lg-12">
            <h2 class="page-header">Curriculum offered for <?php echo $_SESSION['SEMESTER'];?> Semester</h2>
       		</div> 
   		 </div>
	 		    <form action="controller.php?action=delete" Method="POST">  
			      <div class="table-responsive">			
				<table id="home" class="table table-striped table-bordered table-hover table-responsive" style="font-size:12px" cellspacing="0">
				
				  <thead>
				  	<!-- <tr> -->
				  		<!-- <th rowspan="2">ID</th> -->
				  		<th >
				  		 <!-- <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');">  -->
				  		 Subject</th> 
				  		<th >Unit</th>
				  		<th >Pre-Requisite</th>
				  		<th >Course/Year</th>
				  		<!-- <th>Academic Year</th> -->
				  		<th >Action</th>
				 		
				  	<!-- </tr> -->	
				  	<!--  <tr> 
                          <th>Day</th> 
                          <th>Time</th>
                          <th>Room</th> 
                          <th >Section</th> 
                          <th width="10%" >Action</th>
                        </tr> -->
                       
				  </thead> 
				  <tbody>
				  	<?php 


			$sql = "SELECT * FROM course c inner join tblstudent s on c.COURSE_ID=s.COURSE_ID inner join grades g on s.IDNO=g.IDNO inner join `subject` sub on g.SUBJ_ID=sub.SUBJ_ID WHERE s.IDNO ='{$_SESSION['IDNO']}'";
			$res = @mysqli_query($mydb->conn,$sql);
           while($row = @mysqli_fetch_assoc($res)) {
             # code...
                   $query = "SELECT distinct(SUBJ_ID),`SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`,COURSE_NAME,COURSE_LEVEL, `SEMESTER` FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID 
                          AND COURSE_NAME='".$row['COURSE_NAME']."' AND SUBJ_ID !='".$row['SUBJ_ID']."' 
                          AND SEMESTER='".$_SESSION['SEMESTER']."' AND PRE_REQUISITE='NONE'";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList(); 
                foreach ($cur as $result) { 
 
							echo '<tr>';
							// echo '<td width="5%" align="center"></td>';
							// echo '<td>' . $result->SUBJ_ID.'</a></td>';
							echo '<td>'. $result->SUBJ_CODE.' ['. $result->SUBJ_DESCRIPTION.']</td>'; 
							echo '<td>' . $result->UNIT.'</a></td>';
							echo '<td>'. $result->PRE_REQUISITE.'</td>';
							echo '<td>'. $result->COURSE_NAME.'-'.$result->COURSE_LEVEL.'</td>'; 
							// echo '<td>'.$result->sched_day  .'</td>';
							// echo '<td>'.$result->sched_time  .'</td>';
							// echo '<td>'.$result->sched_room .'</td>';
							// echo '<td>'.$result->SECTION .'</td>'; 

							echo '<td align="center" > <a title="Add" href="validatingsubject.php?id='.$result->SUBJ_ID.'"  class="btn btn-primary btn-xs  ">  Add <span class="fa fa-plus fw-fa"></span></a>
							</td>';
							echo '</tr>';

                    
                }

           }

						 


				  // 	 //`SUBJ_ID`, `SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`, `COURSE_ID`, `AY`, `SEMESTER`
				  // 		// $mydb->setQuery("SELECT * 
						// 		// 			FROM  `tblusers` WHERE TYPE != 'Customer'");
				  // 		// $mydb->setQuery("SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND c.COURSE_ID=". $stud->COURSE_ID);
						// // $mydb->setQuery("SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID  
						// // 	 AND COURSE_NAME LIKE '%".$courseres['COURSE_NAME']."%' AND SEMESTER='".$_SESSION['SEMESTER']."' AND PRE_REQUISITE='NONE'");

				  // // 		$cur = $mydb->loadResultList();

						// // foreach ($cur as $result) {
				  // // 		echo '<tr>';
				  // // 		// echo '<td width="5%" align="center"></td>';
				  // // 		// echo '<td>' . $result->SUBJ_ID.'</a></td>';
				  // // 		echo '<td>'. $result->SUBJ_CODE.' ['. $result->SUBJ_DESCRIPTION.']</td>'; 
				  // // 		echo '<td>' . $result->UNIT.'</a></td>';
				  // // 		echo '<td>'. $result->PRE_REQUISITE.'</td>';
				  // // 		echo '<td>'. $result->COURSE_NAME.'-'.$result->COURSE_LEVEL.'</td>'; 
			      // //                   // echo '<td>'.$result->sched_day  .'</td>';
			      // //                   // echo '<td>'.$result->sched_time  .'</td>';
			      // //                   // echo '<td>'.$result->sched_room .'</td>';
			      // //                   // echo '<td>'.$result->SECTION .'</td>'; 
				  		 
				  // // 		echo '<td align="center" > <a title="Add" href="validatingsubject.php?id='.$result->SUBJ_ID.'"  class="btn btn-primary btn-xs  ">  Add <span class="fa fa-plus fw-fa"></span></a>
				  // // 					  </td>';
				  // // 		echo '</tr>';
				  // 	} 
				  	?>
				  </tbody>
					
				</table>
 
				<!-- <div class="btn-group">
				  <a href="index.php?view=add" class="btn btn-default">New</a>
				  <button type="submit" class="btn btn-default" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
				</div>
 -->
			</div>
	 </form>
<?php
}else{


 if (isset($_POST['transsubmit'])) {
 	
	$_SESSION['STUDID'] 	  =  $_POST['IDNO'];
	$_SESSION['FNAME'] 	      =  $_POST['FNAME'];
	$_SESSION['LNAME']  	  =  $_POST['LNAME'];
	$_SESSION['MI']           =  $_POST['MI'];
	$_SESSION['PADDRESS']     =  $_POST['PADDRESS'];
	$_SESSION['SEX']          =  $_POST['optionsRadios'];
	$_SESSION['BIRTHDATE']    = date_format(date_create($_POST['BIRTHDATE']),'Y-m-d'); 
	$_SESSION['NATIONALITY']  =  $_POST['NATIONALITY'];
	$_SESSION['BIRTHPLACE']   =  $_POST['BIRTHPLACE'];
	$_SESSION['RELIGION']     =  $_POST['RELIGION'];
	$_SESSION['CONTACT']      =  $_POST['CONTACT'];
	$_SESSION['CIVILSTATUS']  =  $_POST['CIVILSTATUS'];
	$_SESSION['GUARDIAN']     =  $_POST['GUARDIAN'];
	$_SESSION['GCONTACT']     =  $_POST['GCONTACT'];
	$_SESSION['COURSEID'] 	  =  $_POST['COURSE'];
	// $_SESSION['SEMESTER']     =  $_POST['SEMESTER'];  
	$_SESSION['USER_NAME']    =  $_POST['USER_NAME']; 
	$_SESSION['PASS']    	  =  $_POST['PASS']; 


$student = New Student();
$res = $student->find_all_student($_POST['LNAME'],$_POST['FNAME']);

if ($res) {
	# code...
	message("Student already exist.", "error");
      redirect(web_root."index.php?q=enrol");

 }else{


$sql="SELECT * FROM tblstudent WHERE ACC_USERNAME='" . $_SESSION['USER_NAME'] . "'";
$userresult = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
$userStud  = mysqli_fetch_assoc($userresult);

if($userStud){
	message("Username is already taken.", "error");
    redirect(web_root."index.php?q=enrol");
}else{


	if($_SESSION['COURSEID']=='Select' || $_SESSION['SEMESTER']=='Select' ){
		message("Select course and semester exactly", "error");
		redirect("index.php?q=enrol");

	}else{

		 $age = date_diff(date_create($_SESSION['BIRTHDATE']),date_create('today'))->y;

	    if ($age < 15){
	       message("Invalid age. 15 years old and above is allowed to enrol.", "error");
	       redirect("index.php?q=enrol");

	    }
	}

}
 
	
 }
}

?>

<div class="row"> 
       	 <div class="col-lg-12">
            <h2 class="page-header">Subjects offered </h2>
       		</div> 
   		 </div>
	 		    <form action="controller.php?action=delete" Method="POST">  
			      <div class="table-responsive">			
				<table id="home" class="table table-striped table-bordered table-hover table-responsive" style="font-size:12px" cellspacing="0">
				
				  <thead>
				  	<tr>
				  		<th>ID</th>
				  		<th>
				  		 <!-- <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');">  -->
				  		 Subject</th>
				  		<th>Description</th> 
				  		<th>Unit</th>
				  		<th>Pre-Requisite</th>
				  		<th>Course/Year</th>
				  		<!-- <th>Academic Year</th> -->
				  		<th>Semester</th>
				  		<th width="10%" >Action</th>
				 
				  	</tr>	
				  </thead> 
				  <tbody>
				  	<?php  //`SUBJ_ID`, `SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`, `COURSE_ID`, `AY`, `SEMESTER`
				  		// $mydb->setQuery("SELECT * 
								// 			FROM  `tblusers` WHERE TYPE != 'Customer'");
				  		$mydb->setQuery("SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND s.COURSE_ID=".$_SESSION['COURSEID']." AND SEMESTER='".$_SESSION['SEMESTER']."'");

				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
				  		echo '<tr>';
				  		// echo '<td width="5%" align="center"></td>';
				  		echo '<td>' . $result->SUBJ_ID.'</a></td>';
				  		echo '<td>'. $result->SUBJ_CODE.'</td>';
				  		echo '<td>'. $result->SUBJ_DESCRIPTION.'</td>';
				  		echo '<td>' . $result->UNIT.'</a></td>';
				  		echo '<td>'. $result->PRE_REQUISITE.'</td>';
				  		echo '<td>'. $result->COURSE_NAME.'-'.$result->COURSE_LEVEL.'</td>';
				  		// echo '<td>' . $result->AY.'</a></td>';
				  		echo '<td>'. $result->SEMESTER.'</td>'; 
				  		 
				  		echo '<td align="center" > <a title="Add" href="validatingsubject.php?id='.$result->SUBJ_ID.'"  class="btn btn-primary btn-xs  ">  Add <span class="fa fa-plus fw-fa"></span></a>
				  					  </td>';
				  		echo '</tr>';
				  	} 
				  	?>
				  </tbody>
					
				</table>
 
				<!-- <div class="btn-group">
				  <a href="index.php?view=add" class="btn btn-default">New</a>
				  <button type="submit" class="btn btn-default" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
				</div>
 -->
			</div>
	 </form>


<?php
}
?>