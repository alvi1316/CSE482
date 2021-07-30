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