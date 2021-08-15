<?php
  session_start();
  $error = false;
  $userInfo = null;
  $userPost = null;
  $userActivity = null;
  $followList = null;
  $chartData = null;
  $followBtn = null;

  if(!isset($_SESSION["username"])){
      header("Location: index.php");
  }

  require_once('dbmanager.php');
  require_once('connectionsingleton.php');
  $dbmanager = new dbmanager();
  $con = connectionSingleton::getConnection();
  $followList = $dbmanager->getFollowingList($con, $_SESSION["u_id"]);
  
  if(isset($_GET["profilename"])){    

    $userInfo = $dbmanager->getProfileUser($con, $_GET["profilename"]);   

    if($userInfo==null){
      $error = true;
    }else{

      $userPost = $dbmanager->getAllUserPost($con, $userInfo["u_id"]);
      $userActivity = $dbmanager->getUserActivity($con, $userInfo["u_id"]);
      $chartData = array();

      //Searching for activity the whole year and filling with 0 if null
      for($i=1;$i<=12;$i++){
        $chartData[$i] = array();
        $flag = false;
        foreach($userActivity as $activity){
          $month = date("m",strtotime($activity["s_date"]));          
          if(intval($month) == $i){           
            $chartData[$i]["y_read"] = $activity["total_read"];
            $chartData[$i]["y_write"] = $activity["total_write"];
            $flag = true;
            break;
          }          
        }
        if(!$flag){
          $chartData[$i]["y_read"] = 0;
          $chartData[$i]["y_write"] = 0;
        }        
      }

      if(strcmp($_SESSION["u_id"], $userInfo["u_id"])!=0){
        $row = $dbmanager->isFollowing($con, $_SESSION["u_id"], $userInfo["u_id"]);
        if($row==null){
          $followBtn = "Follow";
        }else{
          if($row["status"]==1){
            $followBtn = "Unfollow";
          }else{
            $followBtn = "Follow";
          }
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
                  <?php 
                    if(!$error){
                      echo("{y:".$chartData[1]["y_write"].", label:'jan'},");
                      echo("{y:".$chartData[2]["y_write"].", label:'feb'},");
                      echo("{y:".$chartData[3]["y_write"].", label:'mar'},");
                      echo("{y:".$chartData[4]["y_write"].", label:'apr'},");
                      echo("{y:".$chartData[5]["y_write"].", label:'may'},");
                      echo("{y:".$chartData[6]["y_write"].", label:'jun'},");
                      echo("{y:".$chartData[7]["y_write"].", label:'jul'},");
                      echo("{y:".$chartData[8]["y_write"].", label:'aug'},");
                      echo("{y:".$chartData[9]["y_write"].", label:'sep'},");
                      echo("{y:".$chartData[10]["y_write"].", label:'oct'},");
                      echo("{y:".$chartData[11]["y_write"].", label:'nov'},");
                      echo("{y:".$chartData[12]["y_write"].", label:'dec'}");  
                    }
                                      
                  ?>                  
                ]            
              },
              {
                type: "line",
                legendText: "Read",
                showInLegend: true, 
                dataPoints: [
                  <?php 
                    if(!$error){
                      echo("{y:".$chartData[1]["y_read"].", label:'jan'},");
                      echo("{y:".$chartData[2]["y_read"].", label:'feb'},");
                      echo("{y:".$chartData[3]["y_read"].", label:'mar'},");
                      echo("{y:".$chartData[4]["y_read"].", label:'apr'},");
                      echo("{y:".$chartData[5]["y_read"].", label:'may'},");
                      echo("{y:".$chartData[6]["y_read"].", label:'jun'},");
                      echo("{y:".$chartData[7]["y_read"].", label:'jul'},");
                      echo("{y:".$chartData[8]["y_read"].", label:'aug'},");
                      echo("{y:".$chartData[9]["y_read"].", label:'sep'},");
                      echo("{y:".$chartData[10]["y_read"].", label:'oct'},");
                      echo("{y:".$chartData[11]["y_read"].", label:'nov'},");
                      echo("{y:".$chartData[12]["y_read"].", label:'dec'}");
                    }  

                  ?>
                ]            
              }
          ]
        });
        <?php
          if(!$error){
            echo "chart.render();";
          }
        ?>
               
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
                      <p id='profileId' hidden>".$userInfo["u_id"]."</p>
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
                      <button class='btn btn-outline-primary my-2 my-sm-0 float-right follow-btn'>".$followBtn."</button>
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
                  if ($userPost == null && strcmp($followBtn,"Follow")!=0){
                    echo("
                          <div class='row p-2 m-md-3 m-1 justify-content-center'>
                            <h5 class='d-inline text-danger'>No Activity!</h5>
                          </div>
                        ");
                  }
                  if(strcmp($followBtn,"Follow")!=0){
                    foreach ($userPost as $post) {                  
                      if($post["reward"]>0){
    
                        $pieces = explode(" ", $post["p_text"]);
                        $p_text = implode(" ", array_splice($pieces, 0, 100));
    
                        echo("
                            <div class='px-md-5 py-md-3 p-1 mb-3 border border-dark'>
                            <div>
                              <a class='text-dark' href='profile.php?profilename=".$post["username"]."'><h6 class='d-inline'>".$post["username"]."</h6></a>
                              <p class='float-right'>".$post["p_date"]."&nbsp;&nbsp;&nbsp;".date('h:i a', strtotime($post["p_time"]))."</p>
                            </div>
                            <H4>".$post["title"]."</H4>
                            <p>".$p_text."..."."</p>
                            <div class='p-1'>                            
                        "); 
                        if(strcmp($post["vote"],"upvote")==0){
                          echo("<button type='button' class='btn btn-primary btn-sm border border-success' disabled>");
                        }else{
                          echo("<button type='button' class='btn btn-sm border border-success' disabled>");
                        }                        
                        echo("<img src='images/post/upvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                              <p class='d-inline'>".$post["upvote"]."</p>
                        ");
                        if(strcmp($post["vote"],"downvote")==0){
                          echo("<button type='button' class='btn btn-danger btn-sm border border-danger' disabled>");
                        }else{
                          echo("<button type='button' class='btn btn-sm border border-danger' disabled>");
                        }                        
                        echo("<img src='images/post/downvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                              <p class='d-inline'>".$post["downvote"]."</p>
                              <button type='button' class='btn btn-sm border border-warning' disabled><img src='images/post/comment.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                              <p class='d-inline'>".$post["comment"]."</p>
                              <a id='readmore_".$post["p_id"]."' class='readmore float-right' href=''>Read More</a>
                            </div>                
                            </div>
                        ");                      
                      }else{
                        if(strcmp($post["username"],$_SESSION["username"])==0){
                          echo("
                            <div class='px-md-5 py-md-3 p-1 mb-3 border border-dark'>
                            <div>
                              <a class='text-dark' href='profile.php?profilename=".$post["username"]."'><h6 class='d-inline'>".$post["username"]."</h6></a>
                              <p class='float-right'>".$post["p_date"]."&nbsp;&nbsp;&nbsp;".date('h:i a', strtotime($post["p_time"]))."</p>
                            </div>
                            <H4>".$post["title"]."</H4>
                            <p>".$post["p_text"]."</p>
                            <div class='p-1'>                              
                                <button type='button' class='btn btn-sm border border-success' disabled><img src='images/post/upvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                                <p class='d-inline'>".$post["upvote"]."</p>
                                <button type='button' class='btn btn-sm border border-danger' disabled><img src='images/post/downvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                                <p class='d-inline'>".$post["downvote"]."</p>
                                <button id='comment_".$post["p_id"]."' type='button' class='comment btn btn-sm border border-warning'><img src='images/post/comment.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                                <p class='d-inline'>".$post["comment"]."</p>                                
                              </div>                
                              </div>
                          ");
    
                        }else{
                          echo("
                            <div class='px-md-5 py-md-3 p-1 mb-3 border border-dark'>
                            <div>
                              <a class='text-dark' href='profile.php?profilename=".$post["username"]."'><h6 class='d-inline'>".$post["username"]."</h6></a>
                              <p class='float-right'>".$post["p_date"]."&nbsp;&nbsp;&nbsp;".date('h:i a', strtotime($post["p_time"]))."</p>
                            </div>
                            <H4>".$post["title"]."</H4>
                            <p>".$post["p_text"]."</p>
                            <div class='p-1'>                            
                          "); 
                          if(strcmp($post["vote"],"upvote")==0){
                            echo("<button id='upvote_".$post["p_id"]."' type='button' class='upvote btn btn-primary btn-sm border border-success'>");
                          }else{
                            echo("<button id='upvote_".$post["p_id"]."' type='button' class='upvote btn btn-sm border border-success'>");
                          }                        
                          echo("<img src='images/post/upvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                                <p id='upvotecount_".$post["p_id"]."' class='d-inline'>".$post["upvote"]."</p>
                          ");
                          if(strcmp($post["vote"],"downvote")==0){
                            echo("<button id='downvote_".$post["p_id"]."' type='button' class='downvote btn btn-danger btn-sm border border-danger'>");
                          }else{
                            echo("<button id='downvote_".$post["p_id"]."' type='button' class='downvote btn btn-sm border border-danger'>");
                          }                        
                          echo("<img src='images/post/downvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                                <p id='downvotecount_".$post["p_id"]."' class='d-inline'>".$post["downvote"]."</p>
                                <button id='comment_".$post["p_id"]."' type='button' class='comment btn btn-sm border border-warning'><img src='images/post/comment.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                                <p class='d-inline'>".$post["comment"]."</p>
                              </div>                
                              </div>
                          ");    
                        }
                      }
                    }                    
                  }
                }
              ?>

            </div>

            <div class="col-md-2 bg-secondary border border-dark">
              <h4 class="text-white mt-2">Option</h4>
              <a class="d-block text-white" href="profile.php?profilename=<?php echo($_SESSION["username"]);?>"><?php echo($_SESSION["username"]);?></a>
              <a class="d-block text-white" href="feed.php">Home</a>
              <a class="d-block text-white" href="settings.php">Settings</a>
              <a class="d-block text-white" href="logout.php">Logout</a>
            </div>

        </div>       
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="JS/profile.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </body>
</html>