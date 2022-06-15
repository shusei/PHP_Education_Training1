<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    require_once('conn.php');
    require_once('function.php');

    $id = $_GET["id"];

    // 改寫之前的checkName($id)為 bool checkUserId($id)
    if (checkUserId($id)) :

        try {
            $sth = $dbh->prepare("DELETE FROM boards WHERE id = :id");
            $sth->execute(array(
                'id' => $id
            ));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    ?>
        <p>刪除成功！</p><br>
        <a href="index.php">回首頁</a>
    <?php
    else :
    ?>
        <p>非使用者帳號不可修改</p>
        <a href="index.php">回首頁</a>
    <?php
    endif;
    ?>

</body>

</html>