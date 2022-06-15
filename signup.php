<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊</title>
</head>

<body>

    <?php
    require_once('conn.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password != $password2) :
    ?>
        <p>密碼輸入不一致，請重新輸入！</p>
        <a href="javascript:history.back()">回上一頁</a>
        <?php
    else :
        // Creates a password hash，Use the bcrypt algorithm with random salt(隨機數據)
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // 小bug，之前參數是("Y-m-d h:i:s")，小寫h會讓上午下午分辨不出來
        // 除非s改sa，才會印出am or pm，但 h 改 H 即可顯示24小時制
        $signup_time = date("Y-m-d H:i:s");

        // Check already sign up
        try {
            $sth = $dbh->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
            $sth->execute(array(
                'email' => $email,
                'username' => $username
            ));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        // ===, !== : 不只數值相等之外，型別也相等
        // null len()==0
        if ($sth->fetch(PDO::FETCH_ASSOC) !== null) :
        ?>
            <p>這個username或email已經被註冊過了</p>
            <a href="javascript:history.back()">回上一頁</a><br>
        <?php
        else :
            // create
            try {
                $sth = $dbh->prepare("INSERT INTO users(username, email, password, signup_time)
                                      VALUES(:username, :email, :password, :signup_time)");
                $sth->execute(array(
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'signup_time' => $signup_time
                ));
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }


            // log in
            $login_time = date("Y-m-d h:i:s");

            try {
                $sth = $dbh->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
                $sth->execute(array(
                    'username' => $username,
                    'password' => $password,
                ));
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            //print_r($result);

            $id = $result['id'];
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            // Add login time
            try {
                $sth = $dbh->prepare("UPDATE users SET login_time = :login_time WHERE id = :id");
                $sth->execute(array(
                    'login_time' => $login_time,
                    'id' => $id
                ));
                $_SESSION['login_time'] = $login_time;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }

        ?>

            <p>註冊成功！</p><br>
            <a href="index.php">自動登入</a>
    <?php
        endif;
    endif;
    ?>


</body>

</html>