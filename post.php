<?php

  session_start();
  $error = false;
  $postdetails = null;
  $commentList = null;
  $followList = null;

  if(!isset($_SESSION["username"])){
    header("Location: index.php");
  }
  
  require_once('dbmanager.php');
  require_once('connectionsingleton.php');
  $dbmanager = new dbmanager();
  $con = connectionSingleton::getConnection();
  $followList = $dbmanager->getFollowingList($con, $_SESSION["u_id"]);

  if(!isset($_SESSION["p_id"])){    
    $error = true;
  }else{
    $postdetails = $dbmanager->getPostDetails($con, $_SESSION["p_id"], $_SESSION["u_id"]);
    $commentList = $dbmanager->getComment($con, $_SESSION["p_id"]);
    if($postdetails==null){
      echo($_SESSION["p_id"]);
      echo("ERROR");
      $error = true;
    }
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

    <link rel="stylesheet" type="text/css" href="CSS/post.css">
    
    <title>Post</title>
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
                    echo("<div class='row p-2 m-md-3 m-1 justify-content-center'>
                            <h3 class='d-inline text-danger'>Post not found!</h3>
                          </div>");
                }else{

                  $voteDisabled = "";
                  $commentDisabled = "";
                  $upVoteClass = "";
                  $downVoteClass = "";
                  $hiddenValue = "read";

                  if(strcmp($postdetails["username"],$_SESSION["username"])==0){
                    $voteDisabled = "disabled";
                  }else{

                    if(str_word_count($postdetails["p_text"])>100){
                      if($postdetails["r_id"]==null){
                        $voteDisabled = "disabled";
                        $commentDisabled = "disabled";
                        $hiddenValue = "notread";
                      }
                    }
  
                    if(strcmp($postdetails["vote"],"upvote") == 0){
                      $upVoteClass = "btn-primary";
                    }else if(strcmp($postdetails["vote"],"downvote") == 0){
                      $downVoteClass = "btn-danger";
                    }

                  }

                  echo("
                    <div class='mt-3 px-md-5 py-md-3 p-1 mb-3 border border-dark'>
                    <input type='hidden' id='postReadInfo' value='".$hiddenValue."'>
                    <div>
                      <a class='text-dark' href='profile.php?profilename=".$postdetails["username"]."'><h5 class='d-inline'>".$postdetails["username"]."</h5></a>
                      <p class='float-right'>".$postdetails["p_date"]."&nbsp;&nbsp;&nbsp;".date('h:i a', strtotime($postdetails["p_time"]))."</p>
                    </div>
                    <H4>".$postdetails["title"]."</H4>
                    <p id='postTextDiv'>".$postdetails["p_text"]."</p>
                    <div class='p-1'>
                      <button id='upvote_".$postdetails["p_id"]."' type='button' class='upvote btn btn-sm border border-success ".$upVoteClass."' ".$voteDisabled."><img src='images/post/upvote.png' alt='upvote' style='width: 15px; height: 15px;'></button>
                      <p id='upvotecount_".$postdetails["p_id"]."' class='d-inline'>".$postdetails["upvote"]."</p>
                      <button id='downvote_".$postdetails["p_id"]."' type='button' class='downvote btn btn-sm border border-danger".$downVoteClass."' ".$voteDisabled."><img src='images/post/downvote.png' alt='downvote' style='width: 15px; height: 15px;'></button>
                      <p id='downvotecount_".$postdetails["p_id"]."' class='d-inline'>".$postdetails["downvote"]."</p>
                      <button type='button' class='btn btn-sm border border-warning' disabled><img src='images/post/comment.png' alt='comment' style='width: 15px; height: 15px;'></button>
                      <p id='commentcount_".$postdetails["p_id"]."' class='d-inline'>".$postdetails["comment"]."</p>
                    </div>                
                    </div>
                  ");
                }
              ?>
              
              

              <h5 class="mb-3">Followers thoughts:</h5>

              <div id="commentSection">

                <?php
                  foreach($commentList as $comment){
                    $deleteButton = "";
                    if(strcmp($comment["username"],$_SESSION["username"]) == 0){
                    $deleteButton =   "<div class='p-1'> 
                                          <button id='delete_".$comment["c_id"]."' type='button' class='btn btn-danger btn-sm delete-comment'>Delete</button>
                                      </div>";
                    }
                    echo("
                      <div id='commentDiv_".$comment["c_id"]."' class='d-flex flex-row-reverse mb-2'>
                      <div class='col-md-11 col-11 border border-dark'>
                        <div>
                          <p class='d-inline'><a class='text-dark' href='profile.php?profilename=".$comment["username"]."' ><b>".$comment["username"]."</b></a></p>
                          <p class='d-inline float-right'>".$comment["c_date"]."&nbsp;&nbsp;&nbsp;".date('h:i a', strtotime($comment["c_time"]))."</p>
                        </div>
                        <p>".$comment["c_text"]."</p>".$deleteButton."
                      </div>                
                      </div>
                    ");
                  }
                ?>

              </div>
              <div class="d-flex flex-row-reverse mb-2">
                <div class="col-md-11 col-11 border border-dark">
                  <div class="form-group">
                    <label for="postTitle"><b>Comment here...</b></label>
                    <textarea id="commentTextArea" class="form-control my-2" placeholder="Write your comment here..." rows="3"></textarea>
                    <div class="d-flex flex-column flex-md-row justify-content-end"><button id="commentBtn" class="btn btn-success" <?php echo($commentDisabled); ?> >Comment</button></div>
                  </div>
                </div>                
              </div>    

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
    <script src="JS/post.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </body>
</html>