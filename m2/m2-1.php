<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-1</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
        if (isset( $_POST["str"] ) && !empty( $_POST["str"] )){
            $str = $_POST["str"];
            echo $str . "を受け付けました";
        }
    ?>
</body>
</html>