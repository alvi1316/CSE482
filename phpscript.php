<?php
    session_start();
    $success = false;
    $response = array();
    $response["success"] = false;
    $response["data"] = null;
  
    if(!isset($_SESSION["username"])){
        header("Location: index.php");
    }

    //request types are upvote, downvote, comment, post, follow, unfollow, notification, getid
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
        }

    }

    echo json_encode($response);
?>