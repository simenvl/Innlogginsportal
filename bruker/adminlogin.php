<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Datasikkerhet</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #E5E5E5;
        }

        .login {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .login h1 {
            margin-bottom: 20px;
        }

        .loginbtn a {
            background-color: lightgray;
            text-decoration: none;
            color: gray;
            padding: 14px 18px;
            margin: 5px;
            cursor: pointer;
            display: inline-block;
        }
    </style>
</head>

<body>
<section class="login">
    <h1>Login</h1>

    <div class="inputtext">
        Username: <input type="text" />
        Password: <input type="text" />
    </div>
    <div class="loginbtn">
        <a href="templates/student/user_login.php">Logg Inn</a>
    </div>
</section>
</body>

</html>
