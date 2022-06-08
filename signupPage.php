<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊畫面</title>
</head>

<style>
    label {
        display: inline-block;
        width: 70px;
        text-align: right;
    }

    div {
        display: inline-block;
        text-align: right;
    }
</style>

<body>
    <div>
        <a href="javascript:history.back()">回上一頁</a>
        <form style="line-height: 2;" method="POST" action="signup.php">
            <label>Name: </label><input type="text" name="username" /><br>
            <label>Email: </label><input type="text" name="email" /><br>
            <label>Password: </label><input type="password" name="password" /><br>
            <label>RePassword: </label><input type="password" name="password2" /><br>
            <input style="color: white; text-shadow: 1px 1px 2px black; border-radius: 10px; background-color: rgb(190, 116, 46);" type="submit" value="註冊" />
        </form>
    </div>
</body>

</html>