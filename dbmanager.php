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
            if($row!=null){
                if($row['password']==$password){
                    $valid = TRUE;
                }
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

        //Function to get userid
        function getUserId($con, $username){
            $qry = "SELECT u_id FROM user WHERE username = '$username'";
            $result=$con->query($qry);
            $row=$result->fetch_assoc();
            return $row['u_id'];
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
            $qry = "SELECT 
            A.u_id, 
            A.username, 
            B.name AS reader_badge,
            C.name AS writter_badge 
            FROM user AS A
            INNER JOIN badge AS B
            ON A.reader_badge=B.b_id 
            INNER JOIN badge AS C
            ON A.reader_badge=C.b_id 
            WHERE username LIKE '%$keyword%'";
            $result = $con->query($qry);
            $rows = array();
            while($row = $result->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
        }

        //Function to return profile user data
        function getProfileUser($con, $username){
            $qry = "SELECT A.u_id, A.username, A.reader_rank, A.writter_rank, A.followers, C1.name AS reader_badge, C2.name AS writter_badge FROM user AS A INNER JOIN badge AS C1 ON A.reader_badge = C1.b_id INNER JOIN badge AS C2 ON A.writter_badge = C2.b_id WHERE username = '$username'";
            $result = $con->query($qry);
            $row = $result->fetch_array();
            return $row;
        }

        //Function that returns if user is following another user
        function isFollowing($con, $follower_id, $following_id){
            $qry = "SELECT status FROM follow WHERE follower_id = $follower_id and following_id = $following_id";
            $result = $con->query($qry);
            $row = $result->fetch_array();
            return $row;
        }

        //Function to follow a user
        function followUser($con, $follower_id, $following_id){
            $success = false;
            if(self::isFollowing($con, $follower_id, $following_id)==null){
                $qry = "INSERT INTO follow(follower_id, following_id) VALUES ($follower_id, $following_id)";
                if($con->query($qry)==null){
                    $success = false;
                }else{
                    $success = true;
                }
            }else{
                $qry = "UPDATE follow SET status = true WHERE follower_id=$follower_id AND following_id=$following_id";
                if($con->query($qry)==null){
                    $success = false;
                }else{
                    $success = true;
                }
            }
            return $success;
        }

        //Function to publish a post
        function publishPost($con, $id, $postTitle, $postText, $count){

            $success = true;

            $qry = "INSERT INTO post(u_id, title, p_text, p_date, p_time, reward) VALUES ($id,'$postTitle','$postText', CURRENT_DATE(), CURRENT_TIME(), (SELECT CASE WHEN($count*0.1>10) THEN floor($count*0.1) ELSE 0 END));
            UPDATE user SET writter_rank = writter_rank+(SELECT CASE WHEN($count*0.1>10) THEN floor($count*0.1) ELSE 0 END) WHERE u_id = $id;
            UPDATE user SET writter_badge=(SELECT MAX(b_id) FROM badge WHERE (SELECT writter_rank FROM user WHERE u_id = $id)>=minimum_rank) WHERE u_id=$id;
            INSERT INTO summery (u_id, s_date, total_write) VALUES($id,DATE(DATE_FORMAT(CURRENT_DATE,'%Y-%m-01')),1) ON DUPLICATE KEY UPDATE  total_write = total_write+1;";
            
            if($con->multi_query($qry)==null){                
                $success = false;
            }
            
            return $success;
        }

        //Function to get all post of user by id
        function getAllUserPost($con, $id){
            $qry = "SELECT A.p_id, A.u_id, A.title,A.p_text,A.p_date,A.p_time,A.reward,A.upvote,A.downvote,A.comment,B.username FROM post AS A INNER JOIN user AS B ON A.u_id = B.u_id WHERE A.u_id = $id AND A.status = 1";
            $result = $con->query($qry);
            $rows = array();
            while($row = $result->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
        }

        //Fuction to get user activity by id
        function getUserActivity($con, $id){
            $qry = "SELECT * FROM summery WHERE u_id = $id AND YEAR(s_date) = YEAR(CURDATE())";
            $result = $con->query($qry);
            $rows = array();
            while($row = $result->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
        }
    }
    
?>