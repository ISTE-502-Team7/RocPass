<?php namespace App\Controllers;
    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use App\Views;
    use Classes\User;

    class Navi
    {

        public static function load()
        {
             Router::get('/', function(){
                 
                (new Views\Home());
                
             });

             Router::get('/test', function(){
                
                 (new Views\Test());
             });

        }
    }

?>