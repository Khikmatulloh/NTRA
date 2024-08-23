<?php
declare(strict_types=1);
use App\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'] ;

    if (!empty($email) && !empty($pass)) {
        $user = (new User())->loginUser($username, $pass);

        if ($user) {
            header('Location: /');
            exit();
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        $error = "Please fill in both email and password fields.";
    }
}
?>

