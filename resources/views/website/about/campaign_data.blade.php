@foreach($campaigns as $campaign)
    <?php
        if (request()->cookie('locale') == 'bn') {
            $title = $campaign->bn_title or null;
            $date = \App\Helpers\CommonHelper::en2bnNumber(\App\Helpers\CommonHelper::humanRedableDate($campaign->date));
            $total_image = \App\Helpers\CommonHelper::en2bnNumber($campaign->images_count) or null;
        } else {
            $title = $campaign->title or null;
            $date = \App\Helpers\CommonHelper::humanRedableDate($campaign->date);
            $total_image = $campaign->images_count or null;
        }
    ?>
    <div class="col col-sm-4">
        <div class="box" style="margin-bottom: 15px">
            <div class="img-holder-donation">
                <div class="img-holder">
                    <a style="display: block" href="{{url('/campaign/details/'.$campaign->id)}}">
                        <img style="width: 100%; height: 250px" src="{{asset($campaign->cover_image)}}" alt class="img img-responsive">
                    </a>
                </div>
                <div class="donation-box">
                    <div>
                        <p class="dollar">{{ $total_image }}</p>
                        <p>@lang('messages.photos')</p>
                    </div>
                </div>
            </div>
            <div class="details">
                <h3><a href="{{url('/campaign/details/'.$campaign->id)}}">{{ $title }}</a></h3>
                <p><i class="fa fa-clock-o"> {{ $date }}</i> </p>
            </div>
        </div>
    </div>
@endforeach