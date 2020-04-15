<?php

require('header.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#CCC;">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 m-auto">
				<div class="card bg-dark mt-5">
					<div class="card-title bg-primary text-white mt-5">
						<h3 class="text-center py-3">Please Login</h3>
					</div>
						<?php
							if(isset($_GET['Empty']) && $_GET['Empty'] == true){
						?>
						<div class="alert-light text-danger text-center my-3"><?= $_GET['Empty'] ?></div>
						<?php
							}
						?>

						<?php
							if(isset($_GET['Invalid']) && $_GET['Invalid'] == true){
						?>
						<div class="alert-light text-danger text-center my-3"><?= $_GET['Invalid'] ?></div>
						<?php
							}
						?>
					<div class="card-body">
						<form action="process.php" method="POST">
							<input type="text" name="username" placeholder="Username" class="form-control mb-3" />
							<input type="password" name="password" placeholder="Password" class="form-control mb-3" />
							<button class="btn btn-success mt-3" type="submit" name="Login" value="Login">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<footer>
	<button type="button" class="btn btn-link btn-sm"><a href="register.php">Register</a></button>
</footer>
</html>