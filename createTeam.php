<?php

require('header.php');
require('navigation.php');

if ($_POST && !empty($_POST['name']) && !empty($_POST['rank']) && !empty($_POST['win_rate']) && !empty($_POST['status'])){

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rank = filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_NUMBER_INT);
    $win_rate = filter_input(INPUT_POST, 'win_rate', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // Build the parameterized SQL query and bind sanitized values to the parameters
    $query = "INSERT INTO teams (name, rank, win_rate, status) values (:name, :rank, :win_rate, :status)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':rank', $rank);        
    $statement->bindValue(':win_rate', $win_rate);
    $statement->bindValue(':status', $status);
    
    // Execute the INSERT prepared statement.
    $success = $statement->execute();

    if ($success){
    	header('Location: teams.php');
    }

    // Determine the primary key of the inserted row.
    $insert_id = $db->lastInsertId();
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Team Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#CCC;">
<body>
    <div class="container">
        <div class="col m-auto p-4">
            <h1>Create A New Team Entry</a></h1>
        </div>

	    <form action="createTeam.php" method="POST" style="width: 600px; margin: auto;">
	    	<div class="form-row">
	    		<div class="form-group col-md-6">
		    		<label for="name">Name</label>
		    		<input type="text" name="name" class="form-control" id="name">
	  			</div>
	  			<div class="form-group">
				    <label for="rank">Rank</label>
				    <input type="text" name="rank" class="form-control" id="rank">
		    	</div>
	    	</div>
	  		<div class="form-row">
		  		<div class="form-group col-md-6">
				    <label for="win_rate">Win Rate</label>
				    <input type="text" name="win_rate" class="form-control" id="win_rate">
			    </div>
			    <div class="form-group">
				    <label for="status">Status</label>
				    <input type="text" name="status" class="form-control" id="status">
			    </div>
			</div>

		    <button type="submit" class="btn btn-primary" style="margin: 30px">Submit</button>
		</form>
    </div>
</body>
</html>