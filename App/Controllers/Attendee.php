<?php namespace App\Controllers;
    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;

    class Attendee
    {
        public static function load()
        {
            Router::post('/addAttendee', function(Request $req, Response $res){
                
                echo "It Works!!"; 
        
            });
        }
    }

?>