<?php
	 if (!isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     }

?>

<div class="row">
      <div class="col-lg-12">
       	 <div class="col-lg-6">
            <h1 class="page-header">List of Students </h1>
       		</div>
       		<div class="col-lg-6" >
       			<img style="float:right;" src="<?php echo web_root; ?>img/pacac100x.png" >
       		</div>
       		</div>
        	<!-- /.col-lg-12 -->
   		 </div>
	 		    <form action="controller.php?action=delete" Method="POST">  
			      <div class="table-responsive">			
				<table id="dash-table" class="table table-striped table-bordered table-hover table-responsive" style="font-size:12px" cellspacing="0">
				
				  <thead>
				  	<tr>
				  		<th>ID</th>
				  		<th>
				  		 <!-- <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');">  -->
				  		 Name</th>
				  		<th>Sex</th> 
				  		<th>Age</th>
				  		<th>Address</th>
				  		<th>Contact No.</th>
				  		<th>Course</th>
				  		<!-- <th>Status</th> -->
				  		<th width="14%" >Action</th>
				 
				  	</tr>	
				  </thead> 
				  <tbody>
				  	<?php  //`IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`, `BPLACE`,
				  	// `STATUS`, `AGE`, `NATIONALITY`, `RELIGION`, `CONTACT_NO`, `HOME_ADD`, `EMAIL`, `student_status`
				  		$mydb->setQuery("SELECT * FROM `tblstudent` s,course c WHERE s.COURSE_ID=c.COURSE_ID AND  NewEnrollees=0");

				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
							
							if($result->BDAY!='0000-00-00'){
								$age = date_diff(date_create($result->BDAY),date_create('today'))->y;
							}else{
								$age='None';
							}
				  		echo '<tr>';
				  		// echo '<td width="5%" align="center"></td>';
				  		echo '<td>' . $result->IDNO.'</a></td>';
				  		echo '<td>'. $result->LNAME.','. $result->FNAME.' '. $result->MNAME.'</td>';
				  		echo '<td>'. $result->SEX.'</td>';
				  		echo '<td>' .$age.'</td>';
				  		echo '<td>'. $result->HOME_ADD.'</td>';
				  		echo '<td>'. $result->CONTACT_NO.'</td>';
				  		echo '<td>' . $result->COURSE_NAME.'-' . $result->COURSE_LEVEL.'</a></td>';
				  		// echo '<td>'. $result->student_status.'</td>'; 
				  		 
				  		echo '<td align="center" > <a title="View Information" href="index.php?view=view&id='.$result->IDNO.'"  class="btn btn-info btn-xs  ">View <span class="fa fa-info-circle fw-fa"></span></a>
				  					 <a title="View Grades" href="index.php?view=grades&id='.$result->IDNO.'" class="btn btn-primary btn-xs" >Grades <span class="fa fa-info-circle fw-fa"></span> </a>
				  					 </td>';
				  		// echo '<td align="center" > <a title="View Grades" href="index.php?view=grades&id='.$result->IDNO.'" class="btn btn-primary btn-xs" >Grades <span class="fa fa-info-circle fw-fa"></span> </a>
				  		// 			 </td>';
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
	

</div> <!---End of container-->