Dear Honorable Donor,<br><br>

You have been succesfully registered on Bidyanondo.com. Now, you have to verify your email.<br><br>

Your login credentials are given below:<br><br>

<b>Username: {{ $user->email }}</b><br>
<b>password: {{ $password }}</b><br><br>

<h1>
	<a href="{{ url('/donation/verify/'.$user->id.'/'.$verify_token) }}">Click here to verify your email</a>
</h1>
<br><br>

Best Regards,<br>
Bidyanodo Foundation