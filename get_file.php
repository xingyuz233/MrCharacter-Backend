<?php

session_start();

$arr = json_decode($_POST['pic_name']);

foreach ($arr as $index => $name) {
    if (is_uploaded_file($_FILES['upload' . $index]['tmp_name'])) {
        $uploads_dir = './images/' . $_SESSION['User'] . '/' . $_POST['font_name'] . '/';
        if (!file_exists($uploads_dir))
            mkdir($uploads_dir, 0777, true);

        $tmp_name = $_FILES['upload' . $index]['tmp_name'];
        move_uploaded_file($tmp_name, $uploads_dir . $name);
    } else {
        echo "File not uploaded successfully.";
        exit(1);
    }
}


// update the database
$username = "root";
$password = "root";

try {
    $connString = "mysql:host=115.159.185.234;dbname=font";
    $pdo = new PDO($connString, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!$_SESSION['User']) {
        echo "Wrong";
    } else {
        //创建字体目录
        //if (!file_exists($dir)){
        if ($_POST["overwrite"] == 0) {

            $insertUser = $pdo->prepare("INSERT INTO font.font (name, userphone) VALUES 
                                                                (:name, :userphone)");
            $insertUser->bindValue(':name', $_POST["font_name"]);
            $insertUser->bindValue(':userphone', $_SESSION["User"]);
            $insertUser->execute();
        } else {
            $sql = "UPDATE font.font SET finished=0 WHERE name='".$_POST["font_name"]."' and userphone='".$_SESSION["User"]."'";
            $result = $pdo->exec($sql);
        }
        //   echo 'OK';
        //} else {
        //    echo 'Wrong';
        //}


    }

} catch (PDOException $e) {
    echo $e->getMessage();
}


//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//socket_connect($socket, "localhost", 9999);
//
//$json_data = array('cmd' => 'launch', 'user_id' => $_SESSION['User'], 'font_id' => $_POST['font_name']);
//$json_string = json_encode($json_data);
//
//socket_write($socket, $json_string, strlen($json_string));
//
//$out = socket_read($socket, 2048);
$out = 'OK';
if ($out == 'OK')
    echo 'OK';
else
    echo 'Wrong';
