<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-2</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str_name" placeholder="名前">
        <input type="text" name="str_comment" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
        if (isset( $_POST["str_name"] ) && !empty( $_POST["str_name"] ) && isset( $_POST["str_comment"] ) && !empty( $_POST["str_comment"] )){
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $date = date('Y-m-d H:i:s');
            $filename="mission_3-2.txt";
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $line_count = count($lines) + 1;
                $fp = fopen($filename,"a");
                fwrite($fp, $line_count."<>".$str_name."<>".$str_comment."<>".$date.PHP_EOL);
                fclose($fp);
                echo "書き込み成功！<br>";
            }else{
                $fp = fopen($filename,"a");
                fwrite($fp, "1<>".$str_name."<>".$str_comment."<>".$date.PHP_EOL);
                fclose($fp);
                echo "書き込み成功！<br>";
            }
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $line){
                    $line_list = explode("<>", $line);
                    echo $line_list[0] ."&nbsp;". $line_list[1] ."&nbsp;". $line_list[2] ."&nbsp;". $line_list[3] ."&nbsp;". "<br>";
                }
            }
        }
    ?>
</body>
</html>