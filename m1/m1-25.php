<?php
    $str = "Hello world";
    $filename="mission_1-25.txt";
    $fp = fopen($filename,"w");
    fwrite($fp, $str.PHP_EOL);
    fclose($fp);
    echo "書き込み成功！";
?>