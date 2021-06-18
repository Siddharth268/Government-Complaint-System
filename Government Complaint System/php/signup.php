<?php
	session_start();
	if (isset($_SESSION['user'])){
		header("location: home.php");
	}

	include("connection.php");

	function createUser(){
		global $con,$db;
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passHash = password_hash($password, PASSWORD_DEFAULT);
		
		
		$sql = "SELECT pincode FROM location WHERE name = '$_POST[loc]'";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_assoc($result);
		$location = $row['pincode'];
		
		
		$query = "CREATE USER '$email'@'localhost' IDENTIFIED BY '$password';";
		$data = mysqli_query($con,$query);
		
		$onlySelect = array("complaints","electricity","ideas","location","roads","sewage","timeline","types","users","water");
		for($i=0;$i<count($onlySelect);$i++){
			mysqli_query($con,"GRANT SELECT ON cms.$onlySelect[0] TO '$email'@'localhost')");
		}
		
		$withInsert = array("complaints","ideas");
		for($i=0;$i<count($onlySelect);$i++){
			mysqli_query($con,"GRANT SELECT ON cms.$withInsert[0] TO '$email'@'localhost')");
		}
		
		/*$query = "CREATE USER '$email'@'localhost' IDENTIFIED BY '$password';";
		$data = mysqli_query($con,$query);
		mysqli_query($con,"GRANT INSERT ON cms.complaints TO '$email'@'localhost')");
		mysqli_query($con,"GRANT SELECT ON cms.complaints TO '$email'@'localhost')");
		mysqli_query($con,"GRANT INSERT ON cms.ideas TO '$email'@'localhost')");
		mysqli_query($con,"GRANT SELECT ON cms.ideas TO '$email'@'localhost')");*/
		
		
		$query = "INSERT INTO users (email,password,location) VALUES ('$email','$passHash','$location')";
		$data = mysqli_query($con,$query);
		if($data){
			//echo "Registrtion Successful";
			session_start();
			$_SESSION['user'] = $email;
			$_SESSION['pass'] = $password;
			
			header("Location: home.php");
		}
	}

	function signUp(){
		global $con,$db;
		if(!empty($_POST['email'])){
			$query = mysqli_query($con,"SELECT * FROM users WHERE email = '$_POST[email]'");
			
			if(!$row = mysqli_fetch_array($query)){
				createUser();
			}else{
				//echo "You are an existing user.. Please log in .";
				session_start();
			
				//$_SESSION['email'] = $email;
				header("Location: http://localhost/teproject/php/login.php");
			}
		}
	}

	if(isset($_POST['submit'])){
		signUp();
	}

	mysqli_close($con);
	
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/signup.css" />
		
		<link rel="shortcut icon" type="image/png" href="../favicon.png"/>
		<title>Signup</title>
		
		<script type="text/javascript">
			
			function changeLocation(){
				var id = event.target.id;
				document.getElementById("locationButton").innerHTML = id;
				document.getElementById("locationButton").name = id;
				document.getElementById("locField").value = id;
			}
						
			function validateForm(){
				var email = document.forms['signupForm']['email'].value;
				var password = document.forms['signupForm']['password'].value;
				var confPass = document.forms['signupForm']['confirmPassword'].value;
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
							
				if(reg.test(email) == false){
					document.getElementById("email").classList.add('invalid');
					document.getElementById("email").focus();
					showSnackbar("Invalid Email.");
					return false;
				}else{
					document.getElementById("email").classList.remove('invalid');
				}
				
				if(password != confPass){
					document.getElementById("confpass").classList.add('invalid');
					document.getElementById("confpass").focus();
					showSnackbar("Password do not match.");
					return false;
				}else{
					document.getElementById("confpass").classList.remove('invalid');
				}
				
				if(document.getElementById("locationButton").innerHTML == "Location"){
					showSnackbar("Please! Select location.");
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
		</script>
    </head>
    <body>
        <center>
            <div class="divParent">
                <form name="signupForm" action="" method="POST" onsubmit="return validateForm()" >
                    <h2>Signup</h2>
                    <input id="email" type="text" name="email" placeholder="Email"  required>
                    <br>
                    <input id="pass" type="password" name="password" placeholder="Password" minlength="6" required>
                    <br>
                    <input id="confpass" type="password" name="confirmPassword" placeholder="Confirm Password" minlength="6" required>
                    <br>
					<input type="hidden" id="locField" name="loc"/>
					<div class="dropdown">
						<button id="locationButton" class="dropbtn" disabled>Location</button>
						<div class="dropdown-content">
							<?php
								include("connection.php");
								$sql = "SELECT name FROM location";
								$result = mysqli_query($con, $sql);

								if (mysqli_num_rows($result) > 0) {
									while($row = mysqli_fetch_assoc($result)) {
										echo "<p id='".$row["name"]."' onclick='changeLocation()'>" . $row["name"] ."</p>";
									}
								} else {
									echo "Not Available";
								}
							?>
						</div>
					</div>
					<br>
                    <input id="signup" type="submit" name="submit" value="Signup"/>

                    <p>Already have an account?</p>
                    <input id="signin" type="button" value="Signin"  onClick="document.location.href='login.php'">
					<div id="snackbar"></div>
                </form> 
            </div>
        </center>
    </body>
</html>