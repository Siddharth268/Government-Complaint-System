<?php
	$dbhost = 'localhost:3306';
   	$dbuser = 'root';
  	$dbpass = '';
	$dbname = 'cms';

	$con = mysqli_connect($dbhost,$dbuser,$dbpass);
	$db = mysqli_select_db($con,$dbname);
?>