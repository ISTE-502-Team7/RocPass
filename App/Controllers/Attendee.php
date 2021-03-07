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
    use App\Helpers\Key;
    use Classes\UserQuery;
    use App\Helpers\Token;
    
    

    class Attendee
    {  
        public static function load()
        {
    
                //Begin Create
                Router::post('/addAttendee', function(Request $req, Response $res){

                    if(!isset($req->getBody()['cookingrecipes']) || !isset($_SESSION['add_user_token']))
                    {
                        return " ";
                    }

                    if($req->getBody()['cookingrecipes'] == $_SESSION['add_user_token'])
                    {

                        $attendee = new User();
                        $attendee->setFirstName($req->getBody()['first_name']);
                        $attendee->setLastName($req->getBody()['last_name']);
                        $attendee->setUsername($req->getBody()['username']);
                        $attendee->setPassword(password_hash($req->getBody()['password'],PASSWORD_DEFAULT));
                        $attendee->setEmailAddr($req->getBody()['email_addr']);
                        $attendee->setRole(3);
                        $attendee->save();
                        
                        echo $req->getBody()['username'];

                        $attendee = UserQuery::create()->findOneByUsername($req->getBody()['username']);

                        $background = new Background();
                        $background->setAge($req->getBody()['age']);
                        $background->setGender($req->getBody()['gender']);
                        $background->setHouseMembers($req->getBody()['house_members']);
                        $background->setZipcode($req->getBody()['zipcode']);
                        $background->setNationality($req->getBody()['nationality']);
                        $background->setDob($req->getBody()['dob']);
                        $background->setUserId($attendee->getPrimaryKey());
                        $background->save();

                        unset($_SESSION['add_user_token']);

                    }
                });
                //End Create

                //Begin Read
                Router::post('/readAttendee', function(Request $req, Response $res){

                    if(!isset($req->getBody()['cookingrecipes']) || !isset($_SESSION['read_user_token']))
                    {
                        return " ";
                    }

                    if($req->getBody()['cookingrecipes'] == $_SESSION['read_user_token'])
                    {
                        $attendee = UserQuery::create()->findOneByUsername($req->getBody()['username']);

                        $background = BackgroundQuery::create()->findOneByUserId($attendee->getPrimaryKey());

                        unset($_SESSION['read_user_token']);
                    }
                });


                Router::post('/loadAttendees', function(Request $req, Response $res){
                    
                    if(!isset($req->getBody()['cookingrecipes']) || !isset($_SESSION['load_attendees_token']))
                    {
                        return " ";
                    }

                    if($req->getBody()['cookingrecipes'] == $_SESSION['load_attendees_token'])
                    {
                        $attendee = UserQuery::create()->find();

                        echo $attendee->toJSON();

                        unset($_SESSION['load_attendees_token']);
                    }
                });

                Router::post('/loadBackgrounds', function(Request $req, Response $res){

                    if(!isset($req->getBody()['cookingrecipes']) || !isset($_SESSION['load_backgrounds_token']))
                    {
                        return " ";
                    }

                    if($req->getBody()['cookingrecipes'] == $_SESSION['load_backgrounds_token'])
                    {
                        $background = BackgroundQuery::create()->find();

                        echo $background->toJSON();

                        unset($_SESSION['load_backgrounds_token']);
                    }
                });
                //End Read

                //Begin Update
                Router::post('/updateAttendee', function(Request $req, Response $res){

                    if(!isset($req->getBody()['cookingrecipes']) || !isset($_SESSION['update_attendees_token']))
                    {
                        return " ";
                    }

                    if($req->getBody()['cookingrecipes'] == $_SESSION['update_attendees_token'])
                    {
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
                        
                        unset($_SESSION['update_attendees_token']);
                    }

                });
                //End Update


                //Begin Delete
                Router::post('/deleteAttendee', function(Request $req, Response $res){

                    if(!isset($req->getBody()['cookingrecipes']) || !isset($_SESSION['delete_attendee_token']))
                    {
                        return " ";
                    }

                    if($req->getBody()['cookingrecipes'] == $_SESSION['delete_attendee_token'])
                    {
                        $attendee = UserQuery::create()->findOneByUsername($req->getBody()['username']);
                        $attendee->delete();

                        unset($_SESSION['delete_attendee_token']);
                    }
                    
                    
                });
        }
    }

?>