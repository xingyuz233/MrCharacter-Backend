<?php
/**
 * Created by IntelliJ IDEA.
 * User: XY Zhang
 * Date: 2017/6/17
 * Time: 11:45
 */


$username = "root";
$password = "1997";

try {
    session_start();
    $connString = "mysql:host=111.230.231.55;dbname=testapp";
    $pdo = new PDO($connString, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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