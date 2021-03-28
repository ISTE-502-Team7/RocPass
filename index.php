<?php

     include __DIR__.'/vendor/autoload.php';
     include __DIR__.'/generated-conf/config.php';

     /*ON/OFF switch for anti-csrf
      ON = true
      OFF = false
     */
     define('ANTI-CSRF',false);
     
     use App\Lib;
     use App\Controllers;

     session_start();

     Controllers\Navi::load();

     Lib\App::run();
?>