//Created by Ijat @ Reizn.com
//Facebook Like-Or-Lock Javascript File
//Version 0.13

function FBConnect() {
    FB.login(function (e) {}, {
        scope: "user_likes"
    })
}
window.fbAsyncInit = function () {
    FB.init({
        appId: theappid,
        channelUrl: thechannelurl,
        status: true,
        cookie: true,
        xfbml: true
    });
    FB.getLoginStatus(function (e) {
        if (e.status === "connected") {
            var t = e.authResponse.userID;
            var n = e.authResponse.accessToken;
            FB.api("/me/likes/" + thepageid, function (e) {
                console.log(JSON.stringify(e));
                if (e.data[0]) {
                	document.getElementById("fbx").style.display = "none"
                	document.getElementById("flo").style.display = "inline"
                } else {
                	document.getElementById("fb-btn").style.display = "inline"
                }
            })
        } else {
        	document.getElementById("fbCon-Btn").style.display = "inline"
        }
    });
    FB.Event.subscribe("edge.create", function (e) {
        location.reload()
    });
    FB.Event.subscribe("edge.remove", function (e) {
        location.reload()
    });
    FB.Event.subscribe("auth.login", function (e) {
        if (e.status === "connected") {
        	document.getElementById("fbCon-Btn").style.display = "none"
            location.reload()
        }
    });
    FB.Event.subscribe("auth.authResponseChange", function (e) {
        if (e.status === "connected") {}
    })
};
(function (e) {
    var t, n = "facebook-jssdk",
        r = e.getElementsByTagName("script")[0];
    if (e.getElementById(n)) {
        return
    }
    t = e.createElement("script");
    t.id = n;
    t.async = true;
    t.src = "//connect.facebook.net/en_US/all.js";
    r.parentNode.insertBefore(t, r)
})(document)