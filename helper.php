<?php
use App\Ads;
function dd($args)
    {
        echo "<pre>";
        var_dump($args);
        echo "</pre>";
        die();
    }

    function getAds(){
        return (new Ads())->getAds();
    }
    function basePath(string $path):string
    {
    return __DIR__.$path;
    }

    function loadview(string $path,array|null $args=null):void
    {
        if (!file_exists(basePath($path))) {
            return;
        }
    
        if (is_array($args)) {
            extract($args);
        }
    
        require basePath('public/pages/' . $path . '.php');
    }
    