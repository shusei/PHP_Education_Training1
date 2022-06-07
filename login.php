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
    date_default_timezone_set("Asia/Taipei");
    $login_time = date("Y-m-d h:i:s");


    try {
        $sth = $dbh->prepare("SELECT * FROM users WHERE username = :username");
        $sth->execute(array(
            'username' => $username
            //'password' => $password,
        ));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    //print_r($result);

    // hash password_verify
    $hashVerify = password_verify($password, $result['password']);

    if (!empty($result) && $hashVerify) {

        $id = $result['id'];
        session_start();
        //$_SESSION['id'] = $id;
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = $login_time;
        //echo $_SESSION['id'];
        //header("Location: index.php");

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
    } else {
        echo "帳號或密碼錯誤，請重試。<br>";
        echo '<a href="javascript:history.back()">回上一頁</a>';
    }
    ?>
</body>

</html>