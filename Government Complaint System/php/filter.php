<?php
	session_start();
	if (!isset($_SESSION['user'])){
		header("location: login.php");
	}
	$filterEmail = "";
	$filterType = "";

	/*function filterBoth(){
		include("connection.php");
	
		$filterEmail = $_POST['emailIdField'];
		$filterType = $_POST['filterTypeField'];
		//echo "<meta http-equiv='refresh' content='0'>";
		
		/*$sqlQuery = "SELECT location FROM users where email = '$_SESSION[user]'";
		$result = mysqli_query($con, $sqlQuery);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$loc = $row['location'];
			}
		}
		if (isset($_POST['comment'])) {
			$location = intval($loc);
			
			$comments = $_POST['comment'];
			$query = "INSERT INTO complaints (email,comments,type,subtype,location,status) VALUES ('$_SESSION[user]','$comments','$type','$subtype','$location',0)";
			$data = mysqli_query($con,$query);
		}*//*
	}

function filterEmail(){
		include("connection.php");
	
		$filterEmail = $_POST['emailIdField'];
		//echo "<meta http-equiv='refresh' content='0'>";
}

function filterType(){
		include("connection.php");
	
		$filterType = $_POST['filterTypeField'];
	//echo "<meta http-equiv='refresh' content='0'>";
	}

	if(isset($_POST['submit']) && isset($_POST['emailIdField']) && isset($_POST['filterTypeField'])){
		echo "Both";
		filterBoth();
	}else if(isset($_POST['submit']) && isset($_POST['emailIdField'])){
		echo "Email";
		filterUser();
	}else if(isset($_POST['submit']) && isset($_POST['filterTypeField'])){
		echo "Type";
		filterType();
	}else if(isset($_POST['submit'])){
		echo "Not working";
	}*/

