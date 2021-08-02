<?php

    class dbmanager{

        //Function for signup
        function signup($con, $username, $email, $password){
            $qry = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
            if($con->query($qry)===TRUE){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        
        //Function for login
        function login($con, $email, $password){
            $qry = "SELECT password FROM user WHERE email = '$email'";
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
            $qry = "SELECT username FROM user WHERE email = '$email'";
            $result=$con->query($qry);
            $row=$result->fetch_assoc();
            return $row['username'];
        }

        //Function to check if email exists
        function emailExists($con, $email){
            $qry = "SELECT * FROM user WHERE email = '$email'";
            $valid = FALSE;
            $result=$con->query($qry);
            if(mysqli_num_rows($result) >= 1){
                $valid = true;
            }
            return $valid;
        }

        //Function to update password
        function updatePassword($con, $email, $password){
            $qry = "UPDATE user SET password = '$password' WHERE email = '$email'";
            $valid = FALSE;
            if ($con->query($qry) === TRUE) {
                $valid = true;
            }
            return $valid;
        }

        //Function to return search results
        function searchUser($con, $keyword){
            $qry = "SELECT user.u_id, user.username, badge.name AS reader_badge, badge.name AS writter_badge FROM user INNER JOIN badge ON user.reader_badge=badge.b_id AND user.writter_badge=badge.b_id WHERE username LIKE '%$keyword%'";
            $result = $con->query($qry);
            $rows = array();
            while($row = $result->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
        }

        //Function to return profile user data
        function getProfileUser($con, $username){
            $qry = "SELECT user.u_id, user.username, user.reader_rank, user.writter_rank, user.followers,badge.name AS reader_badge, badge.name AS writter_badge FROM user INNER JOIN badge ON user.reader_badge=badge.b_id AND user.writter_badge=badge.b_id WHERE username = '$username'";
            $result = $con->query($qry);
            $row = $result->fetch_array();
            return $row;
        }
    }
    
?>