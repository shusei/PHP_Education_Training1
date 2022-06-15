<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增留言頁面</title>
</head>

<body>
    <a href="index.php">回首頁</a><br>
    <form method="POST" action="post.php">
        <label>Title:</label><br><textarea rows="1" cols="27" name="title"></textarea><br>
        <label>Content:</label><br><textarea rows="10" cols="27" name="content"></textarea><br>
        <select name="mood">
            <option value="">--請選擇一個心情--</option>
            <!-- TODO 讀資料庫 -->
            <?php
            require_once('conn.php');

            try {
                $sth = $dbh->prepare("SELECT * FROM moods");
                $sth->execute();
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            $results = $sth->fetchAll();

            foreach ($results as $result) :
            ?>
                <option value="<?= $result["id"] ?>"><?= $result["mood"] ?></option>
            <?php
            endforeach;
            ?>
        </select>
        <input style="color: white; text-shadow: 1px 1px 2px black; border-radius: 10px; background-color: rgb(190, 116, 46);" type="submit" value="留言" />
    </form>
</body>

</html>