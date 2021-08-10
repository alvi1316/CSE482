<?php
  session_start();
  $error = false;
  $userInfo = null;
  $followBtn = null;

  if(!isset($_SESSION["username"])){
      header("Location: index.php");
  }

  if(isset($_GET["profilename"])){
    require_once('dbmanager.php');
    require_once('connectionsingleton.php');

    $dbmanager = new dbmanager();
        
    $con = connectionSingleton::getConnection();

    $userInfo = $dbmanager->getProfileUser($con, $_GET["profilename"]);

    if($userInfo==null){
      $error = true;
    }

    if(strcmp($_GET["profilename"],$_SESSION["username"])!=0 && !$error){
      $following_id = $dbmanager->getUserId($con, $_GET["profilename"]);
      $row = $dbmanager->isFollowing($con, $_SESSION["u_id"], $following_id);
      if($row==null){
        $followBtn = "Follow";
      }else{
        if($row["status"]==1){
          $followBtn = "Following";
        }else{
          $followBtn = "Follow";
        }
      }
    }

  }else{
    $error = true;
  }
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
    <link rel="stylesheet" type="text/css" href="CSS/profile.css">
    <script>
      window.onload = function () {
       
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Activity this year"
            },
            axisY: {
                title: "Post"
            },
            axisX: {
                title: "Month",
                interval: 1
            },            
            data: [
              {
                type: "line",
                legendText: "Written",
                showInLegend: true, 
                dataPoints: [
                  {y:25, label:"Jan"},
                  {y:5, label:"Feb"},
                  {y:30, label:"Mar"},
                  {y:22, label:"Apr"},
                  {y:22, label:"May"},
                  {y:25, label:"Jun"},
                  {y:5, label:"Jul"},
                  {y:30, label:"Aug"},
                  {y:22, label:"Sep"},
                  {y:25, label:"Oct"},
                  {y:5, label:"Nov"},
                  {y:22, label:"Dec"}
                ]            
              },
              {
                type: "line",
                legendText: "Read",
                showInLegend: true, 
                dataPoints: [
                  {y:6, label:"Jan"},
                  {y:2, label:"Feb"},
                  {y:28, label:"Mar"},
                  {y:23, label:"Apr"},
                  {y:25, label:"May"},
                  {y:26, label:"Jun"},
                  {y:8, label:"Jul"},
                  {y:32, label:"Aug"},
                  {y:2, label:"Sep"},
                  {y:22, label:"Oct"},
                  {y:12, label:"Nov"},
                  {y:20, label:"Dec"}
                ]            
              }
          ]
        });

        chart.render();       
      }
    </script>

    <title>Profile</title>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand mb-0 h1">Potato Rotato</span>
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
              
              <?php
                if($error){
                    echo("
                      <div class='row p-2 m-md-3 m-1 justify-content-center'>
                        <h3 class='d-inline text-danger'>No user exists!</h3>
                      </div>
                  ");
                }else{
                  echo("
                    <div class='mt-md-3 mb-3 p-sm-5 p-1 border border-dark' style='height: 450px;'>
                      <h5 class='mb-3'>".$userInfo["username"]."</h5>
                      <div class='mb-1'>
                        <p class='d-inline'>Writter Rank:</p>
                        <img class='mr-5' src='images/rank/".$userInfo["writter_badge"].".png' alt='".$userInfo["writter_badge"]."' style='width: 40px; height: 40px;'>
                        <p class='mr-5 d-sm-inline'>Writter Points: ".$userInfo["writter_rank"]."</p>
                        <p class='d-inline'>Followers</p>
                        <img src='images/post/follower.png' alt='follower' style='width: 25px; height: 25px;'>
                        <p class='d-inline'>".$userInfo["followers"]."</p>
                  ");
                  if($followBtn!=null){
                    echo("
                      <button class='btn btn-outline-primary my-2 my-sm-0 float-right'>".$followBtn."</button>
                    ");
                  }                        
                  echo("      
                      </div>
                      <div class='mb-4'>
                        <p class='d-inline'>Reader Rank:</p>
                        <img class='mr-5' src='images/rank/".$userInfo["reader_badge"].".png' alt='".$userInfo["reader_badge"]."' style='width: 40px; height: 40px;'>
                        <p class='d-sm-inline'>Reader Points: ".$userInfo["reader_rank"]."</p>
                      </div>  
                      <div class='border border-dark' id='chartContainer' style='height: 200px; width: 100%;'></div>             
                    </div>     
                  ");
                }             
              ?>                    
              
              <div class="px-md-5 py-md-3 p-1 mb-3 border border-dark">
                <div>
                  <a class="text-dark" href="#"><h5 class="d-inline">Username</h5></a>
                  <p class="float-right">Date and Time</p>
                </div>
                <H4>Title</H4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <div class="p-1">
                  <img src="images/post/upvote.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">26</p>
                  <img src="images/post/downvote.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">9</p>
                  <img src="images/post/comment.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">3</p>
                  <a class="float-right" href="#">Read Post</a>
                </div>                
              </div>

              <div class="px-md-5 py-md-3 p-1 mb-3 border border-dark">
                <div>
                  <a class="text-dark" href="#"><h5 class="d-inline">Username</h5></a>
                  <p class="float-right">Date and Time</p>
                </div>
                <H4>Title</H4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <div class="p-1">
                  <img src="images/post/upvote.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">26</p>
                  <img src="images/post/downvote.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">9</p>
                  <img src="images/post/comment.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">3</p>
                  <a class="float-right" href="#">Read Post</a>
                </div>                
              </div>

              <div class="px-md-5 py-md-3 p-1 mb-3 border border-dark">
                <div>
                  <a class="text-dark" href="#"><h5 class="d-inline">Username</h5></a>
                  <p class="float-right">Date and Time</p>
                </div>
                <H4>Title</H4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <div class="p-1">
                  <img src="images/post/upvote.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">26</p>
                  <img src="images/post/downvote.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">9</p>
                  <img src="images/post/comment.png" alt="upvote" style="width: 15px; height: 15px;">
                  <p class="d-inline">3</p>
                  <a class="float-right" href="#">Read Post</a>
                </div>                
              </div>

            </div>

            <div class="col-md-2 bg-secondary border border-dark">
              <h4 class="text-white mt-2">Option</h4>
              <a class="d-block text-white" href="feed.php">Home</a>
              <a class="d-block text-white" href="settings.php">Settings</a>
              <a class="d-block text-white" href="logout.php">Logout</a>
            </div>

        </div>       
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="JS/profile.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </body>
</html>