<header id="header" class="header-style-two">
    <nav class="navigation navbar navbar-default navbar-fixed-top" id="main-navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="open-btn">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand wow fadeInLeftSlow" href="{{url('/')}}"><img src="{{asset($setting->logo)}}" alt=""></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
                <button class="close-navbar"><i class="fa fa-close"></i></button>
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/')}}">@lang('messages.Home')</a></li>

                    <li class="sub-menu">
                        <a href="#" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donations')</a>
                        <ul>
                            <li><a href="#" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate Now')</a></li>
                            <li><a href="{{route('donation')}}">@lang('messages.Donation Clarification')</a></li>
                            <li><a href="{{route('donation.info')}}">@lang('messages.Bank Information')</a></li>

                        </ul>
                    </li>


                    <?php $projects=App\Models\Project::where('is_show',1)
                            ->where('is_menu',1)
                            ->get(['id','name','bn_name','parent','type']);
                            ?>
                    <li class="sub-menu">
                        <a href="{{ url('projects')}}">@lang('messages.Projects')</a>
                        <ul>
                            @foreach($projects as $project)
                                @if($project->type==1)
                                    @if(empty($project->parent))
                                        <?php $childs=App\Models\Project::where('type',1)
                                        ->where('is_show',1)
                                        ->where('is_menu',1)
                                        ->where('parent',$project->id)
                                        ->get(['id','name','bn_name','parent']);
                                        ?>
                                        @if(count($childs)==0)
                                            <li><a href="{{ url('projects/'.str_replace(' ', '_', $project->name)) }}">{{ $project->bn_name or null}}</a></li>
                                        @else
                                            <li class="sub-sub-menu">
                                                <a href="{{ url('projects/'.$project->id) }}">{{ $project->bn_name or null}}</a>
                                                <ul>
                                                    @foreach($childs as $child)
                                                        <li><a href="{{url('projects/'.$child->id)}}">{{ $child->bn_name or null}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <li><a href="{{route('scholarship')}}">@lang('messages.Sponsor')</a></li>

                    <li class="sub-menu">
                        <a href="{{ url('gallery') }}">@lang('messages.Media')</a>
                        <ul>
                            <li><a href="{{ url('gallery') }}">@lang('messages.Gallery')</a></li>
                            <li><a href="{{ url('video') }}">@lang('messages.Video')</a></li>
                            <li><a href="{{ url('press') }}">@lang('messages.Press')</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="{{ url('about') }}">@lang('messages.About')</a>
                        <ul>
                            <li><a href="{{ url('about') }}">@lang('messages.About Us')</a></li>
                            <li><a href="{{ url('contact') }}">@lang('messages.Contact us')</a></li>
                            <li><a href="{{ url('branch') }}">@lang('messages.Our') @lang('messages.Branches Information')</a></li>
                            <li><a href="{{ url('faq') }}">@lang('messages.FAQ')</a></li>
                        </ul>
                    </li>

                    @if(isset(Auth::user()->email))
                        <li class="sub-menu">
                            @if(Auth::user()->user_level>'1')
                            <a href="{{ url('/admin') }}">@lang('messages.Admin')</a>
                            <ul>
                                <li><a href="{{ url('/admin') }}">@lang('messages.Admin Panel')</a></li>
                                

                                <li><a href="{{ url('/reset-password') }}">@lang('messages.Reset Password')</a></li>
                                <li><a href="{{ url('/forget-password') }}">@lang('messages.Forgot Password')</a></li>
                                <li><a href="{{ url('/logout') }}">@lang('messages.Sign Out')</a></li>
                            </ul>
                            @else
                            <a href="{{ url('/donors') }}">@lang('messages.Profile')</a>
                            <ul>
                                <li><a href="{{ url('/donors') }}">@lang('messages.Hello'), {{ str_limit(Auth::user()->name, $limit = 15, $end = '...') }}</a></li>
                                <li><a href="{{ url('/reset-password') }}">@lang('messages.Reset Password')</a></li>
                                <li><a href="{{ url('/forget-password') }}">@lang('messages.Forgot Password')</a></li>
                                <li><a href="{{ url('/logout') }}">@lang('messages.Sign Out')</a></li>
                            </ul>
                            @endif
                        </li>
                    @else
                        <li class="sub-menu">
                            <a  href="{{ url('/signin') }}">@lang('messages.Sign In')</a>
                            <ul>
                                <li><a href="{{ url('/signup') }}">@lang('messages.Sign Up')</a></li>
                                <li><a  href="{{ url('/signin') }}">@lang('messages.Sign In')</a></li>
                                <li><a href="{{ url('/forget-password') }}">@lang('messages.Forgot Password')</a></li>
                            </ul>
                        </li>
                    @endif


                    @if(request()->cookie('locale')=='bn')
                        <li class="pull-right"><a href="{{ url('/language/en') }}">English</a></li>
                    @else
                        <li class="pull-right"><a  href="{{ url('/language/bn') }}">বাংলা</a></li>
                    @endif
                    

                    <!-- <li class="sub-menu">
                        <a  href="{{ url('/signin') }}">@lang('messages.Language')</a>
                        <ul>
                            <li><a href="{{ url('/language/en') }}">@lang('messages.English')</a></li>
                            <li><a  href="{{ url('/language/bn') }}">@lang('messages.Bangla')</a></li>
                        </ul>
                    </li> -->

                </ul>
            </div><!-- end of nav-collapse -->

        </div><!-- end of container -->
    </nav>
</header>