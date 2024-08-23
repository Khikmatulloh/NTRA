<?php
declare(strict_types=1);
$registar=(new \App\User())->createUser();

loadView('reagistar',['registar'=>$registar]);