?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/filter.css" />
		<link rel="shortcut icon" type="image/png" href="../favicon.png"/>
		<title>Filer</title>
		
		<script type="text/javascript">
			
			function changeUser(){
				var id = event.target.id;
				document.getElementById("filterIdButton").innerHTML = id;
				document.getElementById("filterIdButton").name = id;
				document.getElementById("filterIdField").value = id;
				
				//document.getElementById("subTypeDiv").style.display = "none";
				//document.getElementById("subTypeDiv").style.display = "block";

				//document.cookie = "typeName=" + id;
				
			}
			
			function changeType(){
				var id = event.target.id;
				document.getElementById("typeButton").innerHTML = id;
				document.getElementById("typeButton").name = id;
				document.getElementById("typeField").value = id;
				
				//document.getElementById("subTypeDiv").style.display = "none";
				//document.getElementById("subTypeDiv").style.display = "block";

				//document.cookie = "typeName=" + id;
				
			}
			
			function showSnackbar(msg) {
				var x = document.getElementById("snackbar");
				x.innerHTML = msg;
				x.className = "show";
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
			}
			
			function topFunction() {
				  document.body.scrollTop = 0; // For Safari
				  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
				}
			
			
		</script>
		
	</head>
	<body>
		<table class="cardTable" style="border-bottom: 1px solid #ddd;">
		<td class="cellComplaints"><div id="card">
			
			<form name="filterForm" action="filter.php" method="POST">
							<input type="hidden" id="filterIdField" name="emailIdField"/>
							<div class="dropdown">
								<button id="filterIdButton" class="userDropBtn" disabled>Select User</button>
								<div class="dropdown-content">
									<?php
										include("connection.php");
										$sql = "SELECT * FROM users";
										$result = mysqli_query($con, $sql);

										if (mysqli_num_rows($result) > 0) {
											while($row = mysqli_fetch_assoc($result)) {
												echo "<p id='".$row["email"]."' class='childSubType' onclick='changeUser()'>" . $row["email"] ."</p>";
												$typeArray[] = $row['email'];
												
												/*$subSql = "SELECT name FROM $row[email]";
												$subResult = mysqli_query($con, $subSql);
												if (mysqli_num_rows($subResult) > 0) {
													while($subRow = mysqli_fetch_assoc($subResult)) {
														echo "<p id='".$row["name"]."  |  ".$subRow["name"]."' class='childSubType' onClick='changeType()'>" . $subRow["name"] ."</p>";
														$allTypeArray[] = $subRow['name'];
													}
												} else {
													echo "Not Available";
												}*/
											}
										} else {
											echo "Not Available";
										}
									?>
								</div>
							</div>
				
				
				<input type="hidden" id="typeField" name="filterTypeField"/>
				<div class="dropdown">	
								<button id="typeButton" class="typeDropBtn" disabled>Select Complaint Type</button>
								<div class="dropdown-content">
									<?php
										include("connection.php");
										$sql = "SELECT name FROM types";
										$result = mysqli_query($con, $sql);

										if (mysqli_num_rows($result) > 0) {
											while($row = mysqli_fetch_assoc($result)) {
												echo "<p id='".$row["name"]."' class='childSubType' onclick='changeType()'>" . $row["name"] ."</p>";
												/*$typeArray[] = $row['name'];
												
												$subSql = "SELECT name FROM $row[name]";
												$subResult = mysqli_query($con, $subSql);
												if (mysqli_num_rows($subResult) > 0) {
													while($subRow = mysqli_fetch_assoc($subResult)) {
														echo "<p id='".$row["name"]."  |  ".$subRow["name"]."' class='childSubType' onClick='changeType()'>" . $subRow["name"] ."</p>";
														$allTypeArray[] = $subRow['name'];
													}
												} else {
													echo "Not Available";
												}*/
											}
										} else {
											echo "Not Available";
										}
									?>
								</div>
							</div>
				
				
							<input id="filterDataBtn" type="submit" name="submit" value="Filter">
							<input id="goback" onclick="location.href = 'admin.php';" value="Go Back">
							<br><br>

						</form>
			
			<table style="width:100%">
				<tr>
					<th>User</th>
					<th>Type</th>
					<th>Complaints</th>
					<th>Status</th>
					<th>Location</th>
					<th>Date</th>
				</tr>
				
				<?php
					include('connection.php');
					if(isset($_POST['submit']) && isset($_POST['emailIdField']) && isset($_POST['filterTypeField'])){
						$filterEmail = $_POST['emailIdField'];
						$filterType = $_POST['filterTypeField'];
					}else if(isset($_POST['submit']) && isset($_POST['emailIdField'])){
						$filterEmail = $_POST['emailIdField'];
					}else if(isset($_POST['submit']) && isset($_POST['filterTypeField'])){
						$filterType = $_POST['filterTypeField'];
					}
				
					$sql = "";
					if(strcmp($filterEmail,"") != 0 && strcmp($filterType,"") != 0){
						$sql = "SELECT * FROM complaints WHERE email = '$filterEmail' AND type =  '$filterType' ORDER BY timedate DESC";
					}else if(strcmp($filterEmail,"") != 0){
						$sql = "SELECT * FROM complaints WHERE email = '$filterEmail' ORDER BY timedate DESC";
					}else if(strcmp($filterType,"") != 0){
						$sql = "SELECT * FROM complaints WHERE type =  '$filterType' ORDER BY timedate DESC";
					}else{
						$sql = "SELECT * FROM complaints ORDER BY timedate DESC";
					}
					$result = mysqli_query($con, $sql);
				
					while($row = mysqli_fetch_assoc($result)){
						$type = $row['type'];
						$cid = $row['cid'];
						$comments = $row['comments'];
						$status = $row['status'];
						$time = $row['timedate'];
						$cEmail = $row['email'];
						$cLoc = $row['location'];
						
						$sqlQ = "SELECT * FROM location WHERE pincode = $cLoc";
						$resultQ = mysqli_query($con, $sqlQ);
						$rowQ = mysqli_fetch_assoc($resultQ);
						$locName = $rowQ['name'];
						
						$statusTxt = "";
						if($status == 0)
							$statusTxt = "Submitted";
						elseif($status == 1)
							$statusTxt = "Under Review";
						elseif($status == 2)
							$statusTxt = "Under Progress";
						elseif($status == 3)
							$statusTxt = "Done";
						
						$isRed = "";
						$isYellow = "";
						$isLightGreen = "";
						$isGreen = "";
						
						$redButton = "";
						$yellowButton = "";
						$lightGreenButton = "";
						$greenButton = "";
						
						if($status == 0){
							$redButton = "disabled";

							$isYellow = "Border";
							$isLightGreen = "Border";
							$isGreen = "Border";
						}else if($status == 1){
							$redButton = "disabled";
							$yellowButton = "disabled";
							
							$isRed = "NoPopUp";
							$isLightGreen = "Border";
							$isGreen = "Border";
						}else if($status == 2){
							$redButton = "disabled";
							$yellowButton = "disabled";
							$lightGreenButton = "disabled";
							
							$isRed = "NoPopUp";
							$isYellow = "NoPopUp";
							$isGreen = "Border";
						}else if($status == 3){
							$redButton = "disabled";
							$yellowButton = "disabled";
							$lightGreenButton = "disabled";
							$greenButton = "disabled";
							
							$isRed = "NoPopUp";
							$isYellow = "NoPopUp";
							$isLightGreen = "NoPopUp";
						}
						
						$date = date("d M y",strtotime($time));
						echo "<tr>
							<td id='cEmail'>$cEmail</td>
							<td id='type'>$type</td>
							<td id='adminWords'>$comments</td>
							<td id='status'>$statusTxt
								<div class='statusDiv' style='margin:5px 0px;'>
									<form name='statusForm' action='updateStatus.php' method='POST'>
										<input type='hidden' name='userEmail' value='$cEmail'>
										<button id='$time|red' class='dot red$isRed' name='status' value='$cid|red' type='submit' $redButton/>
										<button id='$time|yellow' class='dot yellow$isYellow' name='status' $yellowButton type='submit' value='$cid|yellow' />
										<button id='$time|lightGreen' class='dot lightGreen$isLightGreen' name='status' type='submit' $lightGreenButton value='$cid|lightGreen' />
										<button id='$time|green' class='dot green$isGreen' name='status' type='submit' $greenButton value='$cid|green' />
									</form>
								</div>
							</td>
							<td id='cLoc'>$locName</td>
							<td id='date'>$date</td>
							</tr>";
						
					}
				?>
			</table>
		</div>
			</td>
		</table>
		
		<div id="snackbar"></div>
		
	</body>
</html>