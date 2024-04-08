<?php  
     if (!isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     }

  @$IDNO = $_GET['id'];
    if($IDNO==''){
  redirect("index.php");
}
  $student = New Student();
  $res = $student->single_student($IDNO);
  
?>

<div class="row">
 <div class="col-lg-12">
 <div class="col-md-6">
 	<h2 ><?php echo   $res->LNAME.','. $res->FNAME.' '. $res->MNAME; ?></h2>
       <hr/>  
 </div>

 <?php 
$sql =" SELECT * FROM  `schoolyr` sy, `course` c,`department` d 
       WHERE  sy.`COURSE_ID`=c.`COURSE_ID` AND c.`DEPT_ID`=d.`DEPT_ID` AND sy.`IDNO`=".$IDNO;
$mydb->setQuery($sql);

$cur = $mydb->loadSingleResult(); 
 ?>
              
  </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
  	<div class="col-md-6">
  		<h4>Course/Year :<?php echo $cur->COURSE_NAME.'-'.$res->YEARLEVEL;?> </h4>
  	</div>
  	<div class="col-md-6">
  		<h4>Department :<?php echo $cur->DEPARTMENT_NAME . ' [ '. $cur->DEPARTMENT_DESC. ' ]';?> </h4>
  	</div>
  </div>
	
</div>
<div class="row">
      <div class="col-lg-3"> 
            <h3 class="page-header">Student Subjects </h3>
       	 
       		</div>
        	<!-- /.col-lg-12 -->
   		 	    <form action="controller.php?action=delete" Method="POST">  
			      <div class="table-responsive">			
				<table id="dash-table" class="table table-striped table-bordered table-hover table-responsive" style="font-size:12px" cellspacing="0">
				
				  <thead>
				  	<tr>
				  		<th>ID</th>
				  		<th>
				  		 <!-- <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');">  -->
				  		
				  		 Subject</th>
				  		<th>Description</th> 
				  		<th>Unit</th>
				  		<th>First</th>
				  		<th>Second</th>
				  		<th>Third</th> 
				  		<th>Fourth</th>
				  		<th>Average</th>
				  		<th>Remarks</th>
				  		<th>Semester</th>


				  		<th width="10%" >Action</th>
				 
				  	</tr>	
				  </thead> 
				  <tbody>
				  	<?php  
				  	// `GRADE_ID`, `IDNO`, `SUBJ_ID`, `INST_ID`, `SYID`,
				  	//  `FIRST`, `SECOND`, `THIRD`, `FOURTH`, `AVE`, `DAY`, `G_TIME`, `ROOM`, `REMARKS`, `COMMENT`

						$sql = "SELECT * FROM `tblstudent` st, `grades` g,`subject` s ,studentsubjects ss
						WHERE st.`IDNO`=g.`IDNO` and g.`SUBJ_ID`=s.`SUBJ_ID`  and s.`SUBJ_ID`=ss.`SUBJ_ID` AND g.`IDNO`=ss.`IDNO` and st.`IDNO`=".$IDNO;
				  		$mydb->setQuery($sql);

				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
				  		echo '<tr>';
				  		// echo '<td width="5%" align="center"></td>';
				  		echo '<td>' . $result->SUBJ_ID.'</a></td>';
				  		echo '<td>'. $result->SUBJ_CODE.'</td>';
				  		echo '<td>'. $result->SUBJ_DESCRIPTION.'</td>';
				  		echo '<td>' . $result->UNIT.'</a></td>';
				  		echo '<td>'. $result->FIRST.'</td>';
				  		echo '<td>'. $result->SECOND.'</td>';
				  		echo '<td>' . $result->THIRD.'</a></td>';
				  		echo '<td>'. $result->FOURTH.'</td>'; 
				  		echo '<td>'. $result->AVE.'</td>'; 
				  		echo '<td>'. $result->REMARKS.'</td>'; 
				  		echo '<td>'. $result->SEMESTER.'</td>';
				  		// echo '<td align="center" > <a title="Edit" href="index.php?view=addgrade&id='.$result->SUBJ_ID.'&IDNO='.$result->IDNO.'&gid='.$result->GRADE_ID.'"   class="btn btn-primary btn-xs  ">  <span class="fa fa-plus fw-fa"></span> Add gardes</a>
				  		// 			  </td>';

				  		echo '<td align="center" > <a  title="Edit" href="addmodalgrades.php?id='.$result->SUBJ_ID.'&IDNO='.$result->IDNO.'&gid='.$result->GRADE_ID.'" data-toggle="lightbox" >  <span class="fa fa-plus fw-fa"></span> Add gardes</a>
				  					  </td>';
				  		 
				  		// echo '<td align="center" > <a title="Edit" href="index.php?view=edit&id='.$result->SUBJ_ID.'"  class="btn btn-primary btn-xs  ">  <span class="fa fa-edit fw-fa"></span></a>
				  		// 			 <a title="Delete" href="controller.php?action=delete&id='.$result->SUBJ_ID.'" class="btn btn-danger btn-xs" ><span class="fa fa-trash-o fw-fa"></span> </a>
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