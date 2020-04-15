<?php

require('header.php');
require('navigation.php');

if (isset($_POST['update']) && isset($_POST['name']) && isset($_POST['rank']) && isset($_POST['win_rate']) && isset($_POST['status'])){


    if (!($_POST['status'] == 'active') || !($_POST['status'] == 'inactive') || !($_POST['status'] == 'banned')){
        echo "<script type='text/javascript'>alert('The status must be one of: banned, inactive, active');</script>";
    }

    // Sanitize user input to escape HTML entities and filter out dangerous characters.

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rank = filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_NUMBER_INT);
    $win_rate = filter_input(INPUT_POST, 'win_rate', FILTER_SANITIZE_NUMBER_FLOAT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_NUMBER_INT);

	$updateQuery = "UPDATE teams SET name = :name, rank = :rank, win_rate = :win_rate, status = :status WHERE team_id = :team_id";

	$statement = $db->prepare($updateQuery);
    $statement->bindValue(':name', $name);
    $statement->bindValue('rank', $rank);        
    $statement->bindValue(':win_rate', $win_rate);
    $statement->bindValue(':status', $status);
	$statement->bindValue(':team_id', $team_id, PDO::PARAM_INT);

	$success = $statement->execute();

	if ($success){
		header('Location: teams.php');
	}
}
elseif (isset($_POST['delete'])){

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rank = filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $win_rate = filter_input(INPUT_POST, 'win_rate', FILTER_SANITIZE_NUMBER_FLOAT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_NUMBER_INT);

	$deleteQuery = "DELETE FROM teams WHERE team_id = :team_id";

	$statement = $db->prepare($deleteQuery);
	$statement->bindValue(':team_id', $team_id, PDO::PARAM_INT);

	$success = $statement->execute();

	if ($success){
	  header('Location: teams.php');
	}
}
elseif ((filter_input(INPUT_GET, 'team_id', FILTER_SANITIZE_NUMBER_INT))){
	// Build a query using ":id" as a placeholder parameter.
	$selectQuery = "SELECT * FROM teams WHERE team_id = {$_GET['team_id']}";

	//the PDO::prepare function returns a PDOStatement object
	$selectStatement = $db->prepare($selectQuery);

	// Then execute the prepared statement.
	$selectStatement->execute();

	$row = $selectStatement->fetch();                                                       
}
else{
	header('Location: teams.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit team Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background:#CCC;">
    <div class="wrapper">
        <div class="col m-auto p-4" style="text-align: center;">
            <h1>Edit Player Information</h1>
        </div>

        <form action="editTeam.php" method="POST" style="width: 600px; margin: auto;">
            <input type="hidden" name="size" value="1000000" />
            <input type="hidden" name="_id" value="<?= $row['team_id']?>" />
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= $row['name']?>">
                </div>
                <div class="form-group">
                    <label for="team_id">Team Id</label>
                    <input type="text" name="team_id" class="form-control" id="team_id" value="<?= $row['team_id']?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="win_rate">Win Rate</label>
                    <input type="text" name="win_rate" class="form-control" id="win_rate" value="<?= $row['win_rate']?>">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" class="form-control" id="status" value="<?= $row['status']?>">
                </div>
            </div>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="submit" name="update" class="btn btn-secondary">Update</button>
                <button type="submit" name="delete" class="btn btn-secondary" onclick="return confirm('Are you sure you wish to delete this team?')">Delete</button>
            </div>
        </form>
    </div>
</body>
</html>