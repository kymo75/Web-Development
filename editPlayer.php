<?php

require('header.php');
require('navigation.php');

if (isset($_POST['update']) && isset($_POST['name']) && isset($_POST['team_id']) && isset($_POST['rating']) && isset($_POST['adr']) && isset($_POST['trophies']) && isset($_POST['maps']) && $_FILES['image']['size'] > 0 && $_FILES['image']['error'] == 0){

    //  Get file data
    $file_name = $_FILES['image']['name'];
    $file_source = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_error = $_FILES['image']['error'];
    $file_type = $_FILES['image']['type'];

    $file_ext = explode('.', $file_name);

    //  Make file extension lowercase, get last peice of data from array [end] of the file extension.
    $file_actual_ext = strtolower(end($file_ext));

    $allowed_ext = array('jpg', 'jpeg', 'png', 'pdf');

    //  Find if the file extension is in required types
    if (in_array($file_actual_ext, $allowed_ext)){
        if ($file_error === 0){
            //  Create new file destination
            $file_destination = 'upload/'.$file_name;
            move_uploaded_file($file_source, $file_destination);

            $player_id = filter_input(INPUT_POST, 'player_id', FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_NUMBER_INT);
            $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT);
            $adr = filter_input(INPUT_POST, 'adr', FILTER_SANITIZE_NUMBER_INT);
            $trophies = filter_input(INPUT_POST, 'trophies', FILTER_SANITIZE_NUMBER_INT);
            $maps = filter_input(INPUT_POST, 'maps', FILTER_SANITIZE_NUMBER_INT);
            $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $query = "UPDATE players SET name = :name, team_id = :team_id, rating = :rating, adr = :adr, trophies = :trophies, maps = :maps, image = :image) WHERE player_id = :player_id";
            
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
else if (isset($_POST['update']) && isset($_POST['name']) && isset($_POST['team_id']) && isset($_POST['rating']) && isset($_POST['adr']) && isset($_POST['trophies']) && isset($_POST['maps'])){

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $player_id = filter_input(INPUT_POST, 'player_id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_NUMBER_INT);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT);
    $adr = filter_input(INPUT_POST, 'adr', FILTER_SANITIZE_NUMBER_INT);
    $trophies = filter_input(INPUT_POST, 'trophies', FILTER_SANITIZE_NUMBER_INT);
    $maps = filter_input(INPUT_POST, 'maps', FILTER_SANITIZE_NUMBER_INT);

    $updateQuery = "UPDATE players SET name = :name, team_id = :team_id, rating = :rating, adr = :adr, trophies = :trophies, maps = :maps WHERE player_id = :player_id";

    $statement = $db->prepare($updateQuery);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':team_id', $team_id);        
    $statement->bindValue(':rating', $rating);
    $statement->bindValue(':adr', $adr);
    $statement->bindValue(':trophies', $trophies);
    $statement->bindValue(':maps', $maps);
    $statement->bindValue(':player_id', $player_id, PDO::PARAM_INT);

    $success = $statement->execute();

    header('Location: players.php');
} 
else if (isset($_POST['delete'])){

    $player_id = filter_input(INPUT_POST, 'player_id', FILTER_SANITIZE_NUMBER_INT);

    $deleteQuery = "DELETE FROM players WHERE player_id = :player_id";

    $statement = $db->prepare($deleteQuery);
    $statement->bindValue(':player_id', $player_id, PDO::PARAM_INT);

    $statement->execute();

    header('Location: players.php'); 
}
elseif (filter_input(INPUT_GET, 'player_id', FILTER_SANITIZE_NUMBER_INT)){

    $selectQuery = "SELECT * FROM players WHERE player_id = {$_GET['player_id']}";

    $selectStatement = $db->prepare($selectQuery);
    $selectStatement->execute();

    $row = $selectStatement->fetch();

    echo $row['name'];
    echo $row['adr'];                                                   
}
else{
    echo 'Fill in the fields.';
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Player Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background:#CCC;">
    <div class="wrapper">
        <div class="col m-auto p-4" style="text-align: center;">
            <h1>Edit Player Information</h1>
        </div>

        <form action="editPlayer.php" method="POST" style="width: 600px; margin: auto;">
            <input type="hidden" name="size" value="1000000" />
            <input type="hidden" name="player_id" value="<?= $row['player_id']?>" />
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
                    <label for="rating">Rating</label>
                    <input type="text" name="rating" class="form-control" id="rating" value="<?= $row['rating']?>">
                </div>
                <div class="form-group">
                    <label for="adr">Adr</label>
                    <input type="text" name="adr" class="form-control" id="adr" value="<?= $row['adr']?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="trophies">Trophies</label>
                    <input type="text" name="trophies" class="form-control" id="trophies" value="<?= $row['trophies']?>">
                </div>
                <div class="form-group">
                    <label for="maps">Maps</label>
                    <input type="text" name="maps" class="form-control" id="maps" value="<?= $row['maps']?>">
                </div>

                <div class="form-group">
                    <label for="image">Profile</label>
                    <input type="file" name="image" class="form-control-file">
                </div>
            </div>

            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="submit" name="update" class="btn btn-secondary">Update</button>
                <button type="submit" name="delete" class="btn btn-secondary" onclick="return confirm('Are you sure you wish to delete this player?')">Delete</button>
            </div>
        </form>
    </div>
</body>
</html>
