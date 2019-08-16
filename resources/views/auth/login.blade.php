@extends('la.layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<style type="text/css">
.bg-img-1 {
    height: 100%;
    background-image: url(la-assets/img/login-logo.jpg);
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-color: #999;
}
.bg-black{background-color: #26A69A !important;}
.login-box-body {
    background: #00897B !important;
    color: #fff !important;
}
.btn-primary {
    background-color: #26A69A;
    border-color: #00897B;
}

.btn-primary:hover {
    background-color: #26A69A;
    border-color: #00897B;
}

.login-footer {
    position: fixed;
    left: 0px;
    bottom: 0px;
    height: 30px;
    width: 100%;
    background: #00897B;
    text-align: center;
    font-size: 14px;
    line-height: 2em;
    color: #fff;
}
.login-box {
    margin: 3% auto !important;
}
.login-logo {
    margin-bottom: 17px;
}
</style>
<body class="hold-transition bg-img-1">
    <div class="login-box">

        <div class="login-logo">
            <!--<a href="{{ url('/login') }}"><b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}</a>-->
            {{-- 
            <a href="{{ url('/login') }}"><img class="rab-logo" src="la-assets/img/rab-logo.jpg" alt="{{ LAConfigs::getByKey('sitename_part1') }} {{ LAConfigs::getByKey('sitename_part2') }}" title="{{ LAConfigs::getByKey('sitename_part1') }} {{ LAConfigs::getByKey('sitename_part2') }}"></a>
            --}}
        </div>
        

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-box-body">
    <h2 class="text-center bg-black">Sign In</h2>
    <form action="{{ url('/login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <!-- <input type="text" class="form-control" placeholder="User Name" name="user_name"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label class="no-margin">
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
            </div><!-- /.col -->
        </div>
    </form>

    @include('auth.partials.social_login')

    <!--<a href="{{ url('/password/reset') }}">I forgot my password</a><br>
    <a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    <div class="text-center login-footer" style="color: #fff">
        Powered by <a href="https://www.kolpolok.com/" target="_blank">Kolpolok Limited</a>
    </div>

    @include('la.layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
