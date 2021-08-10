<?php
    session_start();
    $success = false;
  
    if(!isset($_SESSION["username"])){
        header("Location: index.php");
    }

    //request types are upvote, downvote, comment, post, follow, unfollow, notification
    if(isset($_POST["type"])){

        $type = $_POST["type"];
        require_once('dbmanager.php');
        require_once('connectionsingleton.php');

        if(strcmp($type, "follow")==0 && isset($_POST["follower_id"]) && isset($_POST["following_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $success = $dbmanager->followUser($con, $_POST["follower_id"], $_POST["following_id"]);            
        }

        if($success){
            echo(1);
        }else{
            echo(0);
        }

    }else{
        echo(0);
    }

    
?>