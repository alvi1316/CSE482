<?php
    session_start();
    $error = false;

    if(isset($_SESSION["username"])){
        header("Location: feed.php");
    }

    if(isset($_POST["email"]) && isset($_POST["password"])){

        require_once('dbmanager.php');
        require_once('connectionsingleton.php');
        $dbmanager = new dbmanager();

        $con = connectionSingleton::getConnection();

        $error = !($dbmanager->login($con, $_POST["email"], $_POST["password"]));

        if(!$error){
            $_SESSION["username"] = $dbmanager->getUsername($con, $_POST["email"]);
            $_SESSION["u_id"] = $dbmanager->getUserId($con, $_SESSION["username"]);
            header("Location: feed.php");
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
        <title>Login</title>
    </head>
    <body>
        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div style="width: 400px;">
                <form action = "index.php" method="Post">
                    <?php
                        if($error){
                            echo("<legend class='text-danger animate__animated animate__shakeX animate__fast'>Invalid Email or Password!</legend>");
                        }
                    ?>
                    <div class="form-group">
                      <label for="Email">Email address</label>
                      <input name="email" type="email" class="form-control" id="Email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="Password">Password</label>
                      <input name="password" type="password" class="form-control" id="Password" placeholder="Password">
                    </div>     
                    <div class="d-flex mt-2 justify-content-center">
                        <button  type="submit" class="btn btn-primary">Login</button>
                    </div>             
                    <div class="d-flex mt-2 justify-content-center">
                        Don't have an account?<a href="signup.php">Signup!</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="forgotpassword.php">Forgot Password!</a>
                    </div>
                </form>
            </div>
        </div>

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>