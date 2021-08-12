<?php
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: index.php");
  }
  require_once('dbmanager.php');
  require_once('connectionsingleton.php');
  $dbmanager = new dbmanager();        
  $con = connectionSingleton::getConnection();
  $followList = $dbmanager->getFollowingList($con, $_SESSION["u_id"]);
  $userInfo = $dbmanager->getProfileUser($con, $_SESSION["username"]); 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="CSS/settings.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>  
    
    <title>Settings</title>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand mb-0 h1">Writer's Vlog</span>
      <form action="search.php" method="post" class="form-inline my-2 my-lg-0">
        <input name="keyword" class="form-control mr-sm-2" type="search" placeholder="Search">
        <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
      </form>
    </nav>

    <div id="mySidenav" class="sidenav bg-secondary">
      <h4 class="text-white mt-2">Following</h4>
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>        
      <input id="searchFollowing1" onkeyup="searchFollowingList1()" class="form-control mr-sm-2" type="search" placeholder="Search following list">  
      <div id="followList1">
        <?php
          foreach($followList as $follow){
            echo("<a class='d-block text-nowrap text-white' href='profile.php?profilename=".$follow["username"]."'>".$follow["username"]."</a>");
          }
        ?>  
      </div>      
    </div>  

    <div class="container-fluid">
        <div class="row" style="height: 100vh;">

          <div class="followDiv h-100 col-md-2 bg-secondary border border-dark d-none d-xs-block d-md-block">
              <h4 class="text-white mt-2">Following</h4>
              <input id="searchFollowing2" onkeyup="searchFollowingList2()" class="form-control mr-sm-2" type="search" placeholder="Search following list">
              <div id="followList2">                
                <?php
                  foreach($followList as $follow){
                    echo("<a class='d-block text-nowrap text-white' href='profile.php?profilename=".$follow["username"]."'>".$follow["username"]."</a>");
                  }
                ?>              
              </div>
          </div>

          <div class="col-md-8 h-100 postDiv">

            <span class="d-block d-md-none" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>   

            <div class="border border-dark mt-3 p-5">
            
              <div class="col">
                
                <div class="row mb-4">
                  <div class="col-md-3">
                    <h5 class="d-inline">Username:</h5>
                  </div>   
                  <div id="usernameText" class="col-md-6">
                    <h5 class="d-inline"><?php echo($_SESSION["username"]); ?></h5>
                  </div>                  
                  <div id="usernameInput" class="col-md-6 d-none">
                    <input id="username" type="text" class="form-control" placeholder="<?php echo($_SESSION["username"]); ?>">
                  </div>
                  <div id="usernameEditBtn" class="col-md-1">
                    <button id="usernameEdit" class="btn btn-sm btn-info">Edit</button>
                  </div>
                  <div id="usernameSaveBtn" class="col-md-1 d-none">
                    <button id="usernameSave" class="btn btn-sm btn-info">Save</button>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-3">
                    <h5 class="d-inline">Email:</h5>
                  </div>   
                  <div id="emailText" class="col-md-6">
                    <h5 class="d-inline"><?php echo($userInfo["email"]); ?></h5>
                  </div>                  
                  <div id="emailInput" class="col-md-6 d-none">
                    <input id="email" type="text" class="form-control" placeholder="<?php echo($userInfo["email"]); ?>">  
                  </div>
                  <div id="emailEditBtn" class="col-md-1">
                    <button id="emailEdit" class="btn btn-sm btn-info">Edit</button>
                  </div>
                  <div id="emailSaveBtn" class="col-md-1 d-none">
                    <button id="emailSave" class="btn btn-sm btn-info">Save</button>
                  </div>
                </div>
  
                <div class="row mb-4">
                  <div class="col-md-3">
                    <h5 class="d-inline">Password:</h5>
                  </div>   
                  <div id="passwordText" class="col-md-6">
                    <h5 class="d-inline">********</h5>
                  </div>                  
                  <div id="passwordInput" class="col-md-6 d-none">
                    <input id="password" type="password" class="form-control" placeholder="********">
                  </div>
                  <div id="passwordEditBtn" class="col-md-1">
                    <button id="passwordEdit" class="btn btn-sm btn-info">Edit</button>
                  </div>
                  <div id="passwordSaveBtn" class="col-md-1 d-none">
                    <button id="passwordSave" class="btn btn-sm btn-info">Save</button>
                  </div>
                </div>                
                
                <div class="row">  
                  <div class="col-md-3">
                    <button id="deactivate" class="btn btn-danger">Deactivate!</button>  
                  </div>           
                </div>

              </div>
              
            </div>

            <div class="d-flex flex-row justify-content-center bg-dark">                                    
              <img src="images/rank/ranktable.png" alt="rank table" class="img-fluid"/>
            </div>

          </div>

          <div class="col-md-2 bg-secondary border border-dark">
            <h4 class="text-white mt-2">Option</h4>
            <a class="d-block text-white" href="profile.php?profilename=<?php echo($_SESSION["username"]);?>"><?php echo($_SESSION["username"]);?></a>
            <a class="d-block text-white" href="feed.php">Home</a>
            <a class="d-block text-white" href="logout.php">Logout</a>
          </div>

        </div>       
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="JS/settings.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </body>
</html>