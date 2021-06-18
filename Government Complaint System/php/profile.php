<?php
	session_start();
	if (!isset($_SESSION['user'])){
		header("location: login.php");
	}
	$email = $_SESSION['user'];

	include("connection.php");

	if(!isset($_POST['update'])){
		global $email;

		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = mysqli_query($con, $sql);

		if($result == false){
			$message = "Authentication Failed! Account Not Found";
		}else{
			while($row = mysqli_fetch_assoc($result)){
			$locationPincode = $row['location'];

			$sqlQ = "SELECT * FROM location WHERE pincode = $locationPincode";
							$resultQ = mysqli_query($con, $sqlQ);
							$rowQ = mysqli_fetch_assoc($resultQ);
							$loc = $rowQ['name'];

			echo "<link rel='stylesheet' href='../css/profile.css' />
				<link rel='shortcut icon' type='image/png' href='../favicon.png'/>
		<title>Profile</title>
						<div class='divParent'>
							<!--<img src='../tick.png'>-->
							<h1>Profile</h1>
							<h5>Email</h5>
							<h3>$email<h3>
							<h5>Location</h5>
							<h3>$loc<h3>
							<h5>Change Password</h5>
							<form name='updatePass' action='' method='POST' >
								<input id='pass' type='password' name='password' placeholder='Password' minlength='6' required>
								<br>
								<input id='confpass' type='password' name='confirmPassword' placeholder='Confirm Password' minlength='6' required>
								<br>
								<div>
									<input id='update' type='submit' name='update' value='Update'/>
									<a class='goback' href='home.php'>Go Back</a>
								</div>
							</form>
						</div>
			";
			}
		}
	}else{
		global $email;
		
		$password = $_POST['password'];
		$confPass = $_POST['confirmPassword'];

			if(strcmp($password,$confPass) == 0){
				$passHash = password_hash($password, PASSWORD_DEFAULT);
				
				$sqlQ = "UPDATE users SET password = '$passHash' WHERE email = '$email'";
				$resultQ = mysqli_query($con, $sqlQ);

				echo "<link rel='stylesheet' href='../css/profile.css' />
					<center>
						<div class='divParent'>
							<img src='../tick.png'>
							<h2>Password Changed</h2>
							<p>You can now log into the system with new password.</p>
							<a href='profile.php' class='back'>Go Back</a>
						</div>
					</center>";
			}else{
				echo "<link rel='stylesheet' href='../css/profile.css' />
					<center>
						<div class='divParent'>
							<img src='../tick.png'>
							<h2>Error</h2>
							<p>Password do not match. Please try again.</p>
							<a href='profile.php' class='back'>Go Back</a>
						</div>
					</center>";
			}
	}
?>