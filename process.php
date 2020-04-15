<?php
require('connect.php');
session_start();

if (isset($_POST['Login'])){
	if (empty($_POST['username']) || empty($_POST['password'])){
		header('Location: login.php?Empty=Please Enter a valid Username and Password');
	}
	else{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "SELECT 1 FROM users WHERE username = '$username' AND password = '$password'";

	    $statement = $db->prepare($query);
	    $statement->execute();

	    $row = $statement->fetch();

	    if ($statement->rowCount() == 1){
	    	$_SESSION['username'] = $username;
	    		
	    	header('Location: index.php?id='. $row['id']);
	    }
	    else{
	    	header('Location: login.php?Invalid=Username or password is invalid?username=<?=$statement ?>');
	    }
	}
}
else{
	header('Location: error.php');
}


?>
