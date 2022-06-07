<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認刪除頁面</title>
</head>

<body>
    <script>
        if (confirm("確定要刪除嗎？")) {
            self.location = "delete.php?id=<?php echo $_GET["id"]; ?>";
        } else {
            self.location = 'index.php';
        }
    </script>
    <!-- <a href="delete.php?id=<?php //echo $_GET["id"]; 
                                ?>">確定</a> -->
    <!-- <a href="index.php">取消</a> -->
</body>

</html>