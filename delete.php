<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>

<body>

    <?php
    require_once('conn.php');
    require_once('function.php');

    $id = $_GET["id"];

    checkName($id);

    try {
        $sth = $dbh->prepare("DELETE FROM board WHERE id = :id");
        $sth->execute(array(
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