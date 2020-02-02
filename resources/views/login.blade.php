
<!DOCTYPE html>
<html lang="en">
    @include('templates.partials._head')
    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <a href="index.html">
                                        <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                                    </a>
                                </div>
                                <form id="form-login" class="{{Session::get('error')}}" action="{{route('web-login')}}" method="post">
                                  @csrf
                                  <div class="form-group mb-3 mt-2">
                                      <label for="emailaddress">Username</label>
                                      <input class="form-control" type="text" name="username" id="username" required="" placeholder="Masukan username" autofocus>
                                      <div class='validate'></div>
                                  </div>

                                  <div class="form-group mb-3">
                                      <label for="password">Password</label>
                                      <input class="form-control" type="password" required="" name="password" id="password" placeholder="Masukan password">
                                      <div class='validate'></div>
                                  </div>

                                </form>
                                <div class="mb-0 text-center">
                                  <button class="btn-login btn btn-primary btn-block" > Log In </button>
                                </div>

                                <div class="progress-login">

                                </div>

                            </div> <!-- end card-body -->
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            2020 &copy; Powered by <a href="">PLUGIN</a>
        </footer>

      @include('templates.partials._script')
      <script>
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
      </script>
    </body>
</html>
