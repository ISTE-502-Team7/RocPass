<?php
    namespace App\Helpers;
    use App\Lib;

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

        public static function TokenMatching($sessionName)
        {
            if(!constant("ANTI-CSRF"))
            {
                return true;   
            }

            if(!isset($_POST['cookingrecipes']) || !isset($_SESSION[$sessionName]))
            {
                Lib\Logger::potentialAttacks();
                
                return false;
            }

            if(!($_POST['cookingrecipes'] == $_SESSION[$sessionName]))
            {
                Lib\Logger::potentialAttacks();

                return false;

            }
            else
            {
                return True;
            }
        }

        public static function TokenExpiration($sessionName)
        {
            unset($_SESSION[$sessionName]);
        }
    }

?>