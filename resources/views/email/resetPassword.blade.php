<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reset Password</title>
</head>
<body>
    <h2>Reset your password by click below "RESET PASSWORD" button!</h2>

    
       <a href="{{ route('resetPasswordForm',$mailData['token']) }}" style="background-color: #0404e8; /* Green */
       border: none;
       color: white;
       padding: 10px 20px;
       text-align: center;
       text-decoration: none;
       display: inline-block;
       font-size: 16px;
       margin: 4px 2px;
       cursor: pointer;
       border-radius: 5px;"> RESET PASSWORD
      </a>
    
    
</body>
</html>