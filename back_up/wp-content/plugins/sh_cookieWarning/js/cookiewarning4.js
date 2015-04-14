/////////////////////////////////////////////////////////////
//
// Author Scott Herbert (www.scott-herbert.com)
//		  Dimitri Kourkoulis (http://dimitros.net/en/home)
//
// Version History 

function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}

function doAccept() {
    setCookie("jsCookieCheck", null, 365);
    jQuery('.cookie-policy').hide();
}


function displayNotification(c_action) {

    // this sets the page background to semi-transparent black should work with all browsers
    var message = ''; 
    message = message + "In order for this site to work correctly, and for us to improve the site we need to store a small file (called a cookie) on your computer.<br /> By continuing to use the site you are assumed to agree with this <a href=\"#\" onclick=\"javascript: doAccept();\"><img src=\"wp-content/themes/h2only/img/close-cookie.png\" alt=\"Close\" /></a>";
    


    // and this closes everything off.

    jQuery("#wrapper").prepend('<div class="cookie-policy">'+ message+'</div>');
}

function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString() + "; path=/");
    document.cookie = c_name + "=" + c_value;    
}

function checkCookie(c_action) {

    var cookieName = "jsCookieCheck";
    var cookieNameNo = "jsNoCookieCheck";
    var cookieChk = getCookie(cookieName);
    var cookieChkNo = getCookie(cookieNameNo);
    if (cookieChk != null && cookieChk != "") {
        // the jsCookieCheck cookie exists so we can assume the person has read the notification
        // within the last year and has accepted the use of cookies

        setCookie(cookieName, cookieChk, 365); // set the cookie to expire in a year.
    }
    else if (cookieChkNo != null && cookieChkNo != "") {
        // the jsNoCookieCheck cookie exists so we can assume the person has read the notification
        // within the last year and has declined the use of cookies

        setCookie(cookieNameNo, cookieChkNo, 365); // set the cookie to expire in a year.
    }
    else {
        // No cookie exists, so display the lightbox effect notification.
        displayNotification(1);
        setCookie("jsCookieCheck", null, 365);
    }
}

// blockOrCarryOn - 1 = Carry on, store a do not store cookies cookie and carry on
//					0 = Block, redirect the user to a different website (google for example)
jQuery(document).ready(function ($) {
    var blockOrCarryOn = 1;
    checkCookie(blockOrCarryOn);
});    
