<?php 
	 ini_set('session.cookie_lifetime','2592000');

    session_start();

	session_destroy();
	header('Location:index.php');
 ?>