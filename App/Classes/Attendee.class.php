<?php include("PDO.DB.class.php");

    class Attendee extends DB{

        function create($first, $last, $userName, $password, $email, $role)
        {
            try
            {
                $hashed = $this->hashPass($password);
                $stmt = $this->conn->prepare("insert into user (first_name, last_name, username, password, email_addr, role) values (:first,:last,:username,:password,:email,:role)");
                $stmt->bindParam(':first',$first);
                $stmt->bindParam(':last',$last);
                $stmt->bindParam(':username',$userName);
                $stmt->bindParam(':password',$hashed);
                $stmt->bindParam(':email',$email);
                $stmt->bindParam(':role',$role);

                $insert = $stmt->execute();

                if($insert > 0)
                {
                    echo "Success!!";
                }
                else
                {
                    echo "Failed!!";
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            
        }

        function read()
        {

        }

        function update()
        {

        }

        function delete()
        {

        }
    }

?>