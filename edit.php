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

    session_start();
    $id = $_SESSION['id'];
    //$username = $_POST['username'];
    $content = $_POST['content'];
    //echo $id . " - " . $content;


    // update time
    date_default_timezone_set("Asia/Taipei");
    $update_time = date("Y-m-d h:i:s");


    checkName($id);

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
    ?>
</body>

</html>