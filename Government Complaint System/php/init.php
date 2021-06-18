<?php
	session_start();
	
	$dbhost = 'localhost:3306';
   	$dbuser = 'root';
  	$dbpass = '';
	$dbname = 'cms';

	$con = mysqli_connect($dbhost,$dbuser,$dbpass);

	$sql = "CREATE DATABASE $dbname";
	$data = mysqli_query($con,$sql);
	echo "Database Created!";

	$db = mysqli_select_db($con,$dbname);

	$query = "CREATE TABLE complaints (cid varchar(25) PRIMARY KEY,email varchar(25) NOT NULL,comments varchar(1024) NOT NULL,type varchar(25) NOT NULL,subtype varchar(25) NOT NULL,location int(6) NOT NULL,status int(1) NOT NULL,timedate timestamp DEFAULT CURRENT_TIMESTAMP)";
	$data = mysqli_query($con,$query);
	echo "Complaints Table Created!";

	$query = "CREATE TABLE electricity (name varchar(25) NOT NULL)";
	$data = mysqli_query($con,$query);
	echo "Electricity Table Created!";
//Elecctricity subtypes..
	$query = "INSERT INTO electricity VALUES ('Cut off')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO electricity VALUES ('D P Blast')";
	$data = mysqli_query($con,$query);
	echo "Electricity Values Added!";

	$query = "CREATE TABLE ideas (email varchar(25) NOT NULL,idea varchar(1024) NOT NULL,location int(6) NOT NULL,timedate timestamp DEFAULT CURRENT_TIMESTAMP)";
	$data = mysqli_query($con,$query);
	echo "Ideas Table Created!";

	$query = "CREATE TABLE location (name varchar(25) NOT NULL,pincode int(6) NOT NULL)";
	$data = mysqli_query($con,$query);
	echo "Location Table Created!";
//Location
	$query = "INSERT INTO location VALUES ('Hinjewadi',411033)";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO location VALUES ('Pimpri',410506)";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO location VALUES ('Moshi',412105)";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO location VALUES ('Nigdi',411044)";
	$data = mysqli_query($con,$query);
	echo "Location Values Added!";
	

	$query = "CREATE TABLE roads (name varchar(25) NOT NULL)";
	$data = mysqli_query($con,$query);
	echo "Roads Table Created!";
//Roads subtypes..
	$query = "INSERT INTO roads VALUES ('Potholes')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO roads VALUES ('New Roads')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO roads VALUES ('Traffic')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO roads VALUES ('Delayed Work')";
	$data = mysqli_query($con,$query);
	echo "Roads Values Added!";
	
	$query = "CREATE TABLE sewage (name varchar(25) NOT NULL)";
	$data = mysqli_query($con,$query);
	echo "Sewage Table Created!";
//Sewage subtypes..
	$query = "INSERT INTO sewage VALUES ('Blocked')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO sewage VALUES ('Cleanup')";
	$data = mysqli_query($con,$query);
	echo "Sewage Values Added!";

	$query = "CREATE TABLE timeline (comment varchar(1024) NOT NULL,timedate timestamp DEFAULT CURRENT_TIMESTAMP)";
	$data = mysqli_query($con,$query);
	echo "Timeline Table Created!";

	$query = "CREATE TABLE types (name varchar(25) NOT NULL)";
	$data = mysqli_query($con,$query);
	echo "Types Table Created!";
//Types subtypes..
	$query = "INSERT INTO types VALUES ('Sewage')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO types VALUES ('Water')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO types VALUES ('Electricity')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO types VALUES ('Roads')";
	$data = mysqli_query($con,$query);
	echo "Types Values Added!";

	$query = "CREATE TABLE users (id int(10) PRIMARY KEY,email varchar(25) NOT NULL,password varchar(255) NOT NULL,location int(6) NOT NULL,timedate timestamp DEFAULT CURRENT_TIMESTAMP)";
	$data = mysqli_query($con,$query);
	echo "Users Table Created!";

	$query = "CREATE TABLE water (name varchar(25) NOT NULL)";
	$data = mysqli_query($con,$query);
	echo "Water Table Created!";
//Water subtypes..
	$query = "INSERT INTO water VALUES ('New Pipelines')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO water VALUES ('Damaged Pipelines')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO water VALUES ('Contaminated')";
	$data = mysqli_query($con,$query);
	$query = "INSERT INTO water VALUES ('No Fixed Schedule')";
	$data = mysqli_query($con,$query);
	echo "Water Values Added!";

	if($data){			
			header("Location: signup.php");
	}

	mysqli_close($con);
	
?>