@lang('messages.Dear Subscriber'),<br><br>

@lang('messages.subscriber_body')<br><br>

<h1>
	<a href="{{ url('/subscriber_e_v/'.$subscriber->id.'/'.$subscriber->verify_token) }}">@lang('messages.Click here to verify your email')</a>
</h1>
<br><br>

@lang('messages.Best Regards'),<br>
@lang('messages.organization_name')