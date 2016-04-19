<?php
session_start();
   
if (isset($_SESSION['islogged'])) {
    unset($_SESSION['islogged']);
	unset($_SESSION['username']);
	//$_SESSION['save']=false;
}
   
header("Location: http://" . $_SERVER['HTTP_HOST']
                           . dirname($_SERVER['PHP_SELF']) . '/'
                           . "index.php");
?>