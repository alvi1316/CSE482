<?php
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: index.php");
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="CSS/settings.css">
    
    <title>Settings</title>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand mb-0 h1">Writer's Vlog</span>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0">Search</button>
      </form>
    </nav>

    <div id="mySidenav" class="sidenav bg-secondary">
      <h4 class="text-white mt-2">Following</h4>
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>        
      <input id="searchFollowing1" onkeyup="searchFollowingList1()" class="form-control mr-sm-2" type="search" placeholder="Search following list">  
      <div id="followList1">
        <a class="d-block text-nowrap text-white" href="#">Alvi</a>
        <a class="d-block text-nowrap text-white" href="#">Mahin</a>
        <a class="d-block text-nowrap text-white" href="#">Alin</a>
        <a class="d-block text-nowrap text-white" href="#">Adiba</a>
        <a class="d-block text-nowrap text-white" href="#">Srv</a>
        <a class="d-block text-nowrap text-white" href="#">Sanjida</a>
        <a class="d-block text-nowrap text-white" href="#">Mim</a>
      </div>      
    </div>  

    <div class="container-fluid">
        <div class="row" style="height: 100vh;">

          <div class="followDiv h-100 col-md-2 bg-secondary border border-dark d-none d-xs-block d-md-block">
              <h4 class="text-white mt-2">Following</h4>
              <input id="searchFollowing2" onkeyup="searchFollowingList2()" class="form-control mr-sm-2" type="search" placeholder="Search following list">
              <div id="followList2">                
                <a class="d-block text-nowrap text-white" href="#">Alvi</a>
                <a class="d-block text-nowrap text-white" href="#">Mahin</a>
                <a class="d-block text-nowrap text-white" href="#">Alin</a>
                <a class="d-block text-nowrap text-white" href="#">Adiba</a>
                <a class="d-block text-nowrap text-white" href="#">Srv</a>
                <a class="d-block text-nowrap text-white" href="#">Sanjida</a>
                <a class="d-block text-nowrap text-white" href="#">Mim</a>            
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
                    <h5 class="d-inline">username</h5>
                  </div>                  
                  <div id="usernameInput" class="col-md-6 d-none">
                    <input type="text" class="form-control" value="username">
                  </div>
                  <div id="usernameEditBtn" class="col-md-1">
                    <button onclick="usernameEditClick()" class="btn btn-sm btn-info">Edit</button>
                  </div>
                  <div id="usernameSaveBtn" class="col-md-1 d-none">
                    <button onclick="usernameSaveClick()" class="btn btn-sm btn-info">Save</button>
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
                    <input type="password" class="form-control" value="........">
                  </div>
                  <div id="passwordEditBtn" class="col-md-1">
                    <button onclick="passwordEditClick()" class="btn btn-sm btn-info">Edit</button>
                  </div>
                  <div id="passwordSaveBtn" class="col-md-1 d-none">
                    <button onclick="passwordSaveClick()" class="btn btn-sm btn-info">Save</button>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-3">
                    <h5 class="d-inline">Email:</h5>
                  </div>   
                  <div id="emailText" class="col-md-6">
                    <h5 class="d-inline">potato@tomato.com</h5>
                  </div>                  
                  <div id="emailInput" class="col-md-6 d-none">
                    <input type="text" class="form-control" value="potato@tomato.com">
                  </div>
                  <div id="emailEditBtn" class="col-md-1">
                    <button onclick="emailEditClick()" class="btn btn-sm btn-info">Edit</button>
                  </div>
                  <div id="emailSaveBtn" class="col-md-1 d-none">
                    <button onclick="emailSaveClick()" class="btn btn-sm btn-info">Save</button>
                  </div>
                </div>
                
                <div class="row">  
                  <div class="col-md-3">
                    <button class="btn btn-danger">Deactivate!</button>  
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
            <a class="d-block text-white" href="feed.php">Home</a>
            <a class="d-block text-white" href="#">Settings</a>
            <a class="d-block text-white" href="logout.php">Logout</a>
          </div>

        </div>       
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="JS/settings.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </body>
</html>