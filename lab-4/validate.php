 <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

<?php
require "./db_connection.php";

$user_inst_query = "INSERT INTO users (name, email, password, room, image_url) VALUES (?, ?, ?, ?, ?)";
$user_inst_stmt = $conn->prepare($user_inst_query);
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

if (!$_FILES['image']) {
    $errors['image'] = "Must upload an image";
}

if ($_FILES['image']) {
    $ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    if (!in_array($ext, ALLOWED_EXT)) {
        $errors['image'] = "This is not an image";
    }
}

if ($errors) {
    $query_string = http_build_query(array("errors" => $errors, "old" => $_POST));
    header("Location:/lab-3/userForm.php?{$query_string}");
    die();
}

$imageURL = 'images/' . $_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'], $imageURL);

if ($user_inst_stmt->execute([$_POST['name'], $_POST['email'], $_POST['password'], $_POST['room'], $imageURL])) {
    header(
        'Location: /lab-4/users.php'
    );

    die();
}

echo $conn->errorInfo();

?>