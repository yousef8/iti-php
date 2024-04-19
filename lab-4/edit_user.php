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
        print_r($conn->errorInfo());
        exit('Failed retrieve user info' . PHP_EOL);
    }

    $edit_user_stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, password = :password, room = :room, image_url = :image_url");
    ?>

 <?php
    const ALLOWED_EXT = array("jpeg", "jpg", "png", "svg", "webp");
    const ROOMS = array("application1", "application2", "cloud");
    const FIELDS_TO_REGEX = array(
        "name" => "/^[a-zA-Z]+$/",
        "email" => "/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/",
        "password" => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/"
    );

    $errors = array();

    function isInvalidField($fieldName, $value, $fieldToRegex)
    {
        if ($fieldToRegex[$fieldName]) {
            return !preg_match($fieldToRegex[$fieldName], $value);
        }

        return false;
    }
    ?>

<?php

if (strlen($_POST['name']) === 0) {
    unset($_POST['name']);
}

if (strlen($_POST['email']) === 0) {
    unset($_POST['email']);
}

if (strlen($_POST['password']) === 0) {
    unset($_POST['password']);
    unset($_POST['confirmPassword']);
}

if ($_FILES['image'] && $_FILES['image']['size'] === 0) {
    unset($_FILES['image']);
}

foreach ($_POST as $fieldName => $value) {
    if (isInvalidField($fieldName, $value, FIELDS_TO_REGEX)) {
        $errors[$fieldName] = "Invalid Format";
    }
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid Format";
}

if ($_POST['password'] != $_POST['confirmPassword']) {
    $errors['confirmPassword'] = "Passwords don't match";
}

if ($_FILES['image']) {
    $ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    if (!in_array($ext, ALLOWED_EXT)) {
        $errors['image'] = "This is not an image";
    }
}

if ($errors) {
    $query_string = http_build_query(array("errors" => $errors, "old" => $_POST));
    header("Location:/lab-4/edit_user_form.php?id={$user->id}&{$query_string}");
    die();
}
$imageURL = "";

if ($_FILES['image']) {
    $imageURL = 'images/' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $imageURL);
    unlink($user->image_url);
}

$edit_user_stmt->bindValue(
    ':name',
    $_POST['name'] ? $_POST['name'] : $user->name
);

$edit_user_stmt->bindValue(
    ':email',
    $_POST['email'] ? $_POST['email'] : $user->email
);
$edit_user_stmt->bindValue(
    ':password',
    $_POST['password'] ? $_POST['password'] : $user->password
);
$edit_user_stmt->bindValue(
    ':room',
    $_POST['room'] ? $_POST['room'] : $user->room
);
$edit_user_stmt->bindValue(
    ':image_url',
    $_POST['image_url'] ? $_POST['image_url'] : $user->image_url
);

if ($edit_user_stmt->execute()) {
    header('Location: /lab-4/users.php');
    die();
}

echo $conn->errorInfo();
?>