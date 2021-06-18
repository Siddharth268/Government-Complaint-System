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
			
		$subStart = strrpos($typeSubtype, ' ');
		$subtype = substr($typeSubtype, $subStart+1);
		$typeEnd = stripos($typeSubtype, ' ');
		$type = substr($typeSubtype, 0, $typeEnd);
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
			
			$comments = $_POST['comment'];
			$query = "INSERT INTO complaints (email,comments,type,subtype,location,status) VALUES ('$_SESSION[user]','$comments','$type','$subtype','$location',0)";
			$data = mysqli_query($con,$query);
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
			
			if(!$data){
				echo "Error : ".mysqli_error($con);
			}
		}
	}

	if(isset($_POST['submit']) && isset($_POST['ideaComment'])){
		addIdea();
	}else if(isset($_POST['submit']) && isset($_POST['type'])){
		addComplaint();
	}

?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="../favicon.png"/>
		<title>Admin</title>
		<link rel="stylesheet" href="../css/admin.css" />
		
		<script type="text/javascript" src="http://path/to/jquery-latest.min.js"></script>
		<script type="text/javascript">
			
			function changeType(){
				var id = event.target.id;
				document.getElementById("typeButton").innerHTML = id;
				document.getElementById("typeButton").name = id;
				document.getElementById("typeField").value = id;
				
				//document.getElementById("subTypeDiv").style.display = "none";
				//document.getElementById("subTypeDiv").style.display = "block";

				document.cookie = "typeName=" + id;
				
			}
			
			function changeSubType(){
				var id = event.target.id;
				document.getElementById("subTypeButton").innerHTML = id;
				document.getElementById("subTypeButton").name = id;
				document.getElementById("subTypeField").value = id;
			}
			
			function complaints(){
				document.getElementById("navbar").style.padding = "30px 10px";
				document.getElementById("navbar").style.height = "24%";
				//document.getElementById("navbar").style.background = "#ffffff";
			    document.getElementById("logo").style.width = "60px";
			    document.getElementById("logo").style.height = "60px";
			   // document.body.style.backgroundImage = "linear-gradient(to bottom right, #ffffff, #ffffff)";
			
				document.getElementById("complaint").classList.add("active");
				document.getElementById("timeline").classList.remove("active");
				document.getElementById("ideas").classList.remove("active");
				
				/*document.getElementById("card").style.margin = "200px 5% 0px 5%";
				document.getElementById("cardIdeas").style.margin = "200px 5% 0px 5%";
				document.getElementById("cardTimeline").style.margin = "200px 5% 0px 5%";*/
				
				document.getElementById("card").style.display = "block";
				document.getElementById("cardIdeas").style.display = "none";
				document.getElementById("cardTimeline").style.display = "none";
				
				//document.body.scrollLeft = 0;
				
				topFunction();
			}
			
			function ideas(){
				document.getElementById("navbar").style.padding = "30px 10px";
				document.getElementById("navbar").style.height = "24%";
			    document.getElementById("logo").style.width = "60px";
			    document.getElementById("logo").style.height = "60px";
			   // document.body.style.backgroundImage = "linear-gradient(to bottom right, #ffffff, #ffffff)";
			
				document.getElementById("complaint").classList.remove("active");
				document.getElementById("timeline").classList.remove("active");
				document.getElementById("ideas").classList.add("active");
				
				/*document.getElementById("card").style.margin = "0px -100% 0px";
				document.getElementById("cardIdeas").style.margin = "200px -107% 0px";
				document.getElementById("cardTimeline").style.margin = "200px -107%";*/
				
				document.getElementById("card").style.display = "none";
				document.getElementById("cardIdeas").style.display = "block";
				document.getElementById("cardTimeline").style.display = "none";
				
				//document.body.scrollLeft = screen.width * 2;
				
				topFunction();
			}
			
			function timeline(){
				document.getElementById("navbar").style.padding = "30px 10px";
				document.getElementById("navbar").style.height = "24%";
			    document.getElementById("logo").style.width = "60px";
			    document.getElementById("logo").style.height = "60px";
			   // document.body.style.backgroundImage = "linear-gradient(to bottom right, #ffffff, #ffffff)";
			
				document.getElementById("complaint").classList.remove("active");
				document.getElementById("timeline").classList.add("active");
				document.getElementById("ideas").classList.remove("active");
				
				/*document.getElementById("card").style.margin = "200px -100% 0px";
				document.getElementById("cardIdeas").style.margin = "200px -100% 0px";
				document.getElementById("cardTimeline").style.margin = "200px 5% 0px";*/
				
				document.getElementById("card").style.display = "none";
				document.getElementById("cardIdeas").style.display = "none";
				document.getElementById("cardTimeline").style.display = "block";
				
				//document.body.scrollLeft = screen.width * 2;
				
				topFunction();
			}
			
			function validateForm(){
				var comment = document.getElementById("timelineComment").value;
				if(comment == ""){
					showSnackbar("Please! Describe");
					return false;
				}
				return true;
			}
			
			function showSnackbar(msg) {
				var x = document.getElementById("snackbar");
				x.innerHTML = msg;
				x.className = "show";
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
			}
			
			function timelineCompose(){
				var modal = document.getElementById("composeTimelineModal");
				var btns = document.getElementById("addTimeline");

				var span = document.getElementsByClassName("close")[0];

				btns.onclick = function() {
				  modal.style.display = "block";
				}

				span.onclick = function() {
				  modal.style.display = "none";
				}

				window.onclick = function(event) {
				  if (event.target == modal) {
					modal.style.display = "none";
				  }
				}
			}
			
			function topFunction() {
				  document.body.scrollTop = 0; // For Safari
				  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
				}
			
			function showTime(abc){
					var time = abc;
					
					var t = time.split("|");
					alert("Working" + t + "  }} " + time.split("|"));
					
					document.getElementById("timeField").value = time;
					var statusList = event.target.classList;
					if(statusList.contains("redBorder")){
						document.getElementById("statusField").value = 0;
					}else if(statusList.contains("yellowBorder")){
						document.getElementById("statusField").value = 1;
					}else if(statusList.contains("lightGreenBorder")){
						document.getElementById("statusField").value = 2;
					}else if(statusList.contains("greenBorder")){
						document.getElementById("statusField").value = 3;
					}
					//showSnackbar("Working");
					showSnackbar(time);
				}
			
		</script>
		
	</head>
	<body>
		<div id="navbar">
			
			<center>
				<div id="navbar-bg"></div>
				<div id="navbar-logo">
					<img id="logo" src="../logo.png"/>
					<!--<p id="logoTitle">CompanyName</p>-->
				</div>
				<div id="navbar-right">
					<a id="complaint" onClick="complaints()">Complaints</a>
					<a id="ideas" onClick="ideas()">Ideas</a>
					<a id="timeline" onClick="timeline()">Timeline</a>
					
					<a id="logout" href="logout.php">Logout</a>
				</div>
			</center>
		</div>
		<table class="cardTable" style="border-bottom: 1px solid #ddd;">
		<td class="cellComplaints"><div id="card">
			
			<button id="filterButton" class="composeButton" onclick="location.href = 'filter.php';">Filter</button>
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
					$sql = "SELECT * FROM complaints ORDER BY timedate DESC";
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
						
						/*
						<input type='hidden' id='timeField' name='time'/>
										<input type='hidden' id='statusField' name='status'/>
										<span id='$time|red' class='dot red$isRed' ></span>
										<span id='$time|yellow' type='submit' class='dot yellow$isYellow' ></span>
										<span id='$time|lightGreen' class='dot lightGreen$isLightGreen' ></span>
										<span id='$time|green' class='dot green$isGreen' ></span>*/
					}
				?>
			</table>
		</div>
			</td>
			<td class="cellIdeas">
		<div id="cardIdeas">
			
			<table style="width:100%">
				<tr>
					<th>User</th>
					<th>Idea</th>
					<th>Date</th>
				</tr>
				
				<?php
					include('connection.php');
					$sql = "SELECT * FROM ideas ORDER BY timedate DESC";
					$result = mysqli_query($con, $sql);
				
					while($row = mysqli_fetch_assoc($result)){
						$email = $row['email'];
						$idea = $row['idea'];
						$time = $row['timedate'];
						$date = date("d M y",strtotime($time));
						echo "<tr>
							<td id='cEmail'>$cEmail</td>
							<td id='words'>$idea</td>
							<td id='date'>$date</td>
							</tr>";
					}
				?>
			</table>
		</div>
				</td>
			<td class="cellTimeline">
				
			<div id="cardTimeline">
				<button id="addTimeline" class="composeButton" onclick="timelineCompose()">Add To Timeline</button>
				<div id="composeTimelineModal" class="modal">
				<center>
				<div class="modal-content">
					<div class="modal-header">
						<span class="close">&times;</span>
						<h2>Add to Timeline</h2>
					</div>
					<div class="modal-body">
						<form name="timelineForm" action="submitAckw.php" method="POST" onsubmit="return validateIdeaForm()">
							<br>
							<textarea id="timelineComment" name="timelineComment" placeholder="Describe"></textarea>
							<br><br>
							<input id="submitTimeline" type="submit" name="submit" value="Submit">
							<br><br>

						</form>
					</div>
				</div>
					</center>
			</div>
				
			<table style="width:100%">
				<tr>
					<th>Comment</th>
					<th>Date</th>
				</tr>
				
				<?php
					include('connection.php');
					$sql = "SELECT * FROM timeline ORDER BY timedate DESC";
					$result = mysqli_query($con, $sql);
				
					while($row = mysqli_fetch_assoc($result)){
						$idea = $row['comment'];
						$time = $row['timedate'];
						$date = date("d M y",strtotime($time));
						echo "<tr>
							<td id='words'>$idea</td>
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