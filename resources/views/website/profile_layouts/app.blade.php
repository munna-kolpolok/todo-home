@extends('website.layouts.app')


@section('main-content')
    <section class="shop-main-content section-padding" id="dashboard_padding">
        <!--Top welcome message s-->
        {{-- 
        @include('website.profile_layouts.header_message')
        --}}
        <!--Top welcome message-->

        <!-- Main Menu area start-->
        <div class="main-menu-area">
            <div class="container">
                <div id="user-profile">
                    <div class="row">
                        <!--common Menu-->
                        @include('website.profile_layouts.common_menu')
                        <!--common Menu-->
                        @yield('profile-content')
                    </div>
                </div>
            </div>
        </div>



    </section>

@endsection

@push('style')

@endpush

@push('scripts')
<script type="text/javascript">
    localStorage.setItem('kolpo_bidya_ahar_m', '<?php echo Auth::id();?>'); 
</script>
@endpush


