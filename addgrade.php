<?php  
     if (!isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     }

  @$SUBJ_ID = $_GET['id'];
    if($SUBJ_ID==''){
  redirect("index.php");
}
if($_GET['IDNO']==''){
    redirect("index.php");
}

if($_GET['gid']==''){
    redirect("index.php");
}


  $subject = New Subject();
  $res = $subject->single_subject($SUBJ_ID);

?> 

 <form class="form-horizontal span6" action="controller.php?action=addgrade" method="POST">

      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">Add Grade</h1>
          </div>
          <!-- /.col-lg-12 `SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`, `COURSE_ID`, `AY`, `SEMESTER`-->
       </div> 
                   
                    <!-- <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "user_id">User Id:</label> -->

                      <!-- <div class="col-md-8"> -->
                       <input class="form-control input-sm" id="IDNO" name="IDNO" placeholder=
                            "Account Id" type="Hidden" value="<?php echo $_GET['IDNO']; ?>">
                        
                         <input class="form-control input-sm" id="SUBJ_ID" name="SUBJ_ID" placeholder=
                            "Account Id" type="Hidden" value="<?php echo $res->SUBJ_ID; ?>">

                            <input class="form-control input-sm" id="GRADEID" name="GRADEID" placeholder=
                            "Account Id" type="Hidden" value="<?php echo $_GET['gid']; ?>">
                   <!--    </div>
                    </div>
                  </div>      -->      
                   <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "SUBJ_CODE">Subject:</label>

                      <div class="col-md-8">
                        
                         <input class="form-control input-sm" id="SUBJ_CODE" name="SUBJ_CODE" readonly="true" type="text" value="<?php echo $res->SUBJ_CODE .'['. $res->SUBJ_DESCRIPTION.']';?>">
                      </div>
                    </div>
                  </div>
                  
                    
                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "FIRSTGRADING">First Grading:</label>

                      <div class="col-md-8">
                        
                         <input class="form-control input-sm" id="FIRSTGRADING" name="FIRSTGRADING" placeholder=
                            "First Grading" type="text" value="" autocomplete="off"  required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "SECONDGRADING">Second Grading:</label>

                      <div class="col-md-8">
                        
                         <input class="form-control input-sm" id="SECONDGRADING" name="SECONDGRADING" placeholder=
                            "Second Grading" type="text" value="" autocomplete="off" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "THIRDGRADING">Third Grading:</label>

                      <div class="col-md-8">
                        
                         <input class="form-control input-sm" id="THIRDGRADING" name="THIRDGRADING" placeholder=
                            "Third Grading" type="text" value="" autocomplete="off" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "FOURTHGRADING">Fourth Grading:</label>

                      <div class="col-md-8">
                        
                         <input class="form-control input-sm" id="FOURTHGRADING" name="FOURTHGRADING" placeholder=
                            "Fourth Grading" type="text" value="" autocomplete="off" required>
                      </div>
                    </div>
                  </div>
                   
       
                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "AVERAGE">Average:</label>

                      <div class="col-md-8">
                        
                         <input class="form-control input-sm" id="AVERAGE" name="AVERAGE" placeholder=
                            "0" type="text" value="" readonly="true" required>
                      </div>
                    </div>
                  </div>
                   
                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "idno"></label>

                      <div class="col-md-8">
                       <button class="btn btn-primary btn-sm" name="save" type="submit" ><span class="fa fa-save fw-fa"></span>  Save</button> 
                          <a href="index.php?view=grades&id=<?php echo $_GET['IDNO']; ?>" class="btn btn-info"><span class="fa fa-arrow-circle-left fw-fa"></span></span>&nbsp;<strong>Back</strong></a>
                       </div>
                    </div>
                  </div>

          
        </form>
      

        </div><!--End of container-->