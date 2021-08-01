<?php

    class dbmanager{

        //Function for signup
        function signup($con, $username, $email, $password){
            $qry = "INSERT INTO idontknow.user (username, email, password) VALUES ('$username', '$email', '$password')";
            if($con->query($qry)===TRUE){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        
        //Function for login
        function login($con, $email, $password){
            $qry = "SELECT password FROM idontknow.user WHERE email = '$email'";
            $valid = FALSE;
            $result=$con->query($qry);
            $row=$result->fetch_assoc();
            if($row['password']==$password){
                $valid = TRUE;
            }
            return $valid;
        }

        //Function to get username
        function getUsername($con, $email){
            $qry = "SELECT username FROM idontknow.user WHERE email = '$email'";
            $result=$con->query($qry);
            $row=$result->fetch_assoc();
            return $row['username'];
        }

        //Function to check if email exists
        function emailExists($con, $email){
            $qry = "SELECT * FROM idontknow.user WHERE email = '$email'";
            $valid = FALSE;
            $result=$con->query($qry);
            if(mysqli_num_rows($result) >= 1){
                $valid = true;
            }
            return $valid;
        }

        //Function to update password
        function updatePassword($con, $email, $password){
            $qry = "UPDATE idontknow.user SET password = '$password' WHERE email = '$email'";
            $valid = FALSE;
            if ($con->query($qry) === TRUE) {
                $valid = true;
            }
            return $valid;
        }
    }
    
?>