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
    $("#postBtn").click(function(){
        var title = $("#postTitle").val();
        var postText = $("#postTextArea").val();
        var error = false;

        if(title == ""){
            error = true;
            if(!document.body.contains(document.getElementById("titleHelp"))){
                var newDiv = createDiv("titleHelp", "form-text text-danger animate__animated animate__shakeX animate__fast", "Title cannot be empty!");
                var oldDiv = document.getElementById("postTitle");
                oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
            }else{
                $("#titleHelp").removeClass('animate__animated animate__shakeX animate__fast');
                var wait = setTimeout(function(){
                    $("#titleHelp").addClass('animate__animated animate__shakeX animate__fast');                    
                },1);
            }            
        }else{
            if(document.body.contains(document.getElementById("titleHelp"))){
                var div = document.getElementById("titleHelp");
                div.parentNode.removeChild(div);
            }
        }
        if(postText == ""){
            error = true;
            if(!document.body.contains(document.getElementById("postHelp"))){
                var newDiv = createDiv("postHelp", "form-text text-danger animate__animated animate__shakeX animate__fast", "Post cannot be empty!");
                var oldDiv = document.getElementById("postTextArea");
                oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
            }else{
                $("#postHelp").removeClass('animate__animated animate__shakeX animate__fast');
                var wait = setTimeout(function(){
                    $("#postHelp").addClass('animate__animated animate__shakeX animate__fast');                
                },1);
            }  
        }else{
            if(document.body.contains(document.getElementById("postHelp"))){
                var div = document.getElementById("postHelp");
                div.parentNode.removeChild(div);
            }
        }

        if(!error){
            var count = postText.match(/(\w+)/g).length;
            var id = null;

            $.post("http://localhost/phpscript.php",
                {
                    type: "getid"
                },
                function(res, status){
                    var data = JSON.parse(res);
                    id = data.data;
                    $.post("http://localhost/phpscript.php",
                        {
                            type: "publishPost",
                            u_id: id,
                            postTitle: title,
                            postText: postText,
                            count: count
                        },
                        function(res, status){
                            var data = JSON.parse(res);
                            if(data.success){
                                $("#postTitle").val('');
                                $("#postTextArea").val('');
                                alert("Post is successful!");
                            }
                        }
                    );
                }
            );
        }
    });
});

function createDiv(id, cls, child){
    var newDiv = document.createElement("small");
    newDiv.setAttribute("id",id);
    newDiv.setAttribute("class",cls);
    newDiv.appendChild(document.createTextNode(child));
    return newDiv;
}