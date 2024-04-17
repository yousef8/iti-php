 <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php
function checkUsersExists($email, $password)
{
    $users = file('users.txt');
    print_r($users);
    foreach ($users as $user) {
        print_r($user);
        $user = json_decode($user);
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
            return true;
        }
    }

    return false;
}

if (checkUsersExists($_POST['email'], $_POST['password'])) {
    header('Location: /lab-3/home.php');
    die();
}

echo "Not a user in db";

?>