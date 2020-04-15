<?php

require('header.php');
require('navigation.php');

if (isset($_POST['update']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['role'])){

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($role == 'admin' || $role == 'user'){
        $updateQuery = "UPDATE users SET username = :username, user_id = :user_id, password = :password, email = :email, role = :role WHERE user_id = :user_id";

        $statement = $db->prepare($updateQuery);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT); 
        $statement->bindValue(':username', $username);       
        $statement->bindValue(':password', $password);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':role', $role);

        $success = $statement->execute();

        header('Location: users.php');
    }
    else{
        echo 'Invalid role. Please specify either admin or user';
    }
} 
else if (isset($_POST['delete'])){

    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

    $deleteQuery = "DELETE FROM users WHERE user_id = :user_id";

    $statement = $db->prepare($deleteQuery);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    $statement->execute();

    header('Location: users.php'); 
}
elseif (filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT)){

    $selectQuery = "SELECT * FROM users WHERE user_id = {$_GET['user_id']}";

    $selectStatement = $db->prepare($selectQuery);
    $selectStatement->execute();

    $row = $selectStatement->fetch();                                               
}
else{
    echo 'Fill in the fields.';
}

?>

<!DOCTYPE html>
<html>
<body style="background:#CCC;">
    <div class="wrapper">
        <div class="col m-auto p-4" style="text-align: center;">
            <h1>Edit User Information</h1>
        </div>

        <form action="editUser.php" method="POST" style="width: 600px; margin: auto;">
            <input type="hidden" name="size" value="1000000" />
            <input type="hidden" name="user_id" value="<?= $row['user_id']?>" />
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" value="<?= $row['username']?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" class="form-control" id="password" value="<?= $row['password']?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="<?= $row['email']?>">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" name="role" class="form-control" id="role" value="<?= $row['role']?>">
                </div>
            </div>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="submit" name="update" class="btn btn-secondary">Update</button>
                <button type="submit" name="delete" class="btn btn-secondary" onclick="return confirm('Are you sure you wish to delete this user?')">Delete</button>
            </div>
        </form>
    </div>
</body>
</html>