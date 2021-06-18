<?php
	session_start();
	if (isset($_SESSION['user'])){
		if($_SESSION['user'] == "admin@mail.com")
			header("location: admin.php");
		else
			header("location: home.php");
	}

	include("connection.php");

	$message = "";

	if(isset($_POST['submit'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		if($email == "admin@mail.com" && $password == "admin123"){
			session_start();
			$_SESSION['user'] = $email;
		   
			header("location: admin.php");
		}else{
			$sql = "SELECT * FROM users WHERE email = '$email'";
			$result = mysqli_query($con, $sql);

			if($result == false){
				$message = "Authentication Failed! Account Not Found";
			}

			$row = mysqli_fetch_assoc($result);
			$passHash = $row['password'];

			if(password_verify($password,$passHash)){
				//session_register("myusername");
				session_start();
				$_SESSION['user'] = $email;

				header("location: home.php");
			}else{
				$message = "Authentication Failed! Invalid Details";
			}
		}
	}
?>


<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/login.css" />
		
		<link rel="shortcut icon" type="image/png" href="../favicon.png"/>
		<title>Login</title>
		
		<script type="text/javascript">
			
			function validateForm(){
				var email = document.forms['signinForm']['email'].value;
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
							
				if(reg.test(email) == false){
					document.getElementById("email").classList.add('invalid');
					document.getElementById("email").focus();
					showSnackbar("Invalid Email.");
					return false;
				}else{
					document.getElementById("email").classList.remove('invalid');
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
                <form name="signinForm" action="" method="POST" onsubmit="return validateForm()">
                    <h2>Login</h2>
                    <input id="email" type="text" name="email" placeholder="Email" required>
                    <br>
                    <input id="pass" type="password" name="password" placeholder="Password" required>
                    <br><br>
                    <input id="signin" type="submit" name="submit" value="Signin">
                    
                    <p>Don't have an account?</p>
                    <input id="signup" type="button" value="Signup" onClick="document.location.href='signup.php'">
                    
					<div id="snackbar"><?php if($message!=""){echo "<script type='text/javascript'>showSnackbar('$message')</script>"; } ?></div>
                </form>
            </div>
        </center>
    </body>
</html>
