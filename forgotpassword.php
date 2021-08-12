<?php
    session_start();
    $error = false;
    $sent = false;

    if(isset($_SESSION["username"])){
        header("Location: feed.php");
    }

    if(isset($_POST["email"])){

        require_once('dbmanager.php');
        require_once('connectionsingleton.php');

        $dbmanager = new dbmanager();

        $con = connectionSingleton::getConnection();

        $error = !($dbmanager->emailExists($con, $_POST["email"]));

        if(!$error){
            require_once('helper.php');
            $m = new Helper();
            $newPass = $m->generateNewPassword();
            if($dbmanager->resetPassword($con, $_POST["email"], $newPass)){
                $sent = $m->sendNewPassword($_POST["email"],$newPass);
            }            
        }
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title>Login</title>
    </head>
    <body>
        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div style="width: 400px;">
                <form action = "forgotpassword.php" method="Post">
                    <div class="form-group">
                        <?php
                            if($error){
                                echo("<legend class='text-danger animate__animated animate__shakeX animate__fast'>No Account is associated to this email!</legend>");
                            }
                            if($sent){
                                echo("<legend>A password is sent to the email address!</legend>");
                            }
                        ?>
                      <label for="Email">Enter a email address associated to your account.</label>
                      <input name = "email" type="email" class="form-control" id="Email" placeholder="Enter email">
                    </div>       
                    <div class="d-flex mt-2 justify-content-center">
                        <button onclick="return validate()" type="submit" class="btn btn-primary">Reset password</button>
                    </div>             
                    <div class="d-flex mt-2 justify-content-center">
                        <a href="index.php">Back to Login!</a>
                    </div>
                </form>
            </div>
        </div>
        
        <script src="JS/forgotpassword.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>