<?php use App\routes\Route;

        // include("./routes/Route.php");

        // define('BASEPATH','/');

        // function navi($title){
        //     echo '
        //     <html>
        //     <head>
        //     <title>'.$title.'</title>
        //     </head>
        //     <navi>
        //     <a href="'.BASEPATH.'">home</a>
        //     <a href="'.BASEPATH.'test">test</a>
        //     </navi>
        //     <body>
        //     ';
        // }

        // function footer(){
        //     echo '
        //     </body>
        //     </html>
        //     ';
        // }

        // Route::add('/', function(){
        //     navi('Home');
        //     include('./App/views/home.php');
        //     footer();
        // });

        // Route::add('/test', function(){
        //     navi('Test');
        //     include('./App/views/test.php');
        //     footer();
        // });
        

        // Route::pathNotFound(function($path) {
        //     // Do not forget to send a status header back to the client
        //     // The router will not send any headers by default
        //     // So you will have the full flexibility to handle this case
        //     header('HTTP/1.0 404 Not Found');
        //     navi('not found');
        //     echo 'Error 404 :-(<br>';
        //     echo 'The requested path "'.$path.'" was not found!';
        // });
        
        // // Add a 405 method not allowed route
        // Route::methodNotAllowed(function($path, $method) {
        //     // Do not forget to send a status header back to the client
        //     // The router will not send any headers by default
        //     // So you will have the full flexibility to handle this case
        //     header('HTTP/1.0 405 Method Not Allowed');
        //     navi('error');
        //     echo 'Error 405 :-(<br>';
        //     echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
        // });
        
        // // Run the Router with the given Basepath
        // Route::run(BASEPATH);
        
?>