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
    $("#usernameEdit").click(function(){
        document.getElementById("usernameEditBtn").classList.add("d-none");
        document.getElementById("usernameText").classList.add("d-none");
        document.getElementById("usernameInput").classList.remove("d-none");
        document.getElementById("usernameSaveBtn").classList.remove("d-none");
        
    });
    $("#usernameSave").click(function(){
        var username = $("#username").val();
        if(!(/^[a-z\d]{6,}$/gi.test(username))){
            if(document.body.contains(document.getElementById("usernameHelp"))){
                $("#usernameHelp").removeClass('d-block animate__animated animate__shakeX');
                var wait = setTimeout(function(){
                    $("#usernameHelp").addClass('d-block animate__animated animate__shakeX');                    
                },1);                
            }else{
                var newDiv = createSmall("usernameHelp", "d-block text-danger animate__animated animate__shakeX", "Username has to be atleast 6 characters long!");
                var oldDiv = document.getElementById("username");
                oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
            }

        }else{
            if(document.body.contains(document.getElementById("usernameHelp"))){
                var div = document.getElementById("usernameHelp");
                div.parentNode.removeChild(div);
            }
            var newUsername = $("#username").val();
            $("#username").val("");

            $.post("http://localhost/phpscript.php",
                {
                    type: "updateUsername",
                    newUsername: newUsername,                   
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        alert("Username is updated!");
                        location.reload();
                    }else{
                        alert("Username update failed!");
                    }
                }
            );

            //Backend here
            document.getElementById("usernameEditBtn").classList.remove("d-none");
            document.getElementById("usernameText").classList.remove("d-none");
            document.getElementById("usernameInput").classList.add("d-none");
            document.getElementById("usernameSaveBtn").classList.add("d-none");
        }     
        
    });




    $("#emailEdit").click(function(){
        document.getElementById("emailEditBtn").classList.add("d-none");
        document.getElementById("emailText").classList.add("d-none");
        document.getElementById("emailInput").classList.remove("d-none");
        document.getElementById("emailSaveBtn").classList.remove("d-none");
        
    });


    $("#emailSave").click(function(){

        var email = $("#email").val();
        if(!(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email))){
            if(document.body.contains(document.getElementById("emailHelp"))){
                $("#emailHelp").removeClass('d-block animate__animated animate__shakeX');
                var wait = setTimeout(function(){
                    $("#emailHelp").addClass('d-block animate__animated animate__shakeX');                    
                },1);                
            }else{
                var newDiv = createSmall("emailHelp", "d-block text-danger animate__animated animate__shakeX", "Enter a valid email!");
                var oldDiv = document.getElementById("email");
                oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
            }

        }else{
            if(document.body.contains(document.getElementById("emailHelp"))){
                var div = document.getElementById("emailHelp");
                div.parentNode.removeChild(div);
            }

            var newEmail = $("#email").val();
            $("#email").val("");

            $.post("http://localhost/phpscript.php",
                {
                    type: "updateEmail",
                    newEmail: newEmail,                   
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        alert("Email is updated!");
                        location.reload();
                    }else{
                        alert("Email update failed!");
                    }
                }
            );

            //Backend here
            document.getElementById("emailEditBtn").classList.remove("d-none");
            document.getElementById("emailText").classList.remove("d-none");
            document.getElementById("emailInput").classList.add("d-none");
            document.getElementById("emailSaveBtn").classList.add("d-none");
        }
    });


    $("#passwordEdit").click(function(){
        document.getElementById("passwordEditBtn").classList.add("d-none");
        document.getElementById("passwordText").classList.add("d-none");
        document.getElementById("passwordInput").classList.remove("d-none");
        document.getElementById("passwordSaveBtn").classList.remove("d-none");        
    });


    $("#passwordSave").click(function(){

        var password = $("#password").val();
        if(!(/^[a-z\d]{6,}$/gi.test(password))){
            if(document.body.contains(document.getElementById("passwordHelp"))){
                $("#passwordHelp").removeClass('d-block animate__animated animate__shakeX');
                var wait = setTimeout(function(){
                    $("#passwordHelp").addClass('d-block animate__animated animate__shakeX');                    
                },1);                
            }else{
                var newDiv = createSmall("passwordHelp", "d-block text-danger animate__animated animate__shakeX", "Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji!");
                var oldDiv = document.getElementById("password");
                oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
            }

        }else{
            if(document.body.contains(document.getElementById("passwordHelp"))){
                var div = document.getElementById("passwordHelp");
                div.parentNode.removeChild(div);
            }
            var newPassword = $("#password").val();
            $("#password").val("");

            $.post("http://localhost/phpscript.php",
                {
                    type: "updatePassword",
                    newPassword: newPassword,                   
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        alert("Password is updated!");
                        location.reload();
                    }else{
                        alert("Password update failed!");
                    }
                }
            );

            //Backend here
            document.getElementById("passwordEditBtn").classList.remove("d-none");
            document.getElementById("passwordText").classList.remove("d-none");
            document.getElementById("passwordInput").classList.add("d-none");
            document.getElementById("passwordSaveBtn").classList.add("d-none");
        }
        
    });

    $("#deactivate").click(function(){
        if (confirm('Do your really want to deactivate the account!')) {  
            console.log("YES");          
            $.post("http://localhost/phpscript.php",
                {
                    type: "deactivate"
                },
                function(res, status){
                    var data = JSON.parse(res);
                    if(data.success){
                        alert("Account is deactivated! If you login again your account will be reactivated!");
                        window.location.replace("logout.php");
                    }else{
                        alert("Deactivate failed!");
                    }
                }
            );           
        }
    });

});

function createSmall(id, cls, child){
    var newDiv = document.createElement("small");
    newDiv.setAttribute("id",id);
    newDiv.setAttribute("class",cls);
    newDiv.appendChild(document.createTextNode(child));
    return newDiv;
}
