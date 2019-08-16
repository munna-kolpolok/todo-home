@extends('website.layouts.app')


@section('main-content')
<section class="shop-main-content section-padding">
    <div class="container">
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

    	<!-- sign up start-->
    	<div class="col-md-6">
    		<h1>Sign Up</h1>
            <form action="{{ url('/user_register') }}" method="post" id="sign-up-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required="1" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required="1" unique="true" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control"
                           id="password" placeholder="Password" name="password" required="1">
                </div>
                <!-- <input type="submit" value="Sign Up"> -->
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
    	</div>
    	<!-- sign up end-->

    	<!-- sign in start-->
    	<div class="col-md-6">
    		<h1>Sign In</h1>
            <form action="{{ url('/login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="sign_email">Email address</label>
                    <input autocomplete="off" type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required="1">
                </div>
                <div class="form-group">
                    <label for="sign_password">Password</label>
                    <input autocomplete="off" type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required="1">
                </div>
                <!-- <input type="submit" value="Sign In"> -->
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
    	</div>
    	<!-- sign in end-->

    </div>
</section>      
    
@endsection


