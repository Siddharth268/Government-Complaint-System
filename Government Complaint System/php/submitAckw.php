<?php
	session_start();
	if (!isset($_SESSION['user'])){
		header("location: login.php");
	}
	$typeArray = array();
	$allTypeArray = array();

	function addComplaint(){
		include("connection.php");
		
		$typeSubtype = $_POST['type'];
			
		$subStart = strrpos($typeSubtype, '|');
		$subtype = substr($typeSubtype, $subStart+3);
		$typeEnd = stripos($typeSubtype, '|');
		$type = substr($typeSubtype, 0, $typeEnd-2);
		$loc = 0;
		
		$sqlQuery = "SELECT location FROM users where email = '$_SESSION[user]'";
		$result = mysqli_query($con, $sqlQuery);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$loc = $row['location'];
			}
		}
		if (isset($_POST['comment'])) {
			$location = intval($loc);
			$cid = uniqid();
			
			$comments = $_POST['comment'];
			$query = "INSERT INTO complaints (cid,email,comments,type,subtype,location,status) VALUES ('$cid','$_SESSION[user]','$comments','$type','$subtype','$location',0)";
			$data = mysqli_query($con,$query);
			if($data){
				echo "<link rel='stylesheet' href='../css/submitAckw.css' />
					<center>
						<div class='divParent'>
							<img src='../tick.png'>
							<h2>Successful</h2>
							<p>Your complaint is successfully submited and we will try to solve it as soon as possible.</p>
							<a href='home.php' class='goback'>Go Back</a>
						</div>
					</center>";
			}
		}
	}

	function addIdea(){
		include("connection.php");

		//$loc = 0;
		
		$sqlQuery = "SELECT location FROM users where email = '$_SESSION[user]'";
		$result = mysqli_query($con, $sqlQuery);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$loc = $row['location'];
			}
		}
		if (isset($_POST['ideaComment'])) {
			$location = intval($loc);
			
			$comments = $_POST['ideaComment'];
			$query = "INSERT INTO ideas (email,idea,location) VALUES ('$_SESSION[user]','$comments','$location')";
			$data = mysqli_query($con,$query);
			
			if($data){
				echo "<link rel='stylesheet' href='../css/submitAckw.css' />
					<center>
						<div class='divParent'>
							<img src='../tick.png'>
							<h2>Successful</h2>
							<p>Your idea is successfully submited and it will be definetly cosidered in one or the other way.</p>
							<a href='home.php' class='goback'>Go Back</a>
						</div>
					</center>";
			}
		}
	}

	function addToTimeline(){
		include("connection.php");
			
			$comments = $_POST['timelineComment'];
			$query = "INSERT INTO timeline (comment) VALUES ('$comments')";
			$data = mysqli_query($con,$query);
			
			if($data){
				echo "<link rel='stylesheet' href='../css/submitAckw.css' />
				<link rel='shortcut icon' type='image/png' href='../favicon.png'/>
		<title>Status</title>
					<center>
						<div class='divParent'>
							<img src='../tick.png'>
							<h2>Successful</h2>
							<p>The comment is successfully added to the timeline.</p>
							<a href='admin.php' class='goback'>Go Back</a>
						</div>
					</center>";
			}
	}


	if(isset($_POST['submit']) && isset($_POST['ideaComment'])){
		addIdea();
	}else if(isset($_POST['submit']) && isset($_POST['type'])){
		addComplaint();
	}else if(isset($_POST['submit']) && isset($_POST['timelineComment'])){
		addToTimeline();
	}


?>
