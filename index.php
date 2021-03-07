<?php namespace App;


     

     include __DIR__.'/vendor/autoload.php';
     include __DIR__.'/generated-conf/config.php';
     

     use App\Lib;
     use App\Controllers;

     session_start();

     Controllers\Navi::load();
     Controllers\Attendee::load();

     Lib\App::run();
?>