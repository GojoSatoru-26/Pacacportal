<?php
require_once ("include/initialize.php");

// addtocart($_GET['id']);


// $query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
//             $result = mysql_query($query) or die(mysql_error());
//             $row = mysql_fetch_assoc($result);

// $sql = "SELECT sum(UNIT) as 'Unit' FROM subject WHERE COURSE_ID =".$row['COURSE_ID']." AND SEMESTER='" .$_SESSION['SEMESTER']."'";
// $result = mysql_query($sql) or die(mysql_error());
// $totunits = mysql_fetch_assoc($result);


// // echo $totunits['Unit']; 
// // units to be taken

//             $query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
//             $result = mysql_query($query) or die(mysql_error());
//             $row = mysql_fetch_assoc($result);

//             $query = "SELECT * 
//                       FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID
//                       AND COURSE_NAME='".$row['COURSE_NAME']."' AND COURSE_LEVEL=".$row['YEARLEVEL']."
//                       AND  SEMESTER ='".$_SESSION['SEMESTER']."' AND
//                       NOT FIND_IN_SET(  `PRE_REQUISITE` , ( 
//                       SELECT GROUP_CONCAT(SUBJ_CODE SEPARATOR ',') FROM tblstudent s,grades g,subject sub
//                       WHERE s.IDNO=g.IDNO AND g.SUBJ_ID=sub.SUBJ_ID AND AVE <=74.5 
//                       AND  s.IDNO =" .$_SESSION['IDNO'].")
//                       )";

//                 $mydb->setQuery($query);
//                 $cur = $mydb->loadResultList(); 
//                 foreach ($cur as $result) {  
//                    $totunit +=  $result->UNIT ;
//                 }
 
//             if (isset( $_SESSION['gvCart'])){ 

//              $count_cart = count($_SESSION['gvCart']);

//                 for ($i=0; $i < $count_cart  ; $i++) {  

//                     $query = "SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND SUBJ_ID=" . $_SESSION['gvCart'][$i]['subjectid'];
//                      $mydb->setQuery($query);
//                      $cur = $mydb->loadResultList(); 
//                       foreach ($cur as $result) {   
//                            $totunit +=  $result->UNIT ;
//                       }  
//                 }
  
//               } 


// if ($totunit > $totunits['Unit']) {
// 	# code...
// message("Warning....! Your total units have exceeded!","error");
// redirect("index.php?q=cart");

// }else{

// }

































// while ($row = mysql_fetch_array($result)) {
// 	# code...

// }





if (isset($_SESSION['IDNO'])) {



 	# code...
$subject = New Subject();
$subj = $subject->single_subject($_GET['id']); 

$sql = "SELECT * FROM `grades` g, `subject` s WHERE g.`SUBJ_ID`=s.`SUBJ_ID` AND `SUBJ_CODE`='" .$subj->PRE_REQUISITE. "' AND AVE <= 74 AND IDNO=". $_SESSION['IDNO'];
@$mydb->setQuery($sql);

@$cur = $mydb->loadSingleResult();

 
	if (isset($cur->SUBJ_CODE)) {
		# code...
 	?>
 		<script type="text/javascript">
			alert('You must take the pre-requisite first before taking up this subject.')
			window.location = "index.php?q=subjectlist";
 		</script>
   	<?php
	 } else{


	$sql = "SELECT * FROM `grades`  WHERE  `SUBJ_ID`='" .$_GET['id']. "'   AND IDNO=". $_SESSION['IDNO'];
	@$mydb->setQuery($sql); 
	@$cur = $mydb->loadSingleResult();

	if (isset($cur->SUBJ_ID)) {
			# code...
		if ($cur->AVE > 0 && $cur->AVE < 75 ) {
			# code...
 			?>
  			<script type="text/javascript">
				alert('This subject is under taken.')
				window.location = "index.php?q=subjectlist";
 		</script>
  	 	<?php
		}elseif ($cur->AVE==0) {
			# code...
  			?>
 			<script type="text/javascript">
				alert('This subject is under taken.')
				window.location = "index.php?q=subjectlist";
 			</script>
  	 	<?php
		}elseif ($cur->AVE > 74) {
			# code...
		
 	?>
  			<script type="text/javascript">
				alert('You have already taken this subject.')
				window.location = "index.php?q=subjectlist";
 			</script>
 	 	<?php
	 }
	}else{
		if (!isset($cur->SUBJ_CODE) && !isset($cur->SUBJ_ID)) {
		# code...
		addtocart($_GET['id']);
	 	redirect("index.php?q=cart");
		}
	}
}
 
 }else{
 	addtocart($_GET['id']);
 	redirect("index.php?q=cart");
 }  
 ?>