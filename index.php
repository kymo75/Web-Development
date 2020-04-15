<?php

require('header.php');
require('navigation.php');
session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
</head>
<body style="background:#CCC;">
	<?php if(isset($_SESSION['username'])): ?>
		<div class="col-m-auto" style="text-align: center; margin-top: 20px;">
			<h1>Welcome <?= $_SESSION['username'] ?></h1>
		</div>
	<?php endif ?>

	<br />
	<h5 align="center">Feel free to leave a comment about upcoming players or teams.</h2>
	<div class="container">
		<form method="POST" id="comment_form">
			<div class="form-group">
				<input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" style="margin-bottom: 20px; background-color: #F3F0F0;" />
			</div>
			<div class="form-group">
				<textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5" style="background-color: #F3F0F0;"></textarea>
			</div>
			<div class="form-group" style="margin-bottom:70px;">
				<input type="hidden" name="comment_id" id="comment_id" value="0" />
				<input type="submit" name="submit" id="submit" class="btn btn-info" value="submit" />
			</div>
		</form>
		<span id="comment_message"></span>
		<br />
		<div id="display_comment" style="background-color: #F3F0F0; border-radius: 15px;"></div>
	</div>

	<footer><p></p></footer>
</body>
</html>

<script>
	$(document).ready(function(){
		$('#comment_form').on('submit', function(event){
			//	Stop submitting data to server
			event.preventDefault();
			//	Serialize method encodes form data to string
			var form_data = $(this).serialize();

			//	Add a comment to the database
			$.ajax({
				url:"add_comment.php",
				method:"POST",
				data:form_data,
				dataType:"JSON",
				success:function(data){
					if(data.error != ''){
						//	resets the form field
						$('#comment_form')[0].reset();
						//	display the error array
						$('#comment_message').html(data.error);
						$('#comment_id').val('0');
						load_comment();
					}
				}
			})
		});

		//	Loads the comments on the webpage
		load_comment();

		function load_comment(){
			$.ajax({
				url:"fetch_comment.php",
				method:"POST",
				success:function(data){
					$('#display_comment').html(data);
				}
			})
		}

		$(document).on('click', '.reply', function(){
			var comment_id = $(this).attr("id");
			$('#comment_id').val(comment_id);
			$('#comment_name').focus();
		});
	});
</script>