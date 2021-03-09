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
    }

?>