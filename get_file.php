<?php

session_start();

$arr = json_decode($_POST['pic_name']);

foreach ($arr as $index => $name) {
    if (is_uploaded_file($_FILES['upload' . $index]['tmp_name'])) {
        $uploads_dir = './' . $_SESSION['User'] . '/' . $_POST['font_name'] . '/';
        if (!file_exists($uploads_dir))
            mkdir($uploads_dir, 0777, true);

        $tmp_name = $_FILES['upload' . $index]['tmp_name'];
        move_uploaded_file($tmp_name, $uploads_dir . $name);
    } else {
        echo "File not uploaded successfully.";
        exit(1);
    }
}

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($socket, "localhost", 9999);

$json_data = array('cmd' => 'launch', 'user_id' => $_SESSION['User'], 'font_id' => $_POST['font_name']);
$json_string = json_encode($json_data);

socket_write($socket, $json_string, strlen($json_string));

$out = socket_read($socket, 2048);
if ($out == 'OK')
    echo 'OK';
else
    echo 'Wrong';
