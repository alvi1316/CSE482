<?php
    session_start();
    $success = false;
    $response = array();
    $response["success"] = false;
    $response["data"] = null;
  
    if(!isset($_SESSION["username"])){
        header("Location: index.php");
    }

    //request types are upvote, downvote, comment, post, follow, unfollow, notification, updateUsername, updateEmail, updatePassword, deactivate
    if(isset($_POST["type"])){

        $type = $_POST["type"];
        require_once('dbmanager.php');
        require_once('connectionsingleton.php');

        if(strcmp($type, "follow")==0 && isset($_POST["following_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->followUser($con, $_SESSION["u_id"], $_POST["following_id"]);            
        }else if(strcmp($type, "unfollow")==0 && isset($_POST["following_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->unfollowUser($con, $_SESSION["u_id"], $_POST["following_id"]);
        }else if(strcmp($type, "publishPost")==0 && isset($_POST["postTitle"]) && isset($_POST["postText"]) && isset($_POST["count"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->publishPost($con, $_SESSION["u_id"], $_POST["postTitle"], $_POST["postText"], $_POST["count"]);
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
        }else if(strcmp($type, "removeupvote")==0 && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->removeUpvote($con, $_POST["p_id"], $_SESSION["u_id"]);            
        }else if(strcmp($type, "removedownvoteaddupvote")==0 && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->removeDownvote($con, $_POST["p_id"], $_SESSION["u_id"]);
            while(mysqli_next_result($con)){;}
            if($response["success"]){
                $response["success"] = $dbmanager->addUpvote($con, $_POST["p_id"], $_SESSION["u_id"]);
                while(mysqli_next_result($con)){;}
            }           
        }else if(strcmp($type, "addupvote")==0  && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->addUpvote($con, $_POST["p_id"], $_SESSION["u_id"]);           
        }else if(strcmp($type, "removedownvote")==0  && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->removeDownvote($con, $_POST["p_id"], $_SESSION["u_id"]);         
        }else if(strcmp($type, "removeupvoteadddownvote")==0  && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->removeUpvote($con, $_POST["p_id"], $_SESSION["u_id"]);
            while(mysqli_next_result($con)){;}
            if($response["success"]){
                $response["success"] = $dbmanager->addDownvote($con, $_POST["p_id"], $_SESSION["u_id"]);
                while(mysqli_next_result($con)){;}
            }           
        }else if(strcmp($type, "adddownvote")==0  && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] = $dbmanager->addDownvote($con, $_POST["p_id"], $_SESSION["u_id"]);          
        }else if(strcmp($type, "setsessionpid")==0  && isset($_POST["p_id"])){
            $_SESSION["p_id"] = $_POST["p_id"];
            $response["success"] = true;
        }else if(strcmp($type, "publishComment")==0 && isset($_POST["p_id"]) && isset($_POST["c_text"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $res =  $dbmanager->publishComment($con, $_POST["p_id"], $_SESSION["u_id"], $_POST["c_text"]);
            $response["success"] = $res["success"];
            $response["c_id"] = $res["c_id"];
            $response["username"] = $_SESSION["username"];
        }else if(strcmp($type, "deleteComment")==0 && isset($_POST["c_id"]) && isset($_POST["p_id"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] =  $dbmanager->deleteComment($con, $_POST["c_id"], $_POST["p_id"]);
        }else if(strcmp($type, "publishRead")==0 && isset($_POST["p_id"]) && isset($_POST["reward"])){
            $dbmanager = new dbmanager();        
            $con = connectionSingleton::getConnection();
            $response["success"] =  $dbmanager->publishRead($con, $_POST["p_id"], $_SESSION["u_id"], $_POST["reward"]);
        }
        
    }

    echo json_encode($response);
?>