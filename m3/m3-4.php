<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset( $_POST["edit"] ) && isset( $_POST["num2"] ) && !empty( $_POST["num2"] )){
            $num = $_POST["num2"];
            $filename="mission_3-4.txt";
            $new_file=[];
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $line_count = count($lines);
                if($line_count >= $num){
                    $count = 0;
                    foreach($lines as $line){
                        $line_list = explode("<>", $line);
                        $count = $count + 1;
                        if($line_list[0] == $num){
                            $edit = "hidden";
                            $edit_num = $line_list[0];
                            $edit_name = $line_list[1];
                            $edit_comment = $line_list[2];
                            echo $line_list[0]." 行目編集中　入力が終わったら送信ボタンを押してね<br>";
                        }
                    }
                }else{
                    $edit = "hidden";
                    $edit_num = "";
                    $edit_name = "";
                    $edit_comment = "";
                    echo "該当番号がありません";
                }
            }
        }else{
            $edit = "hidden";
            $edit_num = "";
            $edit_name = "";
            $edit_comment = "";
        }
    }else{
        $edit = "hidden";
        $edit_num = "";
        $edit_name = "";
        $edit_comment = "";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-4</title>
</head>
<body>
    <form action="" method="post">
        <input type=<?= $edit?> name="num_edit" placeholder="編集中番号" value=<?= $edit_num?>>
        <input type="text" name="str_name" placeholder="名前" value=<?= $edit_name?>>
        <input type="text" name="str_comment" placeholder="コメント" value=<?= $edit_comment?>>
        <input type="submit" name="submit">
        <br>
        <br>
        <input type="number" name="num" placeholder="削除番号">
        <input type="submit" name="del" value="削除">
        <br>
        <br>
        <input type="number" name="num2" placeholder="編集対象番号">
        <input type="submit" name="edit" value="編集">
    </form>
    <?php
        if (empty( $_POST["num_edit"] ) && isset( $_POST["submit"] ) && isset( $_POST["str_name"] ) && !empty( $_POST["str_name"] ) && isset( $_POST["str_comment"] ) && !empty( $_POST["str_comment"] )){
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $date = date('Y-m-d H:i:s');
            $filename="mission_3-4.txt";
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
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && !empty( $_POST["num"] )){
            $num = $_POST["num"];
            $filename="mission_3-4.txt";
            $new_file=[];
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $line_count = count($lines);
                if($line_count >= $num){
                    $count = 0;
                    foreach($lines as $line){
                        $line_list = explode("<>", $line);
                        $count = $count + 1;
                        if($line_list[0] != $num){
                            array_push($new_file, $line);
                        }
                    }
                    $fp = fopen($filename,"w");
                    $new_file_list = explode("<>", $new_file[0]);
                    fwrite($fp, "1<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3].PHP_EOL);
                    fclose($fp);
                    for($i = 1; $i < count($new_file); $i = $i + 1){
                        $fp = fopen($filename,"a");
                        $new_file_list = explode("<>", $new_file[$i]);
                        $line_num = $i + 1;
                        fwrite($fp, $line_num."<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3].PHP_EOL);
                        fclose($fp);
                    }
                    echo "削除成功！<br>";
                }else{
                    echo "該当番号がありません<br>";
                }
            }else{
                echo "ファイルが見つかりません<br>";
            }
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $line){
                    $line_list = explode("<>", $line);
                    echo $line_list[0] ."&nbsp;". $line_list[1] ."&nbsp;". $line_list[2] ."&nbsp;". $line_list[3] ."&nbsp;". "<br>";
                }
            }
        }elseif (!empty( $_POST["num_edit"] ) && isset( $_POST["submit"] ) && isset( $_POST["str_name"] ) && !empty( $_POST["str_name"] ) && isset( $_POST["str_comment"] ) && !empty( $_POST["str_comment"] )){
            $num = $_POST["num_edit"];
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $date = date('Y-m-d H:i:s');
            $filename="mission_3-4.txt";
            $new_file=[];
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $line_count = count($lines);
                if($line_count >= $num){
                    $count = 0;
                    foreach($lines as $line){
                        $line_list = explode("<>", $line);
                        $count = $count + 1;
                        if($line_list[0] != $num){
                            array_push($new_file, $line);
                        }else{
                            $edit_line = ($line_list[0]."<>".$str_name."<>".$str_comment."<>".$date);
                            array_push($new_file, $edit_line);
                        }
                    }
                    $fp = fopen($filename,"w");
                    $new_file_list = explode("<>", $new_file[0]);
                    fwrite($fp, "1<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3].PHP_EOL);
                    fclose($fp);
                    for($i = 1; $i < count($new_file); $i = $i + 1){
                        $fp = fopen($filename,"a");
                        $new_file_list = explode("<>", $new_file[$i]);
                        $line_num = $i + 1;
                        fwrite($fp, $line_num."<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3].PHP_EOL);
                        fclose($fp);
                    }
                    echo "編集成功！<br>";
                }
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