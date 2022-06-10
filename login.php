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

    $username = $_POST['username'];
    $password = $_POST['password'];

    // log in
    $login_time = date("Y-m-d H:i:s");

    try {
        $sth = $dbh->prepare("SELECT * FROM users WHERE username = :username");
        $sth->execute(array(
            'username' => $username
        ));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if (!isset($result)) :
    ?>
        <p>使用者帳號不存在！</p>
        <a href="javascript:history.back()">回上一頁</a>
        <?php
    else :
        // hash password_verify
        $hashVerify = password_verify($password, $result['password']);

        if (!empty($result) && $hashVerify) :

            $id = $result['id'];
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = $login_time;


            // Add login time
            try {
                $sth = $dbh->prepare("UPDATE users SET login_time = :login_time WHERE id = :id");
                $sth->execute(array(
                    'login_time' => $login_time,
                    'id' => $id
                ));
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }

            header("Location: index.php");
        else :
        ?>
            <p>"帳號或密碼錯誤，請重試。</p><br>
            <a href="javascript:history.back()">回上一頁</a>
    <?php
        endif;
    endif;
    ?>
</body>

</html>