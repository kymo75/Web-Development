<?php

require('header.php');
require('navigation.php');

if ($_POST && !empty($_POST['name']) && !empty($_POST['team_id']) && !empty($_POST['rating']) && !empty($_POST['adr']) && !empty($_POST['trophies']) && !empty($_POST['maps'])){

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT);
    $adr = filter_input(INPUT_POST, 'adr', FILTER_SANITIZE_NUMBER_INT);
    $trophies = filter_input(INPUT_POST, 'trophies', FILTER_SANITIZE_NUMBER_INT);
    $maps = filter_input(INPUT_POST, 'maps', FILTER_SANITIZE_NUMBER_INT);

    if (isset($_POST['submit']) && isset($_FILES['image'])){
    	
    	//	Get file data
    	$file_name = $_FILES['image']['name'];
    	$file_source = $_FILES['image']['tmp_name'];
    	$file_size = $_FILES['image']['size'];
    	$file_error = $_FILES['image']['error'];
    	$file_type = $_FILES['image']['type'];

    	$file_ext = explode('.', $file_name);

    	//	Make file extension lowercase, get last peice of data from array [end] of the file extension.
    	$file_actual_ext = strtolower(end($file_ext));

    	$allowed_ext = array('jpg', 'jpeg', 'png', 'pdf');

    	//	Find if the file extension is in required types
    	if (in_array($file_actual_ext, $allowed_ext)){
    		if ($file_error === 0){
    			//	Create new file destination
    			$file_destination = 'upload/'.$file_name;
    			move_uploaded_file($file_source, $file_destination);

    			$query = "INSERT INTO players (name, team_id, rating, adr, trophies, maps, image) VALUES (:name, :team_id, :rating, :adr, :trophies, :maps, :image)";

		    	$statement = $db->prepare($query);
			    $statement->bindValue(':name', $name);
			    $statement->bindValue(':team_id', $team_id);        
			    $statement->bindValue(':rating', $rating);
			    $statement->bindValue(':adr', $adr);
			    $statement->bindValue(':trophies', $trophies);
			    $statement->bindValue(':maps', $maps);
			    $statement->bindValue(':image', $file_name);
		    
		    	$success = $statement->execute();

		    	header('Location: players.php?uploadsuccess');
    		}
    	}
    }
    else{
	    
	    $query = "INSERT INTO players (name, team_id, rating, adr, trophies, maps) VALUES (:name, :team_id, :rating, :adr, :trophies, :maps)";
	    $statement = $db->prepare($query);
	    $statement->bindValue(':name', $name);
	    $statement->bindValue(':team_id', $team_id);        
	    $statement->bindValue(':rating', $rating);
	    $statement->bindValue(':adr', $adr);
	    $statement->bindValue(':trophies', $trophies);
	    $statement->bindValue(':maps', $maps);
	    
	    $success = $statement->execute();

	    if ($success){
	    	header('Location: players.php');
	    }
	}

	if ($_POST && (empty($_POST['name']) || empty($_POST['team_id']) || empty($_POST['rating']) || empty($_POST['adr']) || empty($_POST['trophies']) || empty($_POST['maps']))){
	    echo '<script language="javascript">';
	    echo 'alert("There cannot be any empty fields")';
	    echo '</script>';
	}
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Player Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#CCC;">
    <div class="container">
		<div class="col m-auto p-4" style="text-align: center;">
            <h1>Create A New Player Entry</h1>
        </div>
	    <form action="createPlayer.php" method="POST" enctype="multipart/form-data" style="width: 600px; margin: auto;">
	    	<input type="hidden" name="size" value="1000000" />
	    	<div class="form-row">
	    		<div class="form-group col-md-6">
		    		<label for="name">Name</label>
		    		<input type="text" name="name" class="form-control" id="name">
	  			</div>
	  			<div class="form-group">
				    <label for="team_id">Team Id</label>
				    <input type="text" name="team_id" class="form-control" id="team_id">
		    	</div>
	    	</div>
	  		<div class="form-row">
		  		<div class="form-group col-md-6">
				    <label for="rating">Rating</label>
				    <input type="text" name="rating" class="form-control" id="rating">
			    </div>
			    <div class="form-group">
				    <label for="adr">Adr</label>
				    <input type="text" name="adr" class="form-control" id="adr">
			    </div>
	  		</div>
	  		<div class="form-row">
		  		<div class="form-group col-md-6">
				    <label for="trophies">Trophies</label>
				    <input type="text" name="trophies" class="form-control" id="trophies">
			    </div>
			    <div class="form-group">
				    <label for="maps">Maps</label>
				    <input type="text" name="maps" class="form-control" id="maps">
			    </div>
	  		</div>

		    <div class="form-group">
    			<label for="image">Profile</label>
    			<input type="file" name="image" class="form-control-file">
  			</div>

		    <button type="submit" name="submit" class="btn btn-primary" style="margin: 30px">Submit</button>
		</form>
	</div>
</body>
</html>