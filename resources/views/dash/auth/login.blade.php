@extends('dash.layouts.auth')
@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row" style="justify-content: center;">
            <div class="col-12 col-sm-8  col-md-6 col-lg-6 col-xl-4 ">
                <div class="login-brand">
                    <img src="{{ asset('assets/dash/img/logo.jpeg') }}" alt="logo" width="150" class="shadow-light ">
                </div>

                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h4>Login</h4>
                    </div> -->

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.do_login') }}" class="needs-validation" novalidate="">
                            <div class="msg_form" class="invalid-feedback">
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="email"> {{ trans('dash.email') }}</label>
                                </div>
                                <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus>
                                <div data-id="msg_email" class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password"> {{ trans('dash.password') }}</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" tabindex="2">
                                <div data-id="msg_password" class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                    <label class="custom-control-label" for="remember-me"> {{ trans('dash.remember_me') }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" onclick="send(this,event)">
                                    {{ trans('dash.login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="simple-footer">
                    Copyright &copy; <a target="_blank" href="https://www.linkedin.com/in/hanan-al-slaiman-05a425163/">Hanan Al-Slaiman</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection