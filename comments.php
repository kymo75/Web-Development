<?php
	session_start();
	print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Comment Form</title>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<br />
	<h2 align="center">Leave a comment about upcoming players & Teams!</h2>
	<div class="container">
		<form method="POST" id="comment_form">
			<div class="form-group">
				<input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
			</div>
			<div class="form-group">
				<textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
			</div>
			<div class="form-group">
				<input type="hidden" name="comment_id" id="comment_id" value="0" />
				<input type="submit" name="submit" id="submit" class="btn btn-info" value="submit" />
			</div>
		</form>
		<span id="comment_message"></span>
		<br />
		<div id="display_comment"></div>
	</div>
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
