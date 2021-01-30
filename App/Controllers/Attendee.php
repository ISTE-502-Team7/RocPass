<?php namespace App\Controllers;
    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;

    class Attendee
    {
        public static function load()
        {
            Router::post('/addAttendee', function(Request $req, Response $res){
                // $post = Posts::add($req->getJSON());
                // $res->status(201)->toJSON($post);
                echo "Sweet!"; 
        
            });
        }
    }

?>