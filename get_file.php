<?php

session_start();

if (is_uploaded_file($_FILES['bill']['tmp_name'])) {
    $uploads_dir = './' . $_SESSION['User'] . '/' . $_POST['font_name'] . '/';
    if (!file_exists($uploads_dir))
        mkdir($uploads_dir, 0777, true);

    $tmp_name = $_FILES['bill']['tmp_name'];
    move_uploaded_file($tmp_name, $uploads_dir . $_POST['pic_name']);
} else {
    echo "File not uploaded successfully.";
}

