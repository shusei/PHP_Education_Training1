<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增留言頁面</title>
</head>

<body>
    <form method="POST" action="post.php">
        <?php //name: <input type="text" name="username" /><br> 
        ?>
        Content:<br><textarea rows="10" cols="27" name="content"></textarea>
        <input style="color: white; text-shadow: 1px 1px 2px black; border-radius: 10px; background-color: rgb(190, 116, 46);" type="submit" value="留言" />
    </form>
</body>

</html>