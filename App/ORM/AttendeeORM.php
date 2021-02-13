<?php namespace App\ORM;


        require('./vendor/autoload.php');
        require('./App/ORM/DBinit.php');

        $attendee = new Attendee();
        $attendee->setFirstname('first');
        $attendee->setLastname('last');
?>