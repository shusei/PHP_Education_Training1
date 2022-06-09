<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯留言</title>
</head>

<body>

    <?php
    require_once('conn.php');
    require_once('function.php');

    session_start();
    $id = $_POST['id'];
    $content = $_POST['content'];
    //echo $id . " - " . $content;


    if (checkUserId($id)) :
        // update time
        $update_time = date("Y-m-d h:i:s");

        try {
            $sth = $dbh->prepare("UPDATE board SET content = :content, update_time = :update_time WHERE id = :id");
            $sth->execute(array(
                'content' => $content,
                'update_time' => $update_time,
                'id' => $id
            ));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        header("Location: index.php");
    else :
    ?>
        <p>非使用者帳號不可修改</p>
        <a href="index.php">回首頁</a>
    <?php
    endif;
    ?>

</body>

</html>