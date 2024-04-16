<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <title>Registration</title>
</head>

<body>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  ?>
  <?php
  $valid = array();
  $invalid = array();

  $fieldToRegex = array(
    "username" => "/^[a-z0-9_-]{3,15}$/",
    "firstName" => "/^[a-zA-Z]{3,20}$/",
    "lastName" => "/^[a-zA-Z]{3,20}$/",
    "password" => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/"
  );

  function isInvalidField($fieldName, $fieldValue, $fieldToRegex)
  {
    if (array_key_exists($fieldName, $fieldToRegex)) {
      return !preg_match($fieldToRegex[$fieldName], $fieldValue);
    }
    return false;
  }
  ?>

  <?php
  foreach ($_POST as $key => $value) {
    if (isInvalidField($key, $value, $fieldToRegex)) {
      $invalid[$key] = $value;
    } else {
      $valid[$key] = $value;
    }
  }

  if($invalid){
    $query_string = http_build_query(array("invalid" => $invalid, "valid" => $valid));
    header("Location:/lab-2/register.php?{$query_string}");
    die();
  }
  ?>

  <h1>You Submitted your data successfully</h1>
  
  <?php
    $fileHandle = fopen('test.txt', 'a');
    fwrite($fileHandle, json_encode($_POST).PHP_EOL);
    fclose($fileHandle);
  ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">username</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Password</th>
      <th scope="col">Address</th>
      <th scope="col">Country</th>
      <th scope="col">Gender</th>
      <th scope="col">Skills</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $submissions = file('test.txt');
    foreach($submissions as $submission){
      $data = json_decode($submission);
      echo "<tr>";
      foreach($data as $field){
        if(is_array($field)){
          echo "<td>";
          print_r($field);
          echo "</td>";
        } else {
          echo "<td>{$field}</td>";
        }
      }
      echo "</tr>";
    }
    ?>
  </tbody>
</table>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>