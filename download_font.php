<?php

session_start();

if ($_SESSION['User']) {
    $font_path = "./fonts/" . $_SESSION['User'] . '/' . $_POST['font_name'] . '.ttf';
    if (file_exists($font_path)) {
        header('Content-type: application/octet-stream');
        header('Content-length: ' . filesize($font_path));
        readfile($font_path);
    }
}