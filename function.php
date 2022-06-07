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
    function checkName($id)
    {
        require_once('conn.php');

        try {
            global $dbh;
            $sth = $dbh->prepare("SELECT * FROM board WHERE id = :id");
            $sth->execute(array(
                'id' => $id
            ));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        // session是否已經啟動
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        //echo $result['user_id'];
        //echo $_SESSION['user_id'];

        // 判斷是不是session使用者修改自己資料
        if ($result['user_id'] != $_SESSION['user_id']) :
    ?>
            <script>
                alert("Don't hack me!");
                self.location = 'index.php';
            </script>
    <?php
            die();
        endif;
    }

    ?>
</body>

</html>