<?php
    session_start();
    $success = false;
    $response = array();
    $response["success"] = false;
    $response["data"] = null;
  
    if(!isset($_SESSION["username"])){
        header("Location: index.php");
    }

    //request types are upvote, downvote, comment, post, follow, unfollow, notification, getid, updateUsername, updateEmail, updatePassword, deactivate
    if(isset($_POST["type"])){

        $type = $_POST["type"];
        require_once('dbmanager.php');
        require_once('connectionsingleton.php');

        if(strcmp($type, "follow")==0 && isset($_POST["follower_id"]) && isset($_POST["following_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->followUser($con, $_POST["follower_id"], $_POST["following_id"]);            
        }else if(strcmp($type, "unfollow")==0 && isset($_POST["follower_id"]) && isset($_POST["following_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->unfollowUser($con, $_POST["follower_id"], $_POST["following_id"]);
        }else if(strcmp($type, "publishPost")==0 && isset($_POST["u_id"]) && isset($_POST["postTitle"]) && isset($_POST["postText"]) && isset($_POST["count"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->publishPost($con, $_POST["u_id"], $_POST["postTitle"], $_POST["postText"], $_POST["count"]);
        }else if(strcmp($type, "getid")==0){
            $response["success"] = true;
            $response["data"] = $_SESSION["u_id"];
        }else if(strcmp($type, "updateUsername")==0 && isset($_POST["newUsername"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->updateUsername($con, $_SESSION["u_id"], $_POST["newUsername"]);
            if($response["success"]){
                $_SESSION["username"] = $_POST["newUsername"];
            }
        }else if(strcmp($type, "updateEmail")==0 && isset($_POST["newEmail"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->updateEmail($con, $_SESSION["u_id"], $_POST["newEmail"]);            
        }else if(strcmp($type, "updatePassword")==0 && isset($_POST["newPassword"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->updatePassword($con, $_SESSION["u_id"], $_POST["newPassword"]);            
        }else if(strcmp($type, "deactivate")==0){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->deactivateAccount($con, $_SESSION["u_id"]);            
        }

    }

    echo json_encode($response);
?>