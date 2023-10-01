<?php
    // DB接続設定
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    // 入力フォーム準備
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset( $_POST["edit"] ) && isset( $_POST["num2"] ) && !empty( $_POST["num2"] ) && !empty( $_POST["edit_pass"])){
            $num = $_POST["num2"];
            $edit_pass = $_POST["edit_pass"];
            $sql = 'SELECT * FROM mission5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();

            $line_count = count($results);
            $id_count = false;
            
            foreach($results as $row){
                if($row['id'] == $num){
                    $id_count = true;
                    if($row['pass'] == $edit_pass){
                        $edit = "hidden";
                        $edit_num = $row['id'];
                        $edit_name = $row['name'];
                        $edit_comment = $row['comment'];
                        echo $row['id']." 行目編集中　入力が終わったら送信ボタンを押してね<br>";
                    }else{
                        $edit = "hidden";
                        $edit_num = "";
                        $edit_name = "";
                        $edit_comment = "";
                        echo "パスワードが異なります";
                    }
                }
            }
            if($id_count == false){
                $edit = "hidden";
                $edit_num = "";
                $edit_name = "";
                $edit_comment = "";
                echo "該当番号がありません";
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
    <title>mission_5</title>
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

        // 基本入力
        if (empty( $_POST["num_edit"] ) && isset( $_POST["submit"] ) && !empty( $_POST["str_name"] ) && !empty( $_POST["str_comment"] )&& isset( $_POST["pass"] )){
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $pass = $_POST["pass"];
            $date = date('Y-m-d H:i:s');
            
            
            if (!empty( $_POST["pass"] )){
                $sql = "INSERT INTO mission5 (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $str_name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $str_comment, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->execute();
                echo "書き込み成功！<br>";
            }else{
                $sql = "INSERT INTO mission5 (name, comment, date) VALUES (:name, :comment, :date)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $str_name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $str_comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->execute();
                echo "書き込み成功！<br>パスワード未入力のためこの書き込みは編集・削除できません<br>";
            }
        
        // 削除機能
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && !empty( $_POST["num"]) && !empty( $_POST["del_pass"])){
            $del_pass = $_POST["del_pass"];
            $num = $_POST["num"];
            $mode = true;
            $sql = 'SELECT * FROM mission5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();

            $line_count = count($results);
            $id_count = false;
            
            
            foreach($results as $row){
                if($row['id'] == $num){
                    $id_count = true;
                    if($row['pass'] != $del_pass){
                        $mode = false;
                    }
                }
            }

            if($mode == true){
                $sql = 'delete from mission5 where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $num, PDO::PARAM_INT);
                $stmt->execute();
                echo "削除成功！<br>";
            }else{
                echo "パスワードが異なります<br>";
            }
            if($id_count == false){
                echo "該当番号がありません<br>";
            }
            
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && !empty( $_POST["num"]) && empty( $_POST["del_pass"])){
            echo "パスワードを入れてください<br>";
        }elseif (isset( $_POST["del"] ) && isset( $_POST["num"] ) && empty( $_POST["num"]) && !empty( $_POST["del_pass"])){
            echo "削除番号を入れてください<br>";
        
        // 編集機能
        }elseif (!empty( $_POST["num_edit"] ) && isset( $_POST["submit"] ) && !empty( $_POST["str_name"] ) && !empty( $_POST["str_comment"] ) && isset( $_POST["pass"] )){
            $num = $_POST["num_edit"];
            $str_name = $_POST["str_name"];
            $str_comment = $_POST["str_comment"];
            $date = date('Y-m-d H:i:s');
            $pass = $_POST["pass"];

            $sql = 'SELECT * FROM mission5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();

            $line_count = count($results);
            
            if (!empty( $_POST["pass"] )){
                $sql = 'UPDATE mission5 SET name=:name,comment=:comment,pass=:pass,date=:date WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $str_name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $str_comment, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':id', $num, PDO::PARAM_INT);
                $stmt->execute();
                echo "編集成功！<br>";
            }else{
                $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=:date WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $str_name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $str_comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':id', $num, PDO::PARAM_INT);
                $stmt->execute();
                echo "編集成功！<br>パスワード未入力のためこの書き込みは編集・削除できません<br>";
            }
            
            
            
        }
        // データベース内を表示
        $sql = 'SELECT * FROM mission5';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
        echo "<hr>";
        }
        
    ?>
</body>
</html>