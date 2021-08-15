function openNav() {
    document.getElementById("mySidenav").style.width = "150px";
    document.getElementById("mySidenav").style.paddingRight = "15px";
    document.getElementById("mySidenav").style.paddingLeft = "15px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("mySidenav").style.paddingRight = "0";
    document.getElementById("mySidenav").style.paddingLeft = "0";
}

function searchFollowingList1() {

    var input, div, lst, a, i, txtValue;

    input = document.getElementById("searchFollowing1");
    input = input.value.toUpperCase();
    div = document.getElementById("followList1");
    lst = div.getElementsByTagName("a");

    for (i = 0; i < lst.length; i++) {
        a = lst[i];        
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().includes(input)) {
            lst[i].classList.remove("d-none");
            lst[i].classList.add("d-block");
        } else {
            lst[i].classList.remove("d-block");
            lst[i].classList.add("d-none");
        }
    }
}

function searchFollowingList2() {

    var input, div, lst, a, i, txtValue;

    input = document.getElementById("searchFollowing2");
    input = input.value.toUpperCase();
    div = document.getElementById("followList2");
    lst = div.getElementsByTagName("a");

    for (i = 0; i < lst.length; i++) {
        a = lst[i];        
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().includes(input)) {
            lst[i].classList.remove("d-none");
            lst[i].classList.add("d-block");
        } else {
            lst[i].classList.remove("d-block");
            lst[i].classList.add("d-none");
        }
    }
}

$(document).ready(function(){

    $(".upvote").click(function(){

        var postId = this.id.split("_")[1];

        if($(this).hasClass("btn-primary")){
            //Remove upvote
            $.post("http://localhost/phpscript.php",
                {
                    type: "removeupvote",
                    p_id: postId
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        $("#upvote_"+postId).removeClass("btn-primary");
                        $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())-1).toString());
                    }
                }
            );           
        }else{

            if($("#downvote_"+postId).hasClass("btn-danger")){
                //Remove downvote and add upvote
                $.post("http://localhost/phpscript.php",
                    {
                        type: "removedownvoteaddupvote",
                        p_id: postId
                    },
                    function(res, status){
                        
                        var data = JSON.parse(res);
                        if(data.success){
                            $("#downvote_"+postId).removeClass("btn-danger");
                            $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())-1).toString());
                            $("#upvote_"+postId).addClass("btn-primary");
                            $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())+1).toString());
                        }
                    }
                );                
            }else{
                //Add upvote
                $.post("http://localhost/phpscript.php",
                    {
                        type: "addupvote",
                        p_id: postId
                    },
                    function(res, status){
                        var data = JSON.parse(res);
                        if(data.success){
                            $("#upvote_"+postId).addClass("btn-primary");
                            $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())+1).toString());
                        }
                    }
                ); 
            }

        }
      

    });

    $(".downvote").click(function(){
        
        var postId = this.id.split("_")[1];

        if($(this).hasClass("btn-danger")){
            //Remove downvote
            
            $.post("http://localhost/phpscript.php",
                {
                    type: "removedownvote",
                    p_id: postId
                },
                function(res, status){
                    
                    var data = JSON.parse(res);
                    if(data.success){
                        $("#downvote_"+postId).removeClass("btn-danger");
                        $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())-1).toString());
                    }
                }
            );

        }else{

            if($("#upvote_"+postId).hasClass("btn-primary")){
                //Remove upvote and add downvote

                $.post("http://localhost/phpscript.php",
                    {
                        type: "removeupvoteadddownvote",
                        p_id: postId
                    },
                    function(res, status){
                        
                        var data = JSON.parse(res);
                        
                        if(data.success){
                            $("#upvote_"+postId).removeClass("btn-primary");
                            $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())-1).toString());
                            $("#downvote_"+postId).addClass("btn-danger");
                            $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())+1).toString());
                        }
                    }
                );

            }else{
                //Add downvote

                $.post("http://localhost/phpscript.php",
                    {
                        type: "adddownvote",
                        p_id: postId
                    },
                    function(res, status){
                        var data = JSON.parse(res);
                        if(data.success){
                            $("#downvote_"+postId).addClass("btn-danger");
                            $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())+1).toString());
                        }
                    }
                );                
            }

        }


    });

    $(".comment").click(function(){
        var postId = this.id.split("_")[1];

        $.post("http://localhost/phpscript.php",
            {
                type: "setsessionpid",
                p_id: postId
            },
            function(res, status){
                
                var data = JSON.parse(res);
                if(data.success){
                    window.location.replace("post.php");
                }
            }
        );
        
    });

    $(".readmore").click(function(){
        
        var postId = this.id.split("_")[1];

        $.post("http://localhost/phpscript.php",
            {
                type: "setsessionpid",
                p_id: postId
            },
            function(res, status){
                
                var data = JSON.parse(res);
                if(data.success){
                    window.location.replace("post.php");
                }
            }
        );
        
    });


    $(".follow-btn").click(function(){
        var val = $(".follow-btn").text();
        var following_id = $("#profileId").text();

        if(val == "Follow"){           

            $.post("http://localhost/phpscript.php",
                {
                    type: "follow",
                    following_id: following_id,
                },
                function(res, status){
                    
                    var data = JSON.parse(res);
                    if(data.success){
                        location.reload();
                    }
                }
            );

        }else if(val == "Unfollow"){
            $.post("http://localhost/phpscript.php",
                {
                    type: "unfollow",
                    following_id: following_id,

                },
                function(res, status){
                    
                    var data = JSON.parse(res);
                    if(data.success){
                        location.reload();
                    }
                }
            );
        }
    });
});