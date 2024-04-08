 
  <div class="panel-group" id="accordion">
  <ul>
 
<?php 

$mydb->setQuery("SELECT * FROM `department`");

              $cur = $mydb->loadResultList();

            foreach ($cur as $result) {

?>
<li>
  <!-- <div class="panel panel-default"> -->
    <div class="panel-heading">
      <h4 class="panel-title">
        <a id="load"  data-toggle="collapse" data-parent="#accordion" href="#<?php echo $result->DEPT_ID; ?>" data-id="<?php echo $result->DEPT_ID; ?>">
          <?php echo $result->DEPARTMENT_DESC . ' [ ' .$result->DEPARTMENT_NAME . ' ] '; ?>
        </a>
      </h4>
    </div>

 <div id="<?php echo $result->DEPT_ID; ?>" class="panel-collapse collapse out">
      <div class="panel-body">
      <div id="loaddata<?php echo $result->DEPT_ID; ?>">
        
      </div>
      </div>
    </div>
 
 </li>
<!-- </div> -->

<?php } ?>
</ul> 

  
</div>
 
    
