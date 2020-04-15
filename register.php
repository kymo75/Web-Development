<?php

require('header.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register User Form</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#CCC;">
	<div class="container">
        <div class="col m-auto p-4" style="text-align: center;">
            <h1>Register Account</a></h1>
        </div>

        <div class="form" style="display: block; text-align: center">
		    <form action="registerProcess.php" method="POST" style="width: 600px; display: inline-block; margin-left: auto; margin-right: auto; text-align: left;">
		    	<div class="form-row" style="">
		  			<div class="form-group">
					    <label for="email">Email Address</label>
					    <input type="email" name="email" class="form-control" id="email">
			    	</div>
		    	</div>
		    	<div class="form-row">
		    		<div class="form-group">
		    			<label for="username">Username</label>
		    			<input type="text" name="username" class="form-control" id="username">
		    		</div>
		    	</div>
		  		<div class="form-row">
				    <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" name="password" class="form-control" id="password">
				    </div>
				</div>
				<div class="form-row">

					<?php
						if (isset($_GET['Incorrect']) && $_GET['Incorrect'] == true){
					?>
					<div class="alert-light text-danger text-center my-3"><?= $_GET['Incorrect'] ?></div>
					<?php
						}
					?>

				    <div class="form-group">
					    <label for="rePassword">Re-Enter Password</label>
					    <input type="password" name="rePassword" class="form-control" id="rePassword">
				    </div>
				</div>
			    <button type="submit" class="btn btn-primary" name="submitting" style="margin-left: 0;">Submit</button>
			</form>
		</div>
    </div>
</body>
<footer>
	<button type="button" class="btn btn-link btn-sm"><a href="login.php">Login</a></button>
</footer>
</html>