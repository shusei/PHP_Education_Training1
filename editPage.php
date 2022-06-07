<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯留言頁面</title>
</head>

<?php
require_once('conn.php');

$id = $_GET["id"];

try {
    $sth = $dbh->prepare("SELECT * FROM board WHERE id = :id");
    $sth->execute(array(
        'id' => $id
    ));
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$result = $sth->fetch(PDO::FETCH_ASSOC);
//print_r($result);
?>

<body>
    <form method="POST" action="edit.php">
        <!-- id: <input type="text" name="id" value="<?php //echo $result['id'] 
                                                        ?>" readonly="readonly" /><br> -->
        <!-- name: <input type="text" name="username" value="<?php //SESSION_start(); echo $_SESSION['username'] 
                                                                ?>" readonly="readonly" /><br> -->
        content:<br><textarea rows="10" cols="27" name="content"><?php SESSION_start();
                                                                    $_SESSION['id'] = $id;
                                                                    echo ($result['content']) ?></textarea>
        <input style="color: white; text-shadow: 1px 1px 2px black; border-radius: 10px; background-color: rgb(190, 116, 46);" type="submit" value="修改" />
    </form>
</body>

</html>