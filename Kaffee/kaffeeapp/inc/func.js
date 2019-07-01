
//onclick
function buttonclick(){
//Var definition
var user = "Element nicht gefunden";
var password = "Element nicht gefunden";
var user = document.getElementById("use").value;
var password = document.getElementById("pwd").value;
//alert(user);
//alert(password);
createCookie("BenutzerNamenCookie", user, 5);
createCookie("BenutzerPasswordCookie", password, 5);
}

// Create cookie
function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = "; expires="+date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name+"="+value+expires+"; path=/";
}

// Read cookie
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length,c.length);
        }
    }
    return null;
}

// Erase cookie
function eraseCookie(name) {
    createCookie(name,"",-1);
}
function load(){
	alert('body is loaded');
	document.getElementById("anfang").submit();
}



// ****************************************************//
//cookie löschen
//eraseCookie("BenutzerNamenCookie");
//eraseCookie("BenutzerPasswordCookie");
