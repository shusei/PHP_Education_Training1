<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯留言頁面</title>
</head>

<body>
    <?php
    require_once('conn.php');
    require_once('function.php');

    $id = $_GET["id"];

    if (checkUserId($id)) :
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

        $mood_id = $result['mood'];

        try {
            $sth2 = $dbh->prepare("SELECT * FROM moods");
            $sth2->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $result2 = $sth2->fetchAll();
    ?>

        <a href="index.php">回首頁</a><br>
        <form method="POST" action="edit.php">
            <input type="hidden" name="id" value="<?= $result['id'] ?>">
            <label>Title:</label><br><textarea rows="1" cols="27" name="title"><?= $result['title'] ?></textarea><br>
            <label>Content:</label><br><textarea rows="10" cols="27" name="content"><?= $result['content'] ?></textarea>
            <select name="mood">
                <?php
                foreach ($result2 as $row) :
                ?>
                    <option value="<?= $row["id"] ?>" <?php if ($mood_id == $row["id"]) echo "selected" ?>><?= $row["mood"] ?></option>
                <?php
                endforeach;
                ?>
            </select>
            <input style="color: white; text-shadow: 1px 1px 2px black; border-radius: 10px; background-color: rgb(190, 116, 46);" type="submit" value="修改" />
        </form>
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