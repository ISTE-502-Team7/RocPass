<?php namespace App\Controllers;

/* 
    Author: Aaron Parker
    Description: Attendee's C.R.U.D. 
*/
    
    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use Classes\User;
    use Classes\Background;
    use Classes\BackgroundQuery;
    use App\Helpers\Role;
    use Classes\UserQuery;
    use App\Helpers\Token;
    
    

    class Attendee
    {  
        public static function load()
        {
    
                //Begin Create
                Router::post('/addAttendee', function(Request $req, Response $res){


                        if(!Token::TokenMatching('add_user_token'))
                        {
                            return " ";
                        }

                        echo "You got in!";
                        $attendee = new User();
                        $attendee->setFirstName($req->getBody()['first_name']);
                        $attendee->setLastName($req->getBody()['last_name']);
                        $attendee->setUsername($req->getBody()['username']);
                        $attendee->setPassword(password_hash($req->getBody()['password'],PASSWORD_DEFAULT));
                        $attendee->setEmailAddr($req->getBody()['email_addr']);
                        $attendee->setRole(Role::Attendee);
                        $attendee->save();

                        

                        Token::TokenExpiration('add_user_token');
                });
                //End Create

                //Begin Read
                Router::post('/readAttendee', function(Request $req, Response $res){

                    if(!Token::TokenMatching('read_user_token'))
                    {
                        return " ";
                    }
                    

                    $attendee = UserQuery::create()->findOneByUsername($req->getBody()['username']);

                    $background = BackgroundQuery::create()->findOneByUserId($attendee->getPrimaryKey());

                    Token::TokenExpiration('read_user_token');
                    
                });


                Router::post('/loadAttendees', function(Request $req, Response $res){
                    
                    if(!Token::TokenMatching('`load_attendees_token'))
                    {
                        return " ";
                    }
                    
                        $attendee = UserQuery::create()->find();

                        echo $attendee->toJSON();

                        Token::TokenExpiration('load_attendees_token');
                });

                Router::post('/loadBackgrounds', function(Request $req, Response $res){

                    if(!Token::TokenMatching('load_backgrounds_token'))
                    {
                        return " ";
                    }

                    $background = BackgroundQuery::create()->find();

                    echo $background->toJSON();

                    Token::TokenExpiration('load_backgrounds_token');
                });
                //End Read

                //Begin Update
                Router::post('/updateAttendee', function(Request $req, Response $res){

                    if(!Token::TokenMatching('update_attendees_token'))
                    {
                        return " ";
                    }

                    $attendee = UserQuery::create()->findOneByUsername($req->getBody()['username']);

                    $background = BackgroundQuery::create()->findOneByUserId($attendee->getPrimaryKey());

                    $attendee->setFirstName($req->getBody()['first_name']);
                    $attendee->setLastName($req->getBody()['last_name']);
                    $attendee->setEmailAddr($req->getBody()['email_addr']);
                    $attendee->save();
                    $background->setAge($req->getBody()['age']);
                    $background->setGender($req->getBody()['gender']);
                    $background->setHouseMembers($req->getBody()['house_members']);
                    $background->setZipcode($req->getBody()['zipcode']);
                    $background->setNationality($req->getBody()['nationality']);
                    $background->setDob($req->getBody()['dob']);
                    $background->save();

                    Token::TokenExpiration('update_attendees_token');
                });
                //End Update


                //Begin Delete
                Router::post('/deleteAttendee', function(Request $req, Response $res){

                    if(!Token::TokenMatching('delete_attendee_token'))
                    {
                        return " ";
                    }
                    
                    $attendee = UserQuery::create()->findOneByUsername($req->getBody()['username']);
                    $attendee->delete();

                    Token::TokenExpiration('delete_attendee_token');
                });
                //End Delete
        }
    }

?>