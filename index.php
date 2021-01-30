<?php
     
     require __DIR__.'/vendor/autoload.php';

     use App\Lib\App;
     use App\Lib\Router;
     use App\Lib\Request;
     use App\Lib\Response;
     use App\Controllers;

     Router::get('/', function(){
         (new Controllers\Home())->indexAction();
     });

     Router::get('/test', function(){
         (new Controllers\Test())->indexAction();
     });

     Router::post('/addAttendee', function(Request $req, Response $res){
         

     });

     App::run();
    // include_once("./routes/Navi.route.php");
?>