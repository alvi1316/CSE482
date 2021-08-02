function validate(){
    var email = String(document.getElementById("Email").value);

    if(!(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email))){
        if(!document.body.contains(document.getElementById("emailHelp"))){
            var newDiv = createDiv("emailHelp", "form-text text-danger", "Enter a valid email!");
            var oldDiv = document.getElementById("Email");
            oldDiv.parentNode.insertBefore(newDiv, oldDiv.nextSibling);
        }        
        return false;
    }else{
        if(document.body.contains(document.getElementById("emailHelp"))){
            var div = document.getElementById("emailHelp");
            div.parentNode.removeChild(div);
        }
        return true;
    }
}

function createDiv(id, cls, child){
    var newDiv = document.createElement("div");
    newDiv.setAttribute("id",id);
    newDiv.setAttribute("class",cls);
    newDiv.appendChild(document.createTextNode(child));
    return newDiv;
}