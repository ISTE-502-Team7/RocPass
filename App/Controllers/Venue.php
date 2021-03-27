<?php namespace App\Controllers;

    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use Classes\User;
    use Classes\Venue;
    use Classes\VenueQuery;
    use Classes\VenueImage;
    use Classes\VenueImageQuery;
    use Classes\OrganizationQuery;
    use App\Helpers\Role;
    use Classes\UserQuery;
    use App\Helpers\Token;

    class Venues
    {
        public static function load()
        {
            //Begin Create
            Router::post('/addVenue', function(Request $req, Respponse $res){

                if(!Token::TokenMatching('add_venue_token'))
                {
                    return " ";
                }

                $org = OrganizationQuery::create()->findOneByName($req->getBody()['name']);
                $venue = new Venue();
                $venue->setName($req->getBody()['name']);
                $venue->setAddress($req->getBody()['address']);
                $venue->setParkingInfo($req->getBody()['parkingInfo']);
                $venue->setOrgId($org->getPrimaryKey());
                $venue->save();

                Token::TokenExpiration('add_venue_token');
            });

            Router::post('/addVenueImg', function(Request $req, Response $res){

                if(!Token::TokenMatching('add_image_toke'))
                {
                    return " ";
                }

                $venue = VenueQuery::create()->findOneByName($req->getBody()['name']);
                $img = new VenueImage();
                $img->setName($req->getBody()['img_name']);
                $img->setPath($req->getBody()['img_name']);
                $img->setVenueId($venue->getPrimaryKey());
                $img->save();

                Token::TokenExpiration('add_image_token');
            });
            //End Create

            //Begin Read
            Router::post('/readVenue',function(Request $req, Response $res){

                if(!Token::TokenMatching('read_venue_token'))
                {
                    return " ";
                }

                $venue = VenueQuery::create()->findOneByName($req->getBody()['name']);
                echo $venue;

                Token::TokenExpiration('read_venue_token');
            });

            Router::post('/readVenues', function(Request $req, Response $res){

                if(!Token::TokenMatching('read_venues_token'))
                {
                    return " ";
                }

                $venue = VenueQuery::create()->find();
                
                echo $venue;

                Token::TokenExpiration('read_venues_token');
            });

            Router::post('/readVenueImg', function(Request $req, Response $res){

                if(!Token::TokenMatching('read_img_token'))
                {
                    return " ";
                }

                $img = VenueImageQuery::create()->findOneByName($req->getBody()['img_name']);
                echo $img;

                Token::TokenExpiration('read_img_token');
            });

            Router::post('/loadVenueImgs', function(Request $req, Response $res){
                
                if(!Token::TokenMatching('load_imgs_token'))
                {
                    return " ";
                }

                

                Token::TokenExpiration('load_imgs_token');
            });

        }
    }
?>