<?php
declare(strict_types=1);
use App\User;

$username = $_POST['username'];
$position = $_POST['position'];
$gender= $_POST['gender'];
$email = $_POST['email'];
$pass=$_POST['pass'];



if (isset($_POST['username']) && isset($_POST['position']) && isset($_POST['email']) && isset($_POST['pass'])&& isset($_POST['gender'])) {
    // dd($_POST);     
    $user =  (new User())-> createUser($_POST['username'],$_POST['position'],$_POST['gender'],$_POST['email'],$_POST['pass']);

    if ($user) {
        header('Location: /');
        exit();
    }
}