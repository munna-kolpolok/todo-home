@extends('website.layouts.app')


@section('main-content')
    <section class="shop-main-content section-padding" id="dashboard_padding">
        <!-- Breadcomb area Start-->
        <div class="breadcomb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-list">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="breadcomb-wp">
                                        <div class="breadcomb-icon">
                                            <i class="notika-icon notika-app"></i>
                                        </div>
                                        <div class="breadcomb-ctn">
                                            <h2>Hello, {{\Illuminate\Support\Facades\Auth::user()->name}}</h2>
                                            <p>Welcome to Bidiyanondo <span class="bread-ntd">Admin panel</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                    <div class="breadcomb-report">
                                        {{--
                                                                                    <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn"><i class="notika-icon notika-sent"></i></button>
                                        --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcomb area End-->
        <!-- Main Menu area start-->
        <div class="main-menu-area mg-tb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs nav-justified notika-menu-wrap menu-it-icon-pro">
                            <li><a data-toggle="tab" href="#Home"><i class="notika-icon notika-house"></i> Home</a>
                            </li>
                            <li class="active"><a data-toggle="tab" href="#donation"><i
                                            class="notika-icon notika-app"></i> Donation Clarification</a>
                            </li>
                            <li><a data-toggle="tab" href="#scholarship"><i class="fa fa-graduation-cap"
                                                                            aria-hidden="true"></i>
                                    Scholarship</a>
                            </li>
                        </ul>
                        <div class="tab-content custom-menu-content">
                            <div id="Home" class="tab-pane in notika-tab-menu-bg animated flipInX">
                                <div class="content-box-md">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                hello Home
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="donation" class="tab-pane active notika-tab-menu-bg animated flipInX">
                                <div class="content-box-md">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="notika-icon notika-dollar"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control" placeholder="Dollar">
                                                    </div>
                                                </div>
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="notika-icon notika-mail"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <div class="chosen-select-act fm-cmp-mg">
                                                            <select class="chosen" data-placeholder="Choose a Country...">
                                                                <option value="United States">United States</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="Afghanistan">Afghanistan</option>
                                                                <option value="Aland Islands">Aland Islands</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ic-cmp-int">
                                                    <div class="form-ic-cmp">
                                                        <i class="notika-icon notika-phone"></i>
                                                    </div>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"
                                                               placeholder="Contact Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">RIght</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="scholarship" class="tab-pane notika-tab-menu-bg animated flipInX">
                                <div class="content-box-md">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                hello scholarship
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
        <!-- Main Menu area End-->

    </section>

@endsection

@push('style')
<!-- Notika icon CSS============================================ -->
<link rel="stylesheet" href="{{asset('site-assets/css/notika-custom-icon.css')}}">

<!-- chosen CSS============================================ -->
<link rel="stylesheet" href="{{asset('site-assets/css/chosen.css')}}">
@endpush


