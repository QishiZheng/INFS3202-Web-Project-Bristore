<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bristore - Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

	<!-- This is the code for global nav bar -->
	<nav class="navbar navbar-light" style="background-color: #2396f3;">
        <div class="container-fluid">
            <div class="navbavr-header">
                <a class="navbar-brand" href="home.html" style="color: white;">Bristore</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="home.html" style="color: white;">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="signUp.php" style="background-color: white;"><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>
                <li><a href="login.html" style="color: white;"><span class="glyphicon glyphicon-login"></span>Login</a></li>
            </ul>
        </div>
    </nav>
<body>

	<div id="header" align="center"> 
		<h2>Create a new account</h2><br>
	</div>

	<!-- div of sign up form and PHP? (Wrap)  -->
	<div id="bigContainer" align="center">
		<!-- Block for php code later-->
		<?php
			//check if the sign up form is submitted and filled completely
			if(isset($_POST['emailAddress']) && !empty($_POST['emailAddress']) AND
			   isset($_POST['password']) && !empty($_POST['password'])) {
			   
			   //<!-- turn post date into local variables -->
			   $emailAddress = mysql_escape_string($_POST['emailAddress']);
			   $password = mysql_escape_string($_POST['password']);

			   //<!-- Check if email address is in the format: xxxxxx@xx.xxx-->
			   if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $emailAddress)){
				    $msg = "The email address you entered is invalid, please try again."; 
				}else{
				    $msg = "congratulations! Your account has been created successfully. ";
				}
			}

			if(isset($msg)) {
				echo '<h3>'.$msg.'<h3>';
			}
		?>

		<!-- End block for php code later-->

		<h3 id='instruction'>Please enter your details</h3><br>

		<!-- Code for sign up form -->
		<form id="signUp" action="" method="post">
			<label for="emailAddress">Email Address: </label>
	        <input type="text" name="emailAddress" value="" />
	        <br><br>
	        <label for="password">Password: </label>
	        <input type="text" name="password" value="" />
	        <br><br>
	         
	        <input type="submit" class="submit_button btn-primary" value="Sign up" />
		</form>
	</div>
</body>
</html>