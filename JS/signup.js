function validate(){
    var username = document.getElementById("Username").value;
    var email = document.getElementById("Email").value;
    var password = document.getElementById("Password").value;
    var confirmPassword = document.getElementById("ConfirmPassword").value;
    var uservalid = false;
    var emailvalid = false;
    var passvalid = false;
    var repassvalid = false;

    if(!(/^[a-z\d]{6,}$/gi.test(username))){
        //<div id="usernameHelp" class="form-text text-danger" >Username has to be atleast 6 characters long!</div>
        if(!document.body.contains(document.getElementById("usernameHelp"))){
            var newDiv = createDiv("usernameHelp", "form-text text-danger", "Username has to be atleast 6 characters long!");
            var oldDiv = document.getElementById("Username");
            oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
        }        
    }else{
        uservalid = true;
        if(document.body.contains(document.getElementById("usernameHelp"))){
            var div = document.getElementById("usernameHelp");
            div.parentNode.removeChild(div);
        }
    }

    if(!(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email))){
        //<div id="emailHelp" class="form-text text-danger">Enter a valid email!</div>
        if(!document.body.contains(document.getElementById("emailHelp"))){
            var newDiv = createDiv("emailHelp", "form-text text-danger", "Enter a valid email!");
            var oldDiv = document.getElementById("Email");
            oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
        }        
    }else{
        emailvalid = true;
        if(document.body.contains(document.getElementById("emailHelp"))){
            var div = document.getElementById("emailHelp");
            div.parentNode.removeChild(div);
        }
    }

    if(!(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/.test(password))){
        /*<div id="passwordHelp" class="form-text text-danger">
        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
        </div>*/
        if(!document.body.contains(document.getElementById("passwordHelp"))){
            var newDiv = createDiv("passwordHelp", "form-text text-danger", "Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.");
            var oldDiv = document.getElementById("Password");
            oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
        }        
    }else{
        passvalid = true;
        if(document.body.contains(document.getElementById("passwordHelp"))){
            var div = document.getElementById("passwordHelp");
            div.parentNode.removeChild(div);
        }
    }

    if(!((password+'').localeCompare(confirmPassword+'')==0)){
        /*<div id="confirmPasswordHelp" class="form-text text-danger">
        Password didn't match!
        </div>*/
        if(!document.body.contains(document.getElementById("confirmPasswordHelp"))){
            var newDiv = createDiv("confirmPasswordHelp", "form-text text-danger", "Password didn't match!");
            var oldDiv = document.getElementById("ConfirmPassword");
            oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
        }        
    }else{
        repassvalid = true;
        if(document.body.contains(document.getElementById("confirmPasswordHelp"))){
            var div = document.getElementById("confirmPasswordHelp");
            div.parentNode.removeChild(div);
        }
    }

    return (uservalid && emailvalid && passvalid && repassvalid);
}

function createDiv(id, cls, child){
    var newDiv = document.createElement("div");
    newDiv.setAttribute("id",id);
    newDiv.setAttribute("class",cls);
    newDiv.appendChild(document.createTextNode(child));
    return newDiv;
}