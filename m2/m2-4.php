<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-4</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
        if (isset( $_POST["str"] ) && !empty( $_POST["str"] )){
            $str = $_POST["str"];
            $filename="mission_2-4.txt";
            $fp = fopen($filename,"a");
            fwrite($fp, $str.PHP_EOL);
            fclose($fp);
            echo "書き込み成功！<br>";
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $line){
                    echo $line . "<br>";
                }
            }
        }
    ?>
</body>
</html>