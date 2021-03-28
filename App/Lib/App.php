<?php namespace App\Lib;
        use App\Controllers;

    class App
    {
        public static function run()
        {
            Controllers\Attendee::load();
            Controllers\Redirect::load();
            Logger::enableSystemLogs();
        }
    }

?>