const signup = document.querySelector('.t-signup'),
    signin = document.querySelector('.t-signin'),
    addclass = document.querySelector('.site');
signup.addEventListener('click', function () {
    addclass.className = 'site signup-show';
});
signin.addEventListener('click', function () {
    addclass.className = 'site signin-show'
});

function myFunction() {
    var x = document.querySelector(".passwordshow");
    var y = document.querySelector(".passwordshow2");
    var z = document.querySelector(".passwordshow3");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }

    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }
    if (z.type === "password") {
        z.type = "text";
    } else {
        z.type = "password";
    }
}
