<?php

require('header.php');
require('navigation.php');

$query = "SELECT * FROM users ORDER BY user_id";

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
	<title>Admin Information</title>
</head>
<body style="background:#CCC;">
	<div class="col m-auto p-4" style="text-align: center;">
		<h1>
			Registered Users
		</h1>
	</div>

	<div class="container">
		<table class="table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Username</th>
					<th scope="col">Password</th>
					<th scope="col">Email</th>
					<th scope="col">Role</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $statement->fetch()): ?>
					<tr>
						<td><a href="showUser.php?user_id=<?= $row['user_id']?>"><?= $row['username'] ?></a></td>
						<td><?= $row['password'] ?></td>
						<td><?= $row['email'] ?></td>
						<td><?= $row['role'] ?></td>
						<td>	
							<p><small><a href="editUser.php?user_id=<?= $row['user_id']?>">edit</a></small></p>
						</td>
					</tr>
				<?php endwhile ?>
			</tbody>
		</table>

		<?php
			if ($user['role'] = 'admin'){
		?>
		<button type="button" class="btn btn-primary" onclick="window.location.href='createUser.php'">Create New User</button>
		<?php
			}
		?>
	</div>
</body>
</html>