<?php

require('header.php');
require('navigation.php');

if ($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['role'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($role == 'admin' || $role == 'user'){
	    $query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
	    $statement = $db->prepare($query);
	    $statement->bindValue(':username', $username);
	    $statement->bindValue(':password', $password);        
	    $statement->bindValue(':email', $email);
	    $statement->bindValue(':role', $role);
	    
	    $success = $statement->execute();

	    if ($success){
	    	header('Location: users.php');
	    }
    }
    else{
    	echo 'Invalid role. Please specify either admin or user';
    }


}
else if ($_POST && (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['role']))){
	echo '<script language="javascript">';
	echo 'alert("There cannot be any empty fields")';
	echo '</script>';
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create User Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#CCC;">
    <div class="container">
		<div class="col m-auto p-4" style="text-align: center;">
            <h1>Create A New User Entry</h1>
        </div>
	    <form action="createUser.php" method="POST" enctype="multipart/form-data" style="width: 600px; margin: auto;">
	    	<input type="hidden" name="size" value="1000000" />
	    	<div class="form-row">
	    		<div class="form-group col-md-6">
		    		<label for="username">Username</label>
		    		<input type="text" name="username" class="form-control" id="username">
	  			</div>
	  			<div class="form-group">
				    <label for="password">Password</label>
				    <input type="text" name="password" class="form-control" id="password">
		    	</div>
	    	</div>
	  		<div class="form-row">
		  		<div class="form-group col-md-6">
				    <label for="email">Email</label>
				    <input type="text" name="email" class="form-control" id="email">
			    </div>
			    <div class="form-group">
				    <label for="role">Role</label>
				    <input type="text" name="role" class="form-control" id="role">
			    </div>
	  		</div>

		    <button type="submit" name="submit" class="btn btn-primary" style="margin: 30px">Submit</button>
		</form>
	</div>
</body>
</html>