<?php namespace App\Controllers;

    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use Classes\VenueQuery;
    use Classes\Event;
    use Classes\EventQuery;
    use Classes\EventImage;
    use Classes\EventImageQuery;
    use App\Helpers\Token;

    class Events
    {
        public static function load()
        {
            //Begin Create
            Router::post('/addEvent', function(Request $req, Response $res){

                if(!Token::TokenMatching('add_event_token'))
                {
                    return " ";
                }

                    $event = new Event();
                    $venue = VenueQuery::create()->findOneByName($req->getBody()['vname']);
                    $event->setName($req->getBody()['name']);
                    $event->setLocation($req->getBody()['location']);
                    $event->setDescription($req->getBody()['description']);
                    $event->setStartDate($req->getBody()['start_date']);
                    $event->setEndDate($req->getBody()['end_date']);
                    $event->setVenueId($req->getBody()[$venue->getPrimaryKey()]);
                    $event->save();

                    Token::TokenExpiration('add_event_token');

            });

            Router::post('addEventImg', function(Request $req, Response $res){

                if(!Token::TokenMatching('add_eventImg_token'))
                {
                    return " ";
                }

                $eventImg = new EventImage();
                $event = EventQuery::create()->findOneByName($req->getBody()['ename']);
                $eventImg->setName($req->getBody()['name']);
                $eventImg->setPath($req->getBody()['name']);
                $eventImg->setEventId($event->getPrimaryKey());
                $eventImg->save();

                Token::TokenExpiration('add_eventImg_token');
            });
            //End Create

            //Begin Read
            Router::post('/readEvent', function(Request $req, Response $res){

                if(!Token::TokenMatching('read_event_token'))
                {
                    return " ";
                }

                $event = EventQuery::create()->findOneByName($req->getBody()['name']);

                echo $event;

                Token::TokenExpiration('read_event_token');
            });

            Router::post('/loadEvents', function(Request $req, Response $res){

                if(!Token::TokenMatching('load_events_token'))
                {
                    return " ";
                }
                $venue = VenueQuery::create()->findOneByName($req->getBody()['vname']);
                $events = EventQuery::create()->findById($venue->getPrimaryKey());

                echo $events;

                Token::TokenExpiration('load_events_token');
            });

            Router::post('/readEventImg', function(Request $req, Response $res){

                if(!Token::TokenMatching('read_eventImg_token'))
                {
                    return " ";
                }

                $eventImg = EventImageQuery::create()->findOneByName($req->getBody()['name']);
                echo $eventImg;

                Token::TokenExpiration('read_eventImg_token');
            });

            Router::post('/loadEventImgs', function(Request $req, Response $res){

                if(!Token::TokenMatching('load_eventImgs_token'))
                {
                    return " ";
                }

                $event = EventQuery::create()->findOneByName($req->getBody()['ename']);
                $eventImgs = EventImageQuery::create()->findById($event->getPrimaryKey());

                echo $eventImgs;

                Token::TokenExpiration('load_eventImgs_token');
            });
            //End Read

            //Begin Update
            Router::post('/updateEvent', function(Request $req, Response $res){

                if(!Token::TokenMatching('update_event_token'))
                {
                    return " ";
                }

                $event = EventQuery::create()->findOneByName($req->getBody()['ename']);
                $event->setName($req->getBody['newname']);
                $event->setLocation($req->getBody()['location']);
                $event->setDescription($req->getBody()['description']);
                $event->setStartDate($req->getBody()['start_date']);
                $event->setEndDate($req->getBody()['end_date']);
                $event->save();

                Token::TokenExpiration('update_event_token');
            });

            Router::post('/updateEventImg', function(Request $req, Response $res){

                if(!Token::TokenMatching('update_eventImg_token'))
                {
                    return " ";
                }

                $eventImg = EventImageQuery::create()->findOneByName($req->getBody()['vname']);
                $eventImg->setName($req->getBody()['newname']);
                $eventImg->setPath($req->getBody()['newname']);
                $eventImg->save();

                Token::TokenExpiration('update_eventImg_token');
            });
            //End Update

            //Begin Delete
            Router::post('/deleteEvent', function(Request $req, Response $res){

                if(!Token::TokenMatching('delete_event_token'))
                {
                    return " ";
                }

                $event = EventQuery::create()->findOneByName($req->getBody()['ename']);
                $event->delete();

                Token::TokenExpiration('delete_event_token');
            });

            Router::post('/deleteEventImg', function(Request $req, Response $res){

                if(!Token::TokenMatching('delete_eventImg_token'))
                {
                    return " ";
                }

                $eventImg = EventImageQuery::create()->findOneByName($req->getBody()['name']);
                $eventImg->delete();

                Token::TokenExpiration('delete_eventImg_token');
            });
            //End Delete
        }
    }
?>