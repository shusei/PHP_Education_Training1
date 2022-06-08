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
    <a href="index.php">回首頁</a><br>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?= $result['id'] ?>">
        Content:<br><textarea rows="10" cols="27" name="content"><?= $result['content'] ?></textarea>
        <input style="color: white; text-shadow: 1px 1px 2px black; border-radius: 10px; background-color: rgb(190, 116, 46);" type="submit" value="修改" />
    </form>
</body>

</html>