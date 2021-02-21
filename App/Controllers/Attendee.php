<?php namespace App\Controllers;
    
    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use Classes\User;
    
    

    class AttendeeCtrl
    {
        

        public static function jump()
        {
                
                // $attendee = new User();
                // $attendee->setFirstName("Joel");
                // $attendee->setLastName("Borden");
                // $attendee->setUsername("LastJedi");
                // $attendee->setPassword("chocolate");
                // $attendee->setEmailAddr("jumpsky@gmail.com");
                // $attendee->setRole(0);
                // $attendee->save();
                Router::post('/addAttendee', function(){
                    $attendee = new User();
                    $attendee->setFirstName("Joel");
                    $attendee->setLastName("Borden");
                    $attendee->setUsername("OMG, Finally");
                    $attendee->setPassword("chocolate");
                    $attendee->setEmailAddr("jumpsky@gmail.com");
                    $attendee->setRole(0);
                    $attendee->save();
    
                    echo "Yoohoo!";
                });
        }
    }

?>