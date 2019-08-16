<!-- Header -->
<header class="header1">
    <!-- Header desktop -->
    <div class="container-menu-header">

        <div class="topbar">
            <?php $site_setting = App\Models\Site_Setting::first();?>
            <div class="topbar-social">
                @if(!empty($site_setting->facebook_link))
                    <a href="{{$site_setting->facebook_link}}" class="topbar-social-item fa fa-facebook"></a>
                @endif
                @if(!empty($site_setting->twitter_link))
                    <a href="{{$site_setting->twitter_link}}" class="topbar-social-item fa fa-twitter"></a>
                @endif
                @if(!empty($site_setting->google_link))
                    <a href="{{$site_setting->google_link}}" class="topbar-social-item fa fa-google"></a>
                @endif
                @if(!empty($site_setting->linkedin_link))
                    <a href="{{$site_setting->linkedin_link}}" class="topbar-social-item fa fa-linkedin"></a>
                @endif
                @if(!empty($site_setting->youtube_link))
                    <a href="{{$site_setting->youtube_link}}" class="topbar-social-item fa fa-youtube"></a>
                @endif
                @if(!empty($site_setting->instagram_link))
                    <a href="{{$site_setting->instagram_link}}" class="topbar-social-item fa fa-instagram"></a>
                @endif
            </div>
            <span class="topbar-child1">
				{{ $site_setting->top_header_notice or null }}
			</span>
            {{--
            <div class="topbar-child2">
                <span class="topbar-email">
                    {{ $site_setting->top_header_email or null }}
                </span>

                <div class="topbar-language rs1-select2">
                    <select class="selection-1" name="time">
                        <option>TK</option>
                        <!-- <option>EUR</option> -->
                    </select>
                </div>
            </div>
            --}}
        </div>

        <div class="wrap_header">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset($site_setting->logo_image) }}" alt="IMG-LOGO">
            </a>

            <!-- Menu -->
            <div class="wrap_menu">
                <nav class="menu">
                    <ul class="main_menu">
                        <li>
                            <a href="{{ url('/home') }}">Home</a>
                        </li>

                        <li>
                            <a href="{{ url('products') }}">Shop</a>
                            <div class="sub_menu">
                                <div class="container">
                                    <div class="row">
                                        <?php $groups_menus = App\Models\Group::where('is_menu', 'Yes')
                                            ->get(['id', 'group_name']);
                                        ?>
                                        @foreach($groups_menus as $group)
                                            <div class="col-md-3">
                                                <div class="item-wrapper">
                                                <!--  <h6>{{ $group->group_name or null }}</h6> -->
                                                    <a href="{{ url('product/'.$group->id) }}">
                                                        <h6>{{ $group->group_name or null }}</h6></a>
                                                    <ul>
                                                        <?php
                                                        $categories = App\Models\Category::where('group_id', $group->id)->get();
                                                        ?>
                                                        @foreach($categories as $category)
                                                            <li>
                                                                <a href="{{ url('products/'.$group->id.'/'.$category->id) }}">{{ $category->category_name or null }}</a>

                                                                <?php
                                                                $sub_categories = App\Models\Sub_Category::where('group_id', $group->id)
                                                                    ->where('category_id', $category->id)
                                                                    ->get();
                                                                ?>
                                                                @if(count($sub_categories)>0)
                                                                    <ul class="sub_menu_inner">
                                                                        @foreach($sub_categories as $sub_category)
                                                                            <li>
                                                                                <a href="{{ url('products/'.$group->id.'/'.$category->id.'/'.$sub_category->id) }}">{{ $sub_category->sub_category_name or null }}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </li>

                        {{--
                        <li class="sale-noti">
                          <a href="product.html">Sale</a>
                        </li>

                        <li>
                          <a href="cart.html">Features</a>
                        </li>

                        <li>
                          <a href="blog.html">Blog</a>
                        </li>
                        --}}

                        <li>
                            <a href="{{ url('about') }}">About</a>
                        </li>

                        <li>
                            <a href="{{ url('contact') }}">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Header Icon -->
            <div class="header-icons">
                {{--
                <!-- <a href="#" class="header-wrapicon1 dis-block">
                    <img src="{{ asset('site-assets/images/icons/icon-header-01.png') }}" class="header-icon1" alt="ICON">
                </a> -->
                --}}
                <span class="linedivide1"></span>

                <div class="header-wrapicon2">
                    <img src="{{ asset('site-assets/images/icons/icon-header-02.png') }}"
                         class="header-icon1 js-show-header-dropdown" alt="ICON">
                    <?php
                    $product_ids = Session::get('product_ids');
                    //print_r($product_ids);die();
                    $quantity = Session::get('quantity');
                    $size_id = Session::get('size_id');
                    $color_id = Session::get('color_id');
                    ?>
                    @if(isset($product_ids))
                        <span class="header-icons-noti">{{ count($product_ids) }}</span>
                    @else
                        <span class="header-icons-noti">0</span>
                    @endif
                    <form method="POST" action="{{ url('cart') }}" id="cart_form">
                    {!! Form::token() !!}
                    <!-- Header cart noti -->
                        <div class="header-cart header-dropdown" id="header-cart">
                            <ul class="header-cart-wrapitem">
                                <?php $cart_grand_total_price = 0;
                                ?>
                                @if(isset($product_ids))
                                    @foreach($product_ids as $key=>$product_id)
                                        <?php $product = App\Models\Product::find($product_id);?>
                                        <li class="header-cart-item">
                                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity[]" value="{{ $quantity[$key] }}">
                                            <input type="hidden" name="size_id[]" value="{{ $size_id[$key] }}">
                                            <input type="hidden" name="color_id[]" value="{{ $color_id[$key] }}">

                                            <div class="col-md-6">
                                                <span class="header-cart-item-name">{{ $product->product_name or null }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <?php $cart_grand_total_price += $product->price;?>
                                                <span class="header-cart-item-info">{{ $quantity[$key] }}
                                                    x {{ $product->currency or null }} {{ $product->price or null }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>

                            <div class="header-cart-total">
                                Total: @lang('messages.TK') <span
                                        class="total_price_cart">{{ $cart_grand_total_price }}</span>
                            </div>

                            <div class="header-cart-buttons">
                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4"
                                       onclick="cart_form()">
                                        View Cart
                                    </a>
                                </div>

                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4"
                                       onclick="cart_form()">
                                        Check Out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap_header_mobile">
        <!-- Logo moblie -->
        <a href="{{ url('/') }}" class="logo-mobile">
            <img src="{{ asset($site_setting->logo_image) }}" alt="IMG-LOGO">
        </a>

        <!-- Button show menu -->
        <div class="btn-show-menu">
            <!-- Header Icon mobile -->
            <div class="header-icons-mobile">
                {{--
                <a href="#" class="header-wrapicon1 dis-block">
                    <img src="{{ asset('site-assets/images/icons/icon-header-01.png') }}" class="header-icon1" alt="ICON">
                </a>
                --}}
                <span class="linedivide2"></span>

                <div class="header-wrapicon2">
                    <img src="{{ asset('site-assets/images/icons/icon-header-02.png') }}"
                         class="header-icon1 js-show-header-dropdown" alt="ICON">
                    @if(isset($product_ids))
                        <span class="header-icons-noti">{{ count($product_ids) }}</span>
                    @else
                        <span class="header-icons-noti">0</span>
                    @endif

                    <form method="POST" action="{{ url('cart') }}" id="cart_form">
                    {!! Form::token() !!}
                    <!-- Header cart noti -->
                        <div class="header-cart header-dropdown" id="header-cart-mobile">
                            <ul class="header-cart-wrapitem">
                                <?php $cart_grand_total_price = 0;?>
                                @if(isset($product_ids))
                                    @foreach($product_ids as $key=>$product_id)
                                        <?php $product = App\Models\Product::find($product_id);?>
                                        <li class="header-cart-item">
                                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity[]" value="{{ $quantity[$key] }}">
                                            <input type="hidden" name="size_id[]" value="{{ $size_id[$key] }}">
                                            <input type="hidden" name="color_id[]" value="{{ $color_id[$key] }}">

                                            <div class="col-md-6">
                                                <span class="header-cart-item-name">{{ $product->product_name or null }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <?php $cart_grand_total_price += $product->price;?>
                                                <span class="header-cart-item-info">{{ $quantity[$key] }}
                                                    x {{ $product->currency or null }} {{ $product->price or null }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                            <div class="header-cart-total">
                                Total: @lang('messages.TK') <span
                                        class="total_price_cart">{{ $cart_grand_total_price }}</span>
                            </div>

                            <div class="header-cart-buttons">
                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4"
                                       onclick="cart_form()">
                                        View Cart
                                    </a>
                                </div>

                                <div class="header-cart-wrapbtn">
                                    <!-- Button -->
                                    <a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4"
                                       onclick="cart_form()">
                                        Check Out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="wrap-side-menu">
        <nav class="side-menu">
            <ul class="main-menu">
                <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
					<span class="topbar-child1">
						{{ $site_setting->top_header_notice or null }}
					</span>
                </li>


            <!-- <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
					<div class="topbar-child2-mobile">
						<span class="topbar-email">
							fashe@example.com
						</span>

						<div class="topbar-language rs1-select2">
							<select class="selection-1" name="time">
								<option>USD</option>
								<option>EUR</option>
							</select>
						</div>
					</div>
				</li> -->

                <!-- <li class="item-topbar-mobile p-l-10">
                    <div class="topbar-social-mobile">
                        <a href="#" class="topbar-social-item fa fa-facebook"></a>
                        <a href="#" class="topbar-social-item fa fa-instagram"></a>
                        <a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
                        <a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
                        <a href="#" class="topbar-social-item fa fa-youtube-play"></a>
                    </div>
                </li> -->

                <li class="item-menu-mobile">
                    <a href="{{ url('/home') }}">Home</a>
                </li>

                <li class="item-menu-mobile">
                    <a href="{{ url('products') }}">Shop</a>
                    <ul class="sub-menu">
                        @foreach($groups_menus as $group)
                            <li><a href="{{ url('product/'.$group->id) }}">{{ $group->group_name or null }}</a></li>
                        @endforeach
                    </ul>
                    <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
                </li>


                <!-- <li class="item-menu-mobile">
                    <a href="product.html">Sale</a>
                </li>

                <li class="item-menu-mobile">
                    <a href="cart.html">Features</a>
                </li>

                <li class="item-menu-mobile">
                    <a href="blog.html">Blog</a>
                </li> -->

                <li class="item-menu-mobile">
                    <a href="{{ url('about') }}">About</a>
                </li>

                <li class="item-menu-mobile">
                    <a href="{{ url('contact') }}">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
</header>