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

        function read($userName)
        {
            try
            {
                $stmt = $this->conn->prepare("select * from user where username = :username");
                $stmt->bindParam(':username',$userName);

                $stmt->execute();

                $row = $stmt->fetch();

                $arr = array('attendee'=>$row['username'], 'firstName'=>$row['first_name'], 'lastName'=>$row['last_name'], 'email'=>$row['email_addr']);

                return $arr;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        function update($userName, $firstName, $lastName, $email)
        {
            try
            {
                $stmt = $this->conn->prepare("update set first_name= :firstName, last_name = :lastName, email_addr = :email where username = :username");
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email',$email);
                $stmt->bindParam(':username',$userName);

                $status = $stmt->execute();

                if($status > 0)
                {
                    echo "Successfully updated.";
                }
                else
                {
                    echo "Unable to update new information. Please contact technical support";
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        function delete($userName)
        {
            try
            {
                $stmt = $this->conn->prepare('delete from user where username = :username');
                $stmt->bindParam(':username', $userName);
                $status = $stmt->execute();

                if($status > 0)
                {
                    echo "Successfully deleted";
                }
                else
                {
                    echo "Unable to delete the account. Please contact technical support";
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }

?>