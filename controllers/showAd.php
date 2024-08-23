<?php

declare(strict_types=1);
/**
 * @var $id
 */
$ad        = (new \App\Ads())->getAd($id);
$ad->image = "../assets/images/ads/$ad->image";
$br        = (new \App\Branch())->getBranch($id);
loadView('single-ad', ['ad' => $ad]);