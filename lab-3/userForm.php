<!DOCTYPE html>
<html lang="en">

<?php
 ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
?>
<?php
function getOldValueIfExist($fieldName){
  if(!$_GET){
    return "";
  }  
  return"value=\"{$_GET['old'][$fieldName]}\"";
}

function getErrorMessageIfExists($fieldName){
  if ($_GET && array_key_exists($fieldName, $_GET['errors'])) {
    return "<div class='alert alert-danger' role='alert'>
              {$_GET['errors'][$fieldName]}
            </div>";
  }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-lg m-3">

        <h1>Add User</h1>
        <form method="post" action="/lab-3/validate.php" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" <?php echo getOldValueIfExist("name") ?> >
                <label for="name">Name</label>
                <?php echo getErrorMessageIfExists('name') ?>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"<?php echo getOldValueIfExist("email") ?>>
                <label for="email">Email address</label>
                <?php echo getErrorMessageIfExists('email') ?>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="password"<?php echo getOldValueIfExist("password") ?>>
                <label for="password">Password</label>
                <?php echo getErrorMessageIfExists('password') ?>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="password"<?php echo getOldValueIfExist("confirmPassword") ?>>
                <label for="confirmPassword">Confirm Password</label>
                <?php echo getErrorMessageIfExists('confirmPassword') ?>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" name="room" id="roomNo" aria-label="Floating label select example">
                    <option value="application1">Application 1</option>
                    <option value="application2">Application 2</option>
                    <option value="cloud">Cloud</option>
                </select>
                <label for="floatingSelect">Choose a room</label>
            </div>
                <?php echo getErrorMessageIfExists('room') ?>

            <div class="mb-3">
                <label for="formFile" class="form-label">Profile Picture</label>
                <input class="form-control" name="image" type="file" id="formFile">
                <?php echo getErrorMessageIfExists('image') ?>
            </div>

            <input class="btn btn-primary" type="submit" value="Submit">

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>