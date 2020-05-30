function setCookie(cookieValue) {
    var expires = "expires=" + new Date(Date.now() + 86400e3);
    // var expires = "expires=" + new Date(Date.now() - 86400e3);
    document.cookie = "visitorId" + "=" + cookieValue + ";" + expires + ";path=/";
}

function getCookie(cookieName) {
    var name = cookieName + "=";
    var cookieArray = document.cookie.split(';');
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
            return(cookie.substring(name.length, cookie.length));
        }
    }
    return "";
}

function checkCookie() {
    var visitorId = getCookie("visitorId");
    if (visitorId != "") {
        setCookie(visitorId);
    } else {
        setCookie(Date.now().toString(36) + Math.random().toString(36).substr(2, 5));
        visitorId = getCookie("visitorId");
    }
}

checkCookie();