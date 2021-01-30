<?php
     
     require __DIR__.'/vendor/autoload.php';

     use App\Lib\App;
     use App\Controllers;

     Controllers\Navi::load();      
     Controllers\Attendee::load();

     App::run();
?>