! function(p) {
    "use strict";
    var t = function() {};
    t.prototype.send = function(t, i, o, e, n, a, s, r) {
        a || (a = 3e3), s || (s = 1);
        var c = {
            heading: t,
            text: i,
            position: o,
            loaderBg: e,
            icon: n,
            hideAfter: a,
            stack: s
        };
        r && (c.showHideTransition = r), console.log(c), p.toast().reset("all"), p.toast(c)
    }, p.NotificationApp = new t, p.NotificationApp.Constructor = t
}(window.jQuery),
function(i) {
"use strict";
const btnLogin = document.querySelector('.btn-login');
const progressLogin = document.querySelector('.progress-login');
const username = document.getElementById('username');
const password = document.getElementById('password');
const validate = document.querySelectorAll('.validate');
const form = document.getElementById('form-login');
const loginErr = document.querySelector('.login-error');
if(loginErr){
  i.NotificationApp.send("Login Gagal!", "Periksa username dan password anda", "top-center", "#bf441d", "error")
}

btnLogin.addEventListener('click', function(event){
  var allValidate = Array.from(validate);
  var textUsername = `<p style="color: red">Masukan username anda</p>`
  var textPassword = `<p style="color: red">Masukan password anda</p>`

  if (username.value == '' && password.value == '') {
    username.style.borderColor = "red";
    allValidate[0].innerHTML = textUsername
    password.style.borderColor = "red";
    allValidate[1].innerHTML = textPassword
  }else if (username.value == '') {
    username.style.borderColor = "red";
    allValidate[0].innerHTML = textUsername
  }else if (password.value == '') {
    password.style.borderColor = "red";
    allValidate[1].innerHTML = textUsername
  }else {
    var identity = setInterval(scene, 20);
    let prog = ``;
    var width = 0;
    function scene() {
      if (width >= 100) {
        clearInterval(identity);
        prog = ``
        progressLogin.innerHTML = prog
        form.submit();
      } else {
        width++;
        prog = `<div class="progress mt-2">
            <div class="progress-bar bg-success" role="progressbar" style="width: ${width}%" aria-valuenow="${width}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>`
          progressLogin.innerHTML = prog
      }
    }
  }
});
}(window.jQuery);
