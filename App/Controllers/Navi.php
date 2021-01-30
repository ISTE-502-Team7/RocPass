<?php namespace App\Controllers;
    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use App\Views;

    class Navi
    {
        public static function navi($title){
            echo '
            <html>
            <head>
            <title>'.$title.'</title>
            </head>
            <navi>
            <a href="/">home</a>
            <a href="/test">test</a>
            </navi>
            <body>
            ';
        }

        public static function footer(){
            echo '
            </body>
            </html>
            ';
        }

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