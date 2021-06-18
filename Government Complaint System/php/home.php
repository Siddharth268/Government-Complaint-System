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
			$cid = uniqid();
			echo $cid;
			$comments = $_POST['comment'];
			$query = "INSERT INTO complaints (email,comments,type,subtype,location,status,cid) VALUES ('$_SESSION[user]','$comments','$type','$subtype','$location',0,'$cid')";
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
		<link rel="stylesheet" href="../css/home.css" />
		
		<link rel="shortcut icon" type="image/png" href="../favicon.png"/>
		<title>Home</title>
		
		<script type="text/javascript">
			
			function changeType(){
				var id = event.target.id;
				document.getElementById("typeButton").innerHTML = id;
				document.getElementById("typeButton").style.backgroundColor = "#dddddd";
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
			    document.getElementById("logo").style.width = "60px";
			    document.getElementById("logo").style.height = "60px";
			    //document.body.style.backgroundImage = "linear-gradient(to bottom right, #ffffff, #ffffff)";
			
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
			    //document.body.style.backgroundImage = "linear-gradient(to bottom right, #ffffff, #ffffff)";
			
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
			    //document.body.style.backgroundImage = "linear-gradient(to bottom right, #ffffff, #ffffff)";
			
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
				var comment = document.getElementById("comment").value;
				if(comment == ""){
					showSnackbar("Please! Describe Your Problem");
					return false;
				}
				if(document.getElementById("typeButton").innerHTML == "Complaint Type"){
					showSnackbar("Please! Select Type.");
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
			
			function ideaCompose(){
				var modal = document.getElementById("composeIdeaModal");
				var btns = document.getElementById("composeIdeaButton");

				var span = document.getElementsByClassName("close")[1];

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
			
		</script>
		
	</head>
	<body>
		<div id="navbar">
			<center>
				<div id="navbar-logo">
					<img id="logo" src="../logo.png"/>
					<!--<p id="logoTitle">CompanyName</p>-->
				</div>
				<div id="navbar-right">
					<a id="complaint" onClick="complaints()">Complaints</a>
					<a id="ideas" onClick="ideas()">Ideas</a>
					<a id="timeline" onClick="timeline()">Timeline</a>
					<a id="profile" href="profile.php">Profile</a>
					
					<a id="logout" href="logout.php">Logout</a>
				</div>
			</center>
		</div>
		<table class="cardTable">
		<td class="cellComplaints"><div id="card">
			
			<button id="composeComplaintButton" class="composeButton">Complain</button>
			<!--<span class="divider"></span>
			<button class="composeButton">Filter</button>-->
			<div id="composeModal" class="modal">
				<center>
				<div class="modal-content">
					<div class="modal-header">
						<span class="close">&times;</span>
						<h2>Submit A Complaint</h2>
					</div>
					<div class="modal-body">
						<form name="complaintForm" action="submitAckw.php" method="POST" onsubmit="return validateForm()">
							<br>
							<textarea id="comment" name="comment" placeholder="Describe your problem"></textarea>
							<br>
							
							<input type="hidden" id="typeField" name="type"/>
							<div class="dropdown">
								<button id="typeButton" class="dropbtn" disabled>Complaint Type</button>
								<div class="dropdown-content">
									<?php
										include("connection.php");
										$sql = "SELECT name FROM types";
										$result = mysqli_query($con, $sql);

										if (mysqli_num_rows($result) > 0) {
											while($row = mysqli_fetch_assoc($result)) {
												echo "<p id='".$row["name"]."' class='parentType' onClick='changeType()'>" . $row["name"] ."</p>";
												$typeArray[] = $row['name'];
												
												$subSql = "SELECT name FROM $row[name]";
												$subResult = mysqli_query($con, $subSql);
												if (mysqli_num_rows($subResult) > 0) {
													while($subRow = mysqli_fetch_assoc($subResult)) {
														echo "<p id='".$row["name"]."  |  ".$subRow["name"]."' class='childSubType' onClick='changeType()'>" . $subRow["name"] ."</p>";
														$allTypeArray[] = $subRow['name'];
													}
												} else {
													echo "Not Available";
												}
											}
										} else {
											echo "Not Available";
										}
									?>
								</div>
							</div>
							
							<br><br>
							<input id="submitComplaint" type="submit" name="submit" value="Submit Complaint">
							<br><br>

						</form>
					</div>
				</div>
					</center>
			</div>
			<script>
				var modal = document.getElementById("composeModal");
				var btn = document.getElementById("composeComplaintButton");

				var span = document.getElementsByClassName("close")[0];

				btn.onclick = function() {
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
			</script>
			
			<table style="width:100%">
				<tr>
					<th>Type</th>
					<th>Complaints</th>
					<th>Status</th>
					<th>Date</th>
				</tr>
				
				<?php
					include('connection.php');
					$sql = "SELECT * FROM complaints WHERE email = '$_SESSION[user]' ORDER BY timedate DESC";
					$result = mysqli_query($con, $sql);
				
					while($row = mysqli_fetch_assoc($result)){
						$type = $row['type'];
						$comments = $row['comments'];
						$status = $row['status'];
						$time = $row['timedate'];
						$statusTxt = "";
						if($status == 0)
							$statusTxt = "Submitted";
						elseif($status == 1)
							$statusTxt = "Under Review";
						elseif($status == 2)
							$statusTxt = "Under Progress";
						elseif($status == 3)
							$statusTxt = "Done";
						
						$isRed = ($status != 0) ? "Border" : "";
						$isYellow = ($status != 1) ? "Border" : "";
						$isLightGreen = ($status != 2) ? "Border" : "";
						$isGreen = ($status != 3) ? "Border" : "";
						
						$date = date("d M y",strtotime($time));
						echo "<tr>
							<td id='type'>$type</td>
							<td id='words'>$comments</td>
							<td id='status'>$statusTxt
								<div class='statusDiv' style='margin:5px 0px;'>
									<span class='dot red$isRed'></span>
									<span class='dot yellow$isYellow'></span>
									<span class='dot lightGreen$isLightGreen'></span>
									<span class='dot green$isGreen'></span> 
								</div>
							</td>
							<td id='date'>$date</td>
							</tr>";
					}
				?>
			</table>
		</div>
			</td>
			<td class="cellIdeas">
		<div id="cardIdeas">
			
			<button id="composeIdeaButton" class="composeButton" onclick="ideaCompose()">Submit Idea / Suggestion</button>
			<div id="composeIdeaModal" class="modal">
				<center>
				<div class="modal-content">
					<div class="modal-header">
						<span class="close">&times;</span>
						<h2>Idea / Suggestion</h2>
					</div>
					<div class="modal-body">
						<form name="ideaForm" action="submitAckw.php" method="POST" onsubmit="return validateIdeaForm()">
							<br>
							<textarea id="ideaComment" name="ideaComment" placeholder="Describe Your Idea"></textarea>
							<br><br>
							<input id="submitIdea" type="submit" name="submit" value="Submit">
							<br><br>

						</form>
					</div>
				</div>
					</center>
			</div>
			
			<table style="width:100%">
				<tr>
					<th>Idea</th>
					<th>Date</th>
				</tr>
				
				<?php
					include('connection.php');
					$sql = "SELECT * FROM ideas WHERE email = '$_SESSION[user]' ORDER BY timedate DESC";
					$result = mysqli_query($con, $sql);
				
					while($row = mysqli_fetch_assoc($result)){
						$idea = $row['idea'];
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
			<td class="cellTimeline">
			<div id="cardTimeline">
			
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