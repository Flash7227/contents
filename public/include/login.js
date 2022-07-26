

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



// const password = document.getElementById("password");
// const loginForm = document.getElementById("loginForm");
// const error = document.getElementById("error");
// loginForm.addEventListener('submit', (e) => {
//     let messages = [];

//     if (password.value.length <= 4) {
//         console.log('length not valid');
//         messages.push('доод тал нь 4 оронтой байх');
//     }
//     if (messages.length > 0) {
//         e.preventDefault();
//         error.innerText = messages.join(", ")

//     }
// })

