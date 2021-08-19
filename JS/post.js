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

    setTimer();

    function setTimer(){
        var postId = $(".upvote").attr("id").split("_")[1];
        var postText = $("#postTextDiv").text();
        var count = postText.match(/(\w+)/g).length;
        if(count>100 && $("#postReadInfo").val()=="notread"){
            var reward = Math.floor(count*0.1);
            setTimeout(function(){
                $.post("http://localhost/phpscript.php",
                    {
                        type: "publishRead",
                        p_id: postId,
                        reward: reward
                    },
                    function(res, status){
                        var data = JSON.parse(res);
                        if(data.success){
                            alert("Post is mark as read!");
                            $('#upvote_'+postId).removeAttr("disabled");
                            $('#downvote_'+postId).removeAttr("disabled");
                            $('#commentBtn').removeAttr("disabled");
                        }else{
                            alert("Action failed! Retry again!");
                        }
                    }
                );    
            }, count*300);
        }
        
    }


    $(document).on('click', '.delete-comment', function(){
        console.log("clicked");
        if(confirm("Do u really want to delete the comment?")){
            var commentId = $(this).attr("id").split("_")[1];
            var postId = $(".upvote").attr("id").split("_")[1];
            $.post("http://localhost/phpscript.php",
                {
                    type: "deleteComment",
                    c_id: commentId,
                    p_id: postId
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        $("#commentDiv_"+commentId).remove();
                        $("#commentcount_"+postId).text((parseInt($("#commentcount_"+postId).text())-1).toString());
                    }else{
                        alert("Action failed! Retry again!");
                    }
                }
            );
        }
    });

    $(".delete-post").click(function(){
        if(confirm("Do you really want to delete this post?")){
            var postId = $(".upvote").attr("id").split("_")[1];
            $.post("http://localhost/phpscript.php",
                {
                    type: "deletePost",
                    p_id: postId
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        window.history.back();
                        setTimeout(() => {
                            location.reload();
                        }, 0);
                    }
                }
            );
        }        
    });

    $("#commentBtn").click(function(){
        var postId = $(".upvote").attr("id").split("_")[1];
        var c_text = $("#commentTextArea").val();
        $.post("http://localhost/phpscript.php",
            {
                type: "publishComment",
                p_id: postId,
                c_text: c_text
            },
            function(res, status){
                var data = JSON.parse(res);
                if(data.success){
                    var div = makeCommentDiv(data.username,c_text,data.c_id);        
                    $("#commentSection").append(div);
                    $("#commentcount_"+postId).text((parseInt($("#commentcount_"+postId).text())+1).toString());
                    $("#commentTextArea").val("");
                }else{
                    alert("Action failed! Retry again!");
                }
            }
        );
    });

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
});


function makeCommentDiv(username, c_text, c_id){
    var div = "<div id='commentDiv_"+c_id+"' class='d-flex flex-row-reverse mb-2'> <div class='col-md-11 col-11 border border-dark'> <div> <p class='d-inline'><b>"+username+"</b></p> <p class='d-inline float-right'>"+getCurrentDate(new Date())+"&nbsp;&nbsp;&nbsp;"+getCurrentTime(new Date())+"</p></div><p>"+c_text+"</p> <div class='p-1'> <button id='delete_"+c_id+"' type='button' class='btn btn-danger btn-sm delete-comment'>Delete</button> </div>";
    return div;
}

function getCurrentDate(date) {
    var mm = date.getMonth() + 1;
    var dd = date.getDate();
  
    return [date.getFullYear()+"-",
            (mm>9 ? '' : '0') + mm +"-",
            (dd>9 ? '' : '0') + dd
           ].join('');
};
  
function getCurrentTime(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12;
    if(hours<10){
        hours = "0"+hours;
    }
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
};


