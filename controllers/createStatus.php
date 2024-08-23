<?php
declare(strict_types=1);
use App\Status;
// dd($_POST);
$status = $_POST['status'];

if (isset($_POST['status'])) {
   $status =  (new Status())-> createStatus($_POST['status']);

    if ($status) {
        header('Location: /status/create');
        exit();
    }
}
