<?php
declare(strict_types=1);
$brenches=(new \App\Branch())->getBranchs();

loadView('dashboard\create-ad',['brenches'=>$brenches]);