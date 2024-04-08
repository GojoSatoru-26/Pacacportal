 <?php check_message(); ?>
 <form action="index.php?q=subject" method="POST">
      <table class="table table-hover"> 
            <thead>
              <tr  bgcolor="#098744" style="color:#fff">
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
              
            <?php 

             $totunits = 0;

            $query = "SELECT * FROM tblstudent s, course c WHERE s.COURSE_ID=c.COURSE_ID AND IDNO=".$_SESSION['IDNO'];
            $result = mysqli_query($mydb->conn,$query) or die(mysqli_error(mydb->conn));
            $row = mysqli_fetch_assoc($result);

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
                   echo '<td align="center" ><label>offered</label> </td>';
                  echo '</tr>';
                   $totunits +=  $result->UNIT ;
                }

 


            if (isset( $_SESSION['gvCart'])){


             $count_cart = count($_SESSION['gvCart']);

                for ($i=0; $i < $count_cart  ; $i++) {  

                    $query = "SELECT * FROM `subject` s, `course` c WHERE s.COURSE_ID=c.COURSE_ID AND SUBJ_ID=" . $_SESSION['gvCart'][$i]['subjectid'];
                     $mydb->setQuery($query);
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
                          echo '<td align="center" > <a title="Remove" href="processcart.php?id='.$result->SUBJ_ID.'"  class="btn btn-danger btn-xs  ">  Remove <span class="fa fa-trash fw-fa"></span></a>
                      </td>';
                            echo '</tr>';
                        
                           $totunits +=  $result->UNIT ;
                      } 

                 
                }

               
  
              } 
            ?>
          </tbody>
          <tfoot>
          <?php
            if ($totunits > 0) {
              # code...
              echo '<tr>
           <td colspan="3"><h4 align="right">Total Units:</h4></td>
           <td colspan="6">
             <h4><b> '. $totunits  .'</b></h4>
                         
            </td>
            </tr>
            <tr> 
            <td colspan="7">  
              <a href="index.php?q=subjectlist" class="btn btn-success btn-md" name="submit" type="submit">Add Another Subject</a>
            </td>
            <td >  
              <button class="btn btn-success btn-md" name="btnCartSubmit" type="submit">Proceed</button>
            </td>
             </tr>';
            }else{
            echo '<tr>
            <td colspan="8">No Records found.</td>

            </tr>
            <tr> 
              <td colspan="7">  
                <a href="index.php?q=subjectlist" class="btn btn-success btn-md" name="cartsubmit" type="submit">Add Another Subject</a>
              </td>
             </tr>';
            }
          ?> 
          </tfoot>  
        </table> 
</form>