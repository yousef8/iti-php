<?php
session_start();

unset($_SESSION['email']);

header('Location: /lab-3/login.php');
die();