<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "./db_connection.php";

$get_user_stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");

$get_user_stmt->bindParam(':id', $_GET['id']);
if (!$get_user_stmt->execute()) {
    echo $conn->errorInfo() . PHP_EOL;
    exit('Failed retrieve user info' . PHP_EOL);
}

$user = $get_user_stmt->fetchObject();
if (!$user) {
    echo $conn->errorInfo() . PHP_EOL;
    exit('Failed retrieve user info' . PHP_EOL);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit User</title>
</head>

<body>
    <div class="container-lg mt-3">
        <h1>Edit User</h1>
        <form method="post" action=<?php echo "/lab-4/edit_user.php?id={$user->id}" ?> enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value=<?php echo $user->name ?>>
                <label for="name">Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value=<?php echo $user->email ?>>
                <label for="email">Email address</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
                <label for="password">Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="password">
                <label for="confirmPassword">Confirm Password</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" name="room" id="roomNo" aria-label="Floating label select example">
                    <option value='bla' selected disabled></option>
                    <option value="application1">Application 1</option>
                    <option value="application2">Application 2</option>
                    <option value="cloud">Cloud</option>
                </select>
                <label for="floatingSelect">Choose a room</label>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Profile Picture</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>

            <input class="btn btn-primary" type="submit" value="Submit">

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>