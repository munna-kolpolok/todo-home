@if(!empty($data['name']))<h2 style="text-align: center; margin-bottom: 0">{{$data['name']}}</h2><br>@endif

<div style="font-size: 18px; text-align: justify; padding: 10px 0">{{$data['message']}}</div><br><br>

@if(!empty($data['name']))
    <p>Best Regards, {{$data['name']}}</p>
@endif
