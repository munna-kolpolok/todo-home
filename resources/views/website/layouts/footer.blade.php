<footer>
	<div class="container">
		<div class="row upper-footer">
			<div class="col col-md-5 col-xs-6">
				<div class="widget about-widget">
					<div class="logo">
						<img src="{{asset($setting->logo)}}" alt class="img img-responsive">
					</div>

					<div class="details">
						<a href="{{url('about')}}">
							<p class="text-justify">{{str_limit($setting->about_short_brief,220)}}</p>
							<div class="about read-more-button">
								@lang('messages.Read More') &rarr;
							</div>
						</a>
						<!-- <p class="copyright">
							2016 &copy; All rights reserved by <span><a href="">charity++</a></span>
						</p> -->
						<ul class="social-links">
							<li><a href="{{asset($setting->facebook_social_link)}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="{{asset($setting->twitter_social_link )}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="{{asset($setting->goole_plus_social_link)}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="{{asset($setting->linkdin_social_link)}}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="{{asset($setting->instagram_social_link )}}" target="_blank"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col col-md-2 col-xs-6">
				<div class="widget">
					<h3>@lang('messages.Visit')</h3>
					<ul>
						<li><a href="{{ url('projects')}}">@lang('messages.Projects')</a></li>
						<li><a href="{{url('sponsor')}}">@lang('messages.Sponsors')</a></li>
						<li><a href="{{url('gallery')}}">@lang('messages.Gallery')</a></li>
						<li><a href="{{ url('/signin') }}">@lang('messages.Sign In') </a></li>
						<!-- <li><a href="#">Career</a></li> -->
					</ul>
				</div>
			</div>

			<div class="col col-md-2 col-xs-6">
				<div class="widget">
					<h3>@lang('messages.Help')</h3>
					<ul>
						<li><a href="{{ url('faq') }}">@lang('messages.FAQ')</a></li>
						<li><a href="{{ url('contact') }}">@lang('messages.Contact us')</a></li>
						<li><a href="{{ url('about') }}">@lang('messages.About Us')</a></li>
						<li><a href="{{ url('volunteer/registration') }}">@lang('messages.Volunteers')</a></li>
						<!-- <li><a href="#">Regulations</a></li> -->
					</ul>
				</div>
			</div>

			<div class="col col-md-3 col-xs-6">
				<div class="widget contact-widget">
					<h3>@lang('messages.CONTACT')</h3>
					<div>
						<p ><strong><i class="fa fa-map-marker fa-2" aria-hidden="true"></i> :</strong> {{ $setting->contact_address or null}}</p>
						<p ><table>
							<tr style="color:#A9B0BE ;">
								<td style=" min-width:85px;"><strong><i class="fa fa-phone" style="padding-right: 5px;"></i> :</strong> {{ $setting->contact_no or null}}</td>
							</tr>
							{{--<tr style="color:#A9B0BE;">
								<td style=" min-width:85px;"><strong><i class="fa fa-envelope-o" style="padding-right: 5px;"></i>@lang('messages.Email')  :</strong> </td>
								<td style="padding-left: 10px;"> {{ $setting->contact_email or null}}</td>
							</tr>--}}
						</table>
						</p>

					</div>
				</div>
			</div>
		</div> <!-- end upper-footer -->
	</div> <!-- end container -->

	<div class="row lower-footer">
		<div class="col col-xs-12">
			<p>@lang('messages.Developed') <span><i class="fa fa-heart"></i></span> @lang('messages.by') <a href="https://www.kolpolok.com/">Kolpolok Limited</a></p>
		</div>
	</div>
</footer>

<input type="hidden" id="base_url" value="{{url('/')}}">