@foreach($campaignImages as $image)
    <li class="col-xs-6 col-sm-4 col-md-3" data-src="{{ asset($image->big_image) }}">
        <a href="">
            <img class="img-responsive" src="{{ asset($image->image) }}">
        </a>
    </li>
@endforeach
