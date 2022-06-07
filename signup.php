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
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    date_default_timezone_set("Asia/Taipei");
    $signup_time = date("Y-m-d h:i:s");

    // Check already sign up
    try {
        $sth = $dbh->prepare("SELECT * FROM users WHERE email = :email || username = :username");
        $sth->execute(array(
            'email' => $email,
            'username' => $username
        ));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }


    if (!empty($sth->fetch(PDO::FETCH_ASSOC))) {
        echo '<a href="javascript:history.back()">回上一頁</a><br>';
        die("這個username或email已經被註冊過了");
    } else {

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
            $sth = $dbh->prepare("SELECT * FROM users WHERE username = :username && password = :password");
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
        //echo $_SESSION['id'];
        //header("Location: index.php");

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

        註冊成功！<br>
        <a href="index.php">登入</a>
    <?php
    }
    ?>


</body>

</html>