<?php
declare(strict_types=1);
$branch=(new \App\Branch())->getBranchs();

loadView('branch',['branch'=>$branch]);