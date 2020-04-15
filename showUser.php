<?php

require ('header.php');
require('navigation.php');
    
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);

$query = "SELECT * FROM users WHERE user_id = :user_id";

$statement = $db->prepare($query);
$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

$statement->execute(); 
$users = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Individual User</title>
</head>
<body style="background:#CCC;">
  <h1 style="text-align: center; padding: 10px;">User</h1>
  <div class="container" style="width: 100%;">
    <table style="width: 100%;">
      <thead class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col"></th>
          </tr>
        </thead>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <td><a href="showUser.php?user_id=<?= $user['user_id']?>"><?= $user['username'] ?></a></td>
          <td><?= $user['password'] ?></td>
          <td><?= $user['email'] ?></td>
          <td><?= $user['role'] ?></td>
          <td>  
            <p><small><a href="editUser.php?user_id=<?= $user['user_id']?>">edit</a></small></p>
          </td>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</body>
</html>