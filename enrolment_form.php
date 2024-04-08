<?php
$q = $_GET['q'];
if($q=='enrol'){   
  if(isset($_SESSION['IDNO'])){ 
  
    $student = New Student();
    $stud  = $student->single_student($_SESSION['IDNO']);
 
 
    if ($stud->NewEnrollees == 1) {
      # code...
      // message("You cannot enrol now. For more information, please contact administrator.","error");
      redirect('index.php?q=profile');
     }else{ 

      if ($stud->student_status=='Regular') {
        # code...
        redirect('index.php?q=subject');

      }elseif($stud->student_status=='Irregular'){

        // redirect("index.php?q=subjectlist");
         redirect("index.php?q=cart");
 
     }else{
         redirect('index.php?q=profile');
     }
 
    }

  
  }else{
  ?>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#New" data-toggle="tab">New</a></li> 
    <li><a href="#Old" data-toggle="tab">Old</a></li>
    <li><a href="#Transferees" data-toggle="tab">Transferees</a></li>
  </ul>
  <div class="tab-content"><br/>
    <div class="tab-pane active" id="New">

     <?php include  "regform.php"; ?> 
               
    </div><!--/tab-pane-->
       
     <div class="tab-pane" id="Old">
      

        <div class="panel panel-default">
          <div class="panel-body">
              <div class="well well-sm"  style="background-color:#098744;color:#fff;"><b >  Login </b> </div>

                  <form class="form-horizontal span6" action="login.php" method="POST">
                      <div class="form-group">
                        <div class="col-md-12">
                          <label class="control-label" for=
                          "U_USERNAME">Username:</label> 
                                <input required="true"   id="U_USERNAME" name="U_USERNAME" placeholder="Username" type="text" class="form-control input" >  
                        </div> 
       
                        <div class="col-md-12">
                          <label class="control-label" for=
                          "U_PASS">Password:</label> 
                           <input required="true" name="U_PASS" id="U_PASS" placeholder="Password" type="password" class="form-control input ">
                   
                        </div> 
                        </div>
                        <div class="form-group">
                        <div class="col-md-12"> 
                          <button type="submit" id="oldLogin" name="oldLogin"  style="background-color:#098744;color:#fff;" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-logged-in "></span>   Login</button> 
                           
                        </div>
                      </div>


                  </form>

              </div> 
        </div>
    </div><!--/tab-pane-->
     <div class="tab-pane" id="Transferees"><br/> 
      <?php include  "registrationform.php"; ?> 
    </div><!--/tab-pane-->

  </div><!--/tab-content-->
<?php
}
 }else{
  include 'coursesubject.php';
 } 
?>


 