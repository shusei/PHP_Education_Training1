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
    $title = $_POST['title'];
    $content = $_POST['content'];
    $mood = $_POST['mood'];
    //echo $id . " - " . $content;


    if (checkUserId($id)) :
        // update time
        $updated_at = date("Y-m-d H:i:s");

        try {
            $sth = $dbh->prepare("UPDATE boards SET title = :title, mood = :mood, content = :content, updated_at = :updated_at WHERE id = :id");
            $sth->execute(array(
                'title' => $title,
                'mood' => $mood,
                'content' => $content,
                'updated_at' => $updated_at,
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