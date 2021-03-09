<?php namespace App\Controllers;
    use App\Lib\Router;
    use App\Views;
  

    class Navi
    {

        public static function load()
        {
             Router::get('/', function(){
                 
                (new Views\Home())->loadBody();
                
             });

             Router::get('/test', function(){
                
                 (new Views\Test())->loadBody();
             });

        }
    }

?>