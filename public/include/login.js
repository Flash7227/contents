

const signup = document.querySelector('.t-signup'),
    signin = document.querySelector('.t-signin'),
    addclass = document.querySelector('.site');
signup.addEventListener('click', function () {
    console.log('to login clicked', tag);
    document.getElementById("emailField1").value = '';
    var tag = document.getElementsByTagName("strong");

    addclass.className = 'site signup-show';
});
signin.addEventListener('click', function () {
    document.getElementById("emailField2").value = '';
    var tag = document.getElementsByTagName("strong");

    addclass.className = 'site signin-show';
    console.log('to login clicked', tag);
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

