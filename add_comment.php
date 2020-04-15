<?php

require('connect.php');
session_start();

$error = '';
$comment_name = '';
$comment_content = '';
$username = "";
// date_default_timezone_set('America/New_York');
// $date = CURDATE();

//	If comment name is not provided display error message! Else set the name.
if(empty($_POST['comment_name'])){
	$error .= '<p class="text-danger">Name is required!</p>';
}
else{
	$comment_name = $_POST["comment_name"];
}

//	If comment content is not provided display error message! Else set the comment content.
if (empty($_POST["comment_content"])){
	$error .= '<p class="text-danger">A comment is required!</p>';
}
else{
	$comment_content = $_POST["comment_content"];
}

if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}

//	If no error exists we can INSERT the comment into the database
if ($error == ''){
	$query = "INSERT INTO comments (parent_comment_id, comment, comment_sender_name, username) VALUES (:parent_comment_id, :comment, :comment_sender_name, :username)";

	$statement = $db->prepare($query);

	$statement->execute(
		array(
			':parent_comment_id' => $_POST["comment_id"],
			':comment' => $comment_content,
			':comment_sender_name' => $comment_name,
			':username' => $username
		)
	);
	$error = '<label class="text-success">Comment Added</label>';
}

$data = array(
	'error' => $error
);

//	Convert data to string and send to ajax
echo json_encode($data);

?>