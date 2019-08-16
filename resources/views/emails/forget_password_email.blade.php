Dear Honorable Donor,<br><br>

Your password is succsfully changed. Now, you have to verify your email.<br><br>

Your new login credentials are given below:<br><br>

<b>Username: {{ $user->email }}</b><br>
<b>password: {{ $password }}</b><br><br>

<h1>
	<a href="{{ url('/email_verification/'.$user->id.'/'.$user->verify_token) }}">Click here to verify your email</a>
</h1>
<br><br>

Best Regards,<br>
Bidyanodo Foundation