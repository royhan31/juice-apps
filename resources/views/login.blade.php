
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
      <script src="{{asset('assets/js/pages/login.js')}}"></script>
    </body>
</html>
