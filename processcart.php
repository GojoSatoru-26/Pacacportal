<?php
require_once ("include/initialize.php");
removetocart($_GET['id']);
redirect("index.php?q=cart"); 
?>