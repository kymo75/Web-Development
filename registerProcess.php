<?php

require('connect.php');
session_start();

if (isset($_POST['submitting']) && $_POST['password'] != $_POST['rePassword']){
	header('Location: register.php?Incorrect=Please Enter a matching password this time');
} 
else if (isset($_POST['submitting'])){
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
	$statement = $db->prepare($query);

	$statement->bindValue(':username', $username);
	$statement->bindValue(':email', $email);        
	$statement->bindValue(':password', $password);

	$success = $statement->execute();

	if ($success){

		// Email a message thanking the user for their registration

		$to = $email;
		$subject = "Thank you for joining Score Esport!";
		$message = "<h1>Hi there!</h1><br></br><p>Thank you for creating a score Esport account. You will be kept up to date on all statistics regarding CSGO. Score Esport is dedicated to giving organizations and players alike on up to date information on all things CSGO. By joining us, you can make informed decisions about joining new teams.</p>";
		$headers = "From: Sender <{$email}>\r\n";
		$headers .= "Reply-To: replytoscoreesport@gmail.com\r\n";
		$headers .= "Content-type: text/html\r\n";

		//	Edit Information in xamppp to use SMTP protocol, specifying port 567 and server email- replytoscoreesport@gmail.com
		//	Send email
		mail($to, $subject, $message, $headers);

		header('Location: login.php');
	}
}

?>
