<?php

        class DB{

        public $conn;

        function __construct()
        {
            try
            {
                $this->conn = new PDO("mysql:host=localhost;dbname=rocpass;", 'friedicecream', 'Campbell3%emilia');

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                
            }
            catch(PDOException $e)
            {
                echo "Something wrong";
                echo "Connection failed: ".$e->getMessage();
            }
        }

        public function hashPass($pass)
        {
            return $this->hashPass = hash('sha256', $pass);
        }

        // function create(){}

        // function read(){}

        // function update(){}

        // function delete(){}
    }
?>