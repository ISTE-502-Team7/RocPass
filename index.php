<?php

     include __DIR__.'/vendor/autoload.php';
     include __DIR__.'/generated-conf/config.php';
     
     use App\Lib;

     session_start();

     Lib\App::run();
?>