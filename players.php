<?php

require('header.php');
require('navigation.php');
session_start();

if (!empty($_POST['search'])){
	$search = $_POST['search'];

	//	Sorting by columns
	if (isset($_POST['ASC-ID'])){
		$query = "SELECT * FROM players WHERE name LIKE '%{$search}%' ORDER BY player_id ASC LIMIT 15";
	}
	else if (isset($_POST['DESC-ID'])){
		$query = "SELECT * FROM players WHERE name LIKE '%{$search}%' ORDER BY player_id DESC LIMIT 15";
	}
	else if(isset($_POST['ASC-RATING'])){
		$query = "SELECT * FROM players WHERE name LIKE '%{$search}%' ORDER BY rating ASC LIMIT 15";
	}
	else if (isset($_POST['DESC-RATING'])){
		$query = "SELECT * FROM players WHERE name LIKE '%{$search}%' ORDER BY rating DESC LIMIT 15";
	}
	else if (isset($_POST['ASC-ADR'])){
		$query = "SELECT * FROM players WHERE name LIKE '%{$search}%' ORDER BY adr ASC LIMIT 15";
	}
	else if (isset($_POST['DESC-ADR'])){
		$query = "SELECT * FROM players WHERE name LIKE '%{$search}%' ORDER BY adr DESC LIMIT 15";
	}
	else{
		echo 'No player match.';
	}
}
else if (isset($_POST['ASC-ID'])){
	$query = "SELECT * FROM players ORDER BY player_id ASC LIMIT 15";
}
else if (isset($_POST['DESC-ID'])){
	$query = "SELECT * FROM players ORDER BY player_id DESC LIMIT 15";
}
else if(isset($_POST['ASC-RATING'])){

	$query = "SELECT * FROM players ORDER BY rating ASC LIMIT 15";
}
else if (isset($_POST['DESC-RATING'])){
	$query = "SELECT * FROM players ORDER BY rating DESC LIMIT 15";
}
else if (isset($_POST['ASC-ADR'])){
	$query = "SELECT * FROM players ORDER BY adr ASC LIMIT 15";
}
else if (isset($_POST['DESC-ADR'])){
	$query = "SELECT * FROM players ORDER BY adr DESC LIMIT 15";
}
else{
	$query = "SELECT * FROM players LIMIT 15";
}

$statement = $db->prepare($query);
$statement->execute();

if (isset($_SESSION['username'])){
	//	Select to find the user for the current Session
	$selectQuery = "SELECT * FROM users WHERE username = {$_SESSION['username']} LIMIT 1";

	$statementTwo = $db->prepare($selectQuery);
	$statementTwo->execute();

	$user = $statementTwo->fetch();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Players Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#CCC;">
	<div class="wrapper">
		<div class="col m-auto p-4" style="text-align: center;">
			<h1>Player Information</h1>
		</div>

		<form action="players.php" method="post">

		<div class="md-form p-0 active-cyan-2">
			<input class="form-control form-control-sm ml-3 mb-3 w-25" type="text" name="search" placeholder="Search Player" aria-label="Search">
		</div>

		<table class="table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>	
					<th scope="col">Player</th>
	      			<th scope="col">Rating</th>
	      			<th scope="col">Adr</th>
	      			<th scope="col">Team</th>
	      			<th scope="col">Trophies</th>
	      			<th scope="col">Maps</th>
	      			<th scope="col">Profile</th>
	      			<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="submit" name="ASC-ID" id="ASC-ID" value="Ascending" style="margin: 5px;" />
						<input type="submit" name="DESC-ID" id="DESC-ID" value="Descending" style="margin: 5px;" />
					</td>
					<td>
						<input type="submit" name="ASC-RATING" id="ASC-RATING" value="Ascending" style="margin: 5px;" />
						<input type="submit" name="DESC-RATING" id="DESC-RATING" value="Descending" style="margin: 5px;" />
					</td>
					<td>
						<input type="submit" name="ASC-ADR" id="ASC-ADR"  value="Ascending" style="margin: 5px;" />
						<input type="submit" name="DESC-ADR" id="DESC-ADR" value="Descending" style="margin: 5px;" />
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php while ($row = $statement->fetch()): ?>
					<tr>
						<td><?= $row['name'] ?></td>
						<td><?= $row['rating'] ?></td>
						<td><?= $row['adr'] ?></td>
						<td><?= $row['team_id'] ?></td>
						<td><?= $row['trophies'] ?></td>
						<td><?= $row['maps'] ?></td>
						<td style="padding: 0; margin: 0;">
							<?php
								if (!$row['image'] == ""){
							?>
								<img src="upload/<?=$row['image']?>" width="50" height="50" />
							<?php
								}
							?>
						</td>
						<td>	
							<p><small><a href="editPlayer.php?player_id=<?= $row['player_id']?>">edit</a></small></p>
						</td>
					</tr>
				<?php endwhile ?>
			</tbody>
		</table>

		<?php
			if ($user['role'] = 'admin'){
		?>
		<button type="button" class="btn btn-primary" onclick="window.location.href='createPlayer.php'">Create New Player</button>
		<?php
			}
		?>

		</form>
	</div>
	<script type="text/javascript" src="js/players.js"></script>
</body>
</html>
