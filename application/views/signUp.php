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
                <a class="navbar-brand" href=<?php echo base_url().'home/goHome' ?> style="color: white;">Bristore</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href=<?php echo base_url().'home/goHome' ?> style="color: white;">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href= <?php echo base_url().'auth/signUp' ?> style="background-color: white;"><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>
                <li><a href= <?php echo base_url().'auth/login' ?> style="color: white;"><span class="glyphicon glyphicon-login"></span>Login</a></li>
            </ul>
        </div>
    </nav>
    <!-- End of global nav bar -->


<body>
	<div id="header" align="center">
		<h2>Create a new account</h2><br>
	</div>

	<!-- div of sign up form -->
	<div id="bigContainer" align="center" class="col-lg-5 col-lg-offset-2">



		<h3 id='instruction'>Please enter your details</h3>
        <br/>

        <?php if(isset($_SESSION['success'])) { ?>
            <div class="alert alert-success"> <?php echo $_SESSION['success']; ?> </div>

        <?php
        } ?>

        <!-- echo errors if validation is not true-->
        <?php echo validation_errors('<div class="alert alert-danger">','</div>' ); ?>

		<!-- Code for sign up form -->
		<form id="signUp" action="" method="POST" >
			<label for="email">Email Address: </label>
            <br/>
            <input type="text" name="email"/>
	        <br/>

            <label for="firstName">First Name: </label>
            <br/>
            <input type="text" name="firstName"/>
            <br/>

            <label for="lastName">Last Name: </label>
            <br/>
            <input type="text" name="lastName"/>
            <br/>

	        <label for="password">Password: </label>
            <br/>
            <input type="password" name="password"/>
            <br/>

            <label for="confirmPwd">Confirm Password: </label>
            <br/>
            <input type="password" name="confirmPwd"/>
            <br/><br/>

	        <input type="submit" class="submit_button btn-primary" value="Sign up" name="signup"/>
		</form>
	</div>
</body>
</html>