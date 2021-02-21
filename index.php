<?php namespace App;

     

     include __DIR__.'/vendor/autoload.php';
     include __DIR__.'/generated-conf/config.php';
     

     echo __DIR__;
     use Lib\App;
     use App\Controllers;

     // try
     // {
          Controllers\Navi::load();

                
          
          
     // }
     // catch(Exception $e)
     // {
       //   echo $e->getMessage();
     // }
     // finally
     // {
          // App::run();
     // }
?>