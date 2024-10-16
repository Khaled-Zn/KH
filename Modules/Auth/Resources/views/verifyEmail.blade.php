
<!DOCTYPE html>
<html lang="en">

<body>

<p>Dear {{ $user->username }}</p>
<p>Your account has been created, your activate code is {{$user->email_verification_token}}</p></p>
<p>Thanks</p>

</body>

</html>
