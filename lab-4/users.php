<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "./db_connection.php";

$fetch_all_users_stmt = $conn->prepare("SElECT * FROM users");
$fetch_all_users_stmt->execute();
$users = $fetch_all_users_stmt->fetchAll();
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-lg mt-4">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Room</th>
                    <th scope="col">Image URL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['name']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['password']}</td>";
                    echo "<td>{$user['room']}</td>";
                    echo "<td>{$user['image_url']}</td>";
                    echo "<td><a href='/lab-4/edit_user_form.php?id={$user['id']}' class='btn btn-warning'>Edit</a></td>";
                    echo "<td><a href='/lab-4/del_user.php?id={$user['id']}' class='btn btn-danger'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>