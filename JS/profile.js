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
            $(this).removeClass("btn-primary");
            $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())-1).toString());
        }else{

            if($("#downvote_"+postId).hasClass("btn-danger")){
                //Remove downvote and add upvote
                $("#downvote_"+postId).removeClass("btn-danger");
                $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())-1).toString());
                $(this).addClass("btn-primary");
                $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())+1).toString());
            }else{
                //Add upvote
                $(this).addClass("btn-primary");
                $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())+1).toString());
            }

        }
      

    });

    $(".downvote").click(function(){

        var postId = this.id.split("_")[1];

        if($(this).hasClass("btn-danger")){
            //Remove downvote
            $(this).removeClass("btn-danger");
            $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())-1).toString());
        }else{

            if($("#upvote_"+postId).hasClass("btn-primary")){
                //Remove upvote and add downvote
                $("#upvote_"+postId).removeClass("btn-primary");
                $("#upvotecount_"+postId).text((parseInt($("#upvotecount_"+postId).text())-1).toString());
                $(this).addClass("btn-danger");
                $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())+1).toString());
            }else{
                //Add downvote
                $(this).addClass("btn-danger");
                $("#downvotecount_"+postId).text((parseInt($("#downvotecount_"+postId).text())+1).toString());
            }

        }


    });

    $(".comment").click(function(){
        console.log("comment!");
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
                    console.log(res);
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
                    console.log(res);
                    var data = JSON.parse(res);
                    if(data.success){
                        location.reload();
                    }
                }
            );
        }
    });
});