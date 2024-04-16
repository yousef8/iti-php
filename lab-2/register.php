<!DOCTYPE html>
<html lang="en">

<?php

function getOldValueIfExist($fieldName){
  if(!$_GET){
    return "";
  }  
  if (array_key_exists($fieldName, $_GET['invalid'])) {
    return "value=\"{$_GET['invalid'][$fieldName]}\"";
  }

  return"value=\"{$_GET['valid'][$fieldName]}\"";
}

function showErrorMessageIfExists($fieldName){
  if ($_GET && array_key_exists($fieldName, $_GET['invalid'])) {
    return "<div class='alert alert-danger' role='alert'>
              Invalid {$fieldName}
            </div>";
  }
}
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <title>Register</title>
</head>

<body>
  <div class="container-lg p-3">
    <form method="post" action="/lab-2/validate.php">
      <div class="form-floating mb-3">
        <input type="text"
        class="form-control"
        id="username"
        name="username"
        placeholder="username"
        <?php echo getOldValueIfExist("username")?> />
        <label for="username">Username</label>
        <?php
          echo showErrorMessageIfExists('username');
        ?>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name"
         <?php echo getOldValueIfExist("firstName")?>/>
        <label for="firstName">First Name</label>
        <?php
        echo showErrorMessageIfExists("firstName");
        ?>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="First Name" 
        <?php echo getOldValueIfExist("lastName")?> />
        <label for="lastName">Last Name</label>
        <?php
          echo showErrorMessageIfExists('lastName');
        ?>

      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" 
        <?php echo getOldValueIfExist("password")?>/>
        <label for="password">Password</label>
        <?php
          echo showErrorMessageIfExists('password');
        ?>
      </div>
      <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Address" id="address" name="address" style="height: 100px"></textarea>
        <label for="address">Address</label>
      </div>
      <div class="form-floating mb-3">
        <select class="form-select" id="country" name="country" aria-label="Floating label select example">
          <option value="egypt">Egypt</option>
          <option value="morocco">Morocco</option>
          <option value="jordan">Jordan</option>
        </select>
        <label for="country">Select Country</label>
      </div>
      <fieldset class="mb-3">
        <legend>Gender</legend>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" value="male" id="flexRadioDefault1" />
          <label class="form-check-label" for="flexRadioDefault1">
            Male</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" value="female" id="flexRadioDefault2" />
          <label class="form-check-label" for="flexRadioDefault2">
            Female
          </label>
        </div>
      </fieldset>

      <fieldset class="mb-3">
        <legend>Skills</legend>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="js" name="skills[]" id="jsSkill" />
          <label class="form-check-label" for="jsSkill"> JavaScript </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="skills[]" value="python" id="pySkill" />
          <label class="form-check-label" for="pySkill"> Python </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" name="skills[]" type="checkbox" value="php" id="phpSkill" />
          <label class="form-check-label" for="phpSkill"> PHP </label>
        </div>
      </fieldset>
      <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <?php
    foreach ($_GET as $key => $value) {
      echo $key;
    }
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>