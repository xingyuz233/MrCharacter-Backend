<?php
/**
 * Created by IntelliJ IDEA.
 * User: XY Zhang
 * Date: 2017/6/17
 * Time: 11:45
 */


$username = "root";
$password = "root";

try {
    session_start();
    /**
     * logout
     */
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();

} catch (PDOException $e) {
    echo $e->getMessage();
}


?>