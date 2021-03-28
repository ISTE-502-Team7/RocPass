<?php namespace App\Controllers;
    use App\Lib\Router;
    use App\Views;
  

    class Navi
    {

        public static function load()
        {
             Router::get('/test', function(){
                 
                (new Views\Home())->loadBody();
                
             });

             Router::get('/', function(){
                
                 (new Views\Test())->loadBody();
             });

        }
    }

?>