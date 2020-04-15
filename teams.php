<?php

require('header.php');
require('navigation.php');
session_start();

if (!empty($_POST['search'])){
	$search = $_POST['search'];

	//	Sorting by columns
	if (isset($_POST['ASC-ID'])){
		$query = "SELECT * FROM teams WHERE name LIKE '%{$search}%' ORDER BY team_id ASC LIMIT 15";
	}
	else if (isset($_POST['DESC-ID'])){
		$query = "SELECT * FROM teams WHERE name LIKE '%{$search}%' ORDER BY team_id DESC LIMIT 15";
	}
	else if(isset($_POST['ASC-RANK'])){
		$query = "SELECT * FROM teams WHERE name LIKE '%{$search}%' ORDER BY rank ASC LIMIT 15";
	}
	else if (isset($_POST['DESC-RANK'])){
		$query = "SELECT * FROM teams WHERE name LIKE '%{$search}%' ORDER BY rank DESC LIMIT 15";
	}
	else if (isset($_POST['ASC-WINS'])){
		$query = "SELECT * FROM teams WHERE name LIKE '%{$search}%' ORDER BY win_rate ASC LIMIT 15";
	}
	else if (isset($_POST['DESC-WINS'])){
		$query = "SELECT * FROM teams WHERE name LIKE '%{$search}%' ORDER BY win_rate DESC LIMIT 15";
	}
	else{
		echo 'No team match.';
	}
}
else if (isset($_POST['ASC-ID'])){
	$query = "SELECT * FROM teams ORDER BY team_id ASC LIMIT 15";
}
else if (isset($_POST['DESC-ID'])){
	$query = "SELECT * FROM teams ORDER BY team_id DESC LIMIT 15";
}
else if(isset($_POST['ASC-RANK'])){

	$query = "SELECT * FROM teams ORDER BY rank ASC LIMIT 15";
}
else if (isset($_POST['DESC-RANKk'])){
	$query = "SELECT * FROM teams ORDER BY rank DESC LIMIT 15";
}
else if (isset($_POST['ASC-WINS'])){
	$query = "SELECT * FROM teams ORDER BY win_rate ASC LIMIT 15";
}
else if (isset($_POST['DESC-WINS'])){
	$query = "SELECT * FROM teams ORDER BY win_rate DESC LIMIT 15";
}
else{
	$query = "SELECT * FROM teams LIMIT 15";
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
	<title>Teams Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background:#CCC;">
<body>
	<div class="wrapper">
		<div class="col-m p-4" style="text-align: center;">
			<h1>Team Information</h1>
		</div>

		<form action="teams.php" method="post" />

		<div class="md-form active-cyan-2">
			<input class="form-control form-control-sm ml-3 mb-3 w-25" type="text" name="search" placeholder="Search Team" aria-label="Search">
		</div>

		<table class="table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>	
					<th scope="col">Team</th>
					<th scope="col">Rank</th>
					<th scope="col">Win Rate</th>
					<th scope="col">Status</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="submit" name="ASC-ID" value="Ascending" style="margin: 5px;" />
						<input type="submit" name="DESC-ID" value="Descending" style="margin: 5px;" />
					</td>
					<td>
						<input type="submit" name="ASC-RANK" value="Ascending" style="margin: 5px;" />
						<input type="submit" name="DESC-RANK" value="Descending" style="margin: 5px;" />
					</td>
					<td>
						<input type="submit" name="ASC-WINS" value="Ascending" style="margin: 5px;" />
						<input type="submit" name="DESC-WINS" value="Descending" style="margin: 5px;" />
					</td>
					<td></td>
				</tr>
				<?php while ($row = $statement->fetch()): ?>
					<tr>
						<td><?= $row['name'] ?></td>
						<td><?= $row['rank'] ?></td>
						<td><?= $row['win_rate'] ?>%</td>
						<td><?= $row['status'] ?></td>
						<td>
							<p><small><a href="editTeam.php?team_id=<?= $row['team_id']?>">edit</a></small></p>
						</td>
					</tr>
				<?php endwhile ?>
			</tbody>
		</table>

		<?php
			if ($user['role'] = 'admin'){
		?>
		<button type="button" class="btn btn-primary" onclick="window.location.href='createTeam.php'">Create New Team</button>
		<?php
			}
		?>

		</form>
	</div>
</body>
</html>