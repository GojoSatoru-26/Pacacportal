<?php
require_once ("include/initialize.php");
// if(isset($_SESSION['IDNO'])){
// 	redirect(web_root.'modstudent/index.php');

// }

$content='home.php';
$view = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';


switch ($view) {
 

	case 'department' :
        $title="Department";	
		$content='menu.php';		
		break;
 	case 'enrol' :
        $title="Enroll Now!";	
		$content='enrolment_form.php';		
		break;
	case 'register' :
        $title="Registering.........";	
		$content='register.php';		
		break;

	case 'subjectlist' :
        $title="Subject Offered";	
		$content='subjectlist.php';		
		break;
	case 'validate' :
        $title="Validating...";	 
		$subjid =  $_GET['id'];
		$content='validatingsubject.php';	
		break;

	case 'cart' :
        $title="Subjects";	  
		$content='cart.php';	
		break;

	case 'subject' :
        $title="Payments";	
		$content='coursesubject.php';		
		break;
	case 'payment' :
        $title="Processing............";	
		$content='payment.php';		
		break;
 	case 'profile' :
        $title="Profile";	
		$content='student/profile.php';		
		break;
	 
	case 'contact' :
        $title="Contact Us";	
		$content='contact.php';		
		break;

	case 'about' :
        $title="About Us";	
		$content='about.php';		
		break;
 	case 'single-item' :
        $title="Product";	
		$content='single-item.php';		
		break;
	case 'changing' :
        $title="Product";	
		$content='student/changingdropping.php';		
		break;	
	default :
	    $title="Home";	
		$content ='home.php';		
}

       
    
 
require_once("theme/templates.php");
?>

