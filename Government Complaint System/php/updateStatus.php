<?php

	session_start();
	$strID = $_POST['status'];
	$email = $_SESSION['user'];

	$strIdArr =  explode("|", $strID);
	$cid = $strIdArr[0];
	$status = 0;

	if($strIdArr[1] == "red"){
		$status = 0;
	}else if($strIdArr[1] == "yellow"){
		$status = 1;
	}else if($strIdArr[1] == "lightGreen"){
		$status = 2;
	}else if($strIdArr[1] == "green"){
		$status = 3;
	}

	function update(){
		global $status,$cid;
		include("connection.php");
		$sqlQuery = "UPDATE complaints SET status = $status WHERE cid = '$cid'";
		$result = mysqli_query($con, $sqlQuery);
		
		if ($result) {
			echo "<link rel='stylesheet' href='../css/submitAckw.css' />
				<link rel='shortcut icon' type='image/png' href='../favicon.png'/>
			<title>Status</title>
				<center>
					<div class='divParent'>
						<img src='../tick.png'>
						<h2>Status Updated</h2>
						<p>Complaint Status is updated successfully.</p>
						<a href='admin.php' class='goback'>Go Back</a>
					</div>
				</center>";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		}

		mysqli_close($con);
	}

	if(isset($_POST['status'])){
		update();
	}
?>