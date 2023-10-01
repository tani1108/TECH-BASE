<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset( $_POST["edit"] ) && isset( $_POST["num2"] ) && !empty( $_POST["num2"] ) && !empty( $_POST["edit_pass"])){
            $num = $_POST["num2"];
            $filename="mission_3-5.txt";
            $edit_pass = $_POST["edit_pass"];
            $mode = true;
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
                            if($line_list[4] == $edit_pass){
                                $edit = "hidden";
                                $edit_num = $line_list[0];
                                $edit_name = $line_list[1];
                                $edit_comment = $line_list[2];
                                echo $line_list[0]." 行目編集中　入力が終わったら送信ボタンを押してね<br>";
                            }else{
                                $edit = "hidden";
                                $edit_num = "";
                                $edit_name = "";
                                $edit_comment = "";
                                echo "パスワードが異なります";
                            }
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
        }elseif ( isset( $_POST["edit"] ) && isset( $_POST["num2"] ) && !empty( $_POST["num2"] ) && empty( $_POST["edit_pass"])){
            $edit = "hidden";
            $edit_num = "";
            $edit_name = "";
            $edit_comment = "";
            echo "パスワードが入力されていません";
        }elseif ( isset( $_POST["edit"] ) && isset( $_POST["num2"] ) && empty( $_POST["num2"] ) && !empty( $_POST["edit_pass"])){
            $edit = "hidden";
            $edit_num = "";
            $edit_name = "";
            $edit_comment = "";
            echo "編集番号が入力されていません";
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
    <title>mission_3-5</title>
</head>
<body>
    <form action="" method="post">
        <input type=<?= $edit?> name="num_edit" placeholder="編集中番号" value=<?= $edit_num?>>
        <input type="text" name="str_name" placeholder="名前" value=<?= $edit_name?>>
        <input type="text" name="str_comment" placeholder="コメント" value=<?= $edit_comment?>>
        <input type="password" name="pass" placeholder="新しいパスワード">
        <input type="submit" name="submit">
        <br>
        <br>
        <input type="number" name="num" placeholder="削除番号">
        <input type="password" name="del_pass" placeholder="パスワード">
        <input type="submit" name="del" value="削除">
        <br>
        <br>
        <input type="number" name="num2" placeholder="編集対象番号">
        <input type="password" name="edit_pass" placeholder="パスワード">
        <input type="submit" name="edit" value="編集">
    </form>
    <?php
        if (empty( $_POST["num_edit"] ) && isset( $_POST["submit"] ) && !empty( $_POST["str_name"] ) && !empty( $_POST["str_comment"] )&& isset( $_POST["pass"] )){
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $pass = $_POST["pass"];
            $date = date('Y-m-d H:i:s');
            $filename="mission_3-5.txt";
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $line_count = count($lines) + 1;
                $fp = fopen($filename,"a");
                fwrite($fp, $line_count."<>".$str_name."<>".$str_comment."<>".$date."<>".$pass.PHP_EOL);
                fclose($fp);
                if (!empty( $_POST["pass"] )){
                    echo "書き込み成功！<br>";
                }else{
                    echo "書き込み成功！<br>パスワード未入力のためこの書き込みは編集・削除できません<br>";
                }
            }else{
                $fp = fopen($filename,"a");
                fwrite($fp, "1<>".$str_name."<>".$str_comment."<>".$date."<>".$pass.PHP_EOL);
                fclose($fp);
                echo "書き込み成功！<br>";
            }
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && !empty( $_POST["num"]) && !empty( $_POST["del_pass"])){
            $del_pass = $_POST["del_pass"];
            $num = $_POST["num"];
            $filename="mission_3-5.txt";
            $mode = true;
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
                            if($line_list[4] != $del_pass){
                                $mode = false;
                                array_push($new_file, $line);
                            }
                        }
                    }
                    $fp = fopen($filename,"w");
                    $new_file_list = explode("<>", $new_file[0]);
                    fwrite($fp, "1<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3]."<>".$new_file_list[4].PHP_EOL);
                    fclose($fp);
                    for($i = 1; $i < count($new_file); $i = $i + 1){
                        $fp = fopen($filename,"a");
                        $new_file_list = explode("<>", $new_file[$i]);
                        $line_num = $i + 1;
                        fwrite($fp, $line_num."<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3]."<>".$new_file_list[4].PHP_EOL);
                        fclose($fp);
                    }if($mode == true){
                        echo "削除成功！<br>";
                    }else{
                        echo "パスワードが異なります<br>";
                    }
                }else{
                    echo "該当番号がありません<br>";
                }
            }else{
                echo "ファイルが見つかりません<br>";
            }
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && !empty( $_POST["num"]) && empty( $_POST["del_pass"])){
            echo "パスワードを入れてください<br>";
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && empty( $_POST["num"]) && !empty( $_POST["del_pass"])){
            echo "削除番号を入れてください<br>";
        }elseif (!empty( $_POST["num_edit"] ) && isset( $_POST["submit"] ) && !empty( $_POST["str_name"] ) && !empty( $_POST["str_comment"] ) && isset( $_POST["pass"] )){
            $num = $_POST["num_edit"];
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $date = date('Y-m-d H:i:s');
            $filename="mission_3-5.txt";
            $pass = $_POST["pass"];
            $mode = true;
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
                            $edit_line = ($line_list[0]."<>".$str_name."<>".$str_comment."<>".$date."<>".$pass);
                            array_push($new_file, $edit_line);
                            }
                        }
                    $fp = fopen($filename,"w");
                    $new_file_list = explode("<>", $new_file[0]);
                    fwrite($fp, "1<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3]."<>".$new_file_list[4].PHP_EOL);
                    fclose($fp);
                    for($i = 1; $i < count($new_file); $i = $i + 1){
                        $fp = fopen($filename,"a");
                        $new_file_list = explode("<>", $new_file[$i]);
                        $line_num = $i + 1;
                        fwrite($fp, $line_num."<>".$new_file_list[1]."<>".$new_file_list[2]."<>".$new_file_list[3]."<>".$new_file_list[4].PHP_EOL);
                        fclose($fp);
                    }
                    if($mode == true){
                        if (!empty( $_POST["pass"] )){
                            echo "編集成功！<br>";
                        }else{
                            echo "編集成功！<br>パスワード未入力のためこの書き込みは編集・削除できません<br>";
                        }
                    }else{
                        echo "パスワードが異なります<br>";
                    }
                }
            }
        }
        $filename="mission_3-5.txt";
        if(file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            echo "<br>";
            foreach($lines as $line){
                $line_list = explode("<>", $line);
                echo $line_list[0] ."&nbsp;". $line_list[1] ."&nbsp;". $line_list[2] ."&nbsp;". $line_list[3] ."&nbsp;". "<br>";
            }
        }
    ?>
</body>
</html>