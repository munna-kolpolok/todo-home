<!-- Modal -->
<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
             </div>--}}
            <div class="modal-body">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="register-tab">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-justified">

                                        <li class="active">
                                            <a data-toggle="tab" href="#sign-in">
                                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                                Sign In
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#sign-up">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                Sign Up
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">


                                        <div id="sign-in" class="tab-pane active">
                                            <div class="sign-in-form">
                                                @if (count($errors) > 0)
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <form action="{{ url('/login') }}" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group">
                                                        <label for="sign_email">Email address</label>
                                                        <input autocomplete="off" type="email" class="form-control" id="sign_email" placeholder="Enter Email" name="email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="sign_password">Password</label>
                                                        <input autocomplete="off" type="password" class="form-control" id="sign_password" placeholder="Enter Password" name="password">
                                                    </div>
                                                    <input type="submit" value="Sign In">
                                                </form>
                                            </div>
                                        </div>
                                        <div id="sign-up" class="tab-pane fade">
                                            <div class="register-form">
                                                @if(session()->has('message'))
                                                    <div class="alert alert-success alert-dismissable">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                      <strong>{{ session()->get('message') }}</strong>
                                                    </div>
                                                @endif

                                                @if (count($errors) > 0)
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <form action="{{ url('/user_register') }}" method="post" id="sign-up-form">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required="1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email address</label>
                                                        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required="1" unique="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control"
                                                               id="password" placeholder="Password" name="password" required="1">
                                                    </div>
                                                    <input type="submit" value="Sign Up">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Donate Modal-->