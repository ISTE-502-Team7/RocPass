<?php
    namespace App\Helpers;

    class Token {

        public const CookingBook = "nananana_duh!";

        protected static $uuid;

        public static function getUUID()
        {
            return self::$uuid;
        }

        public static function setUUID($token){

            self::$uuid = $token;
        }
    }

?>