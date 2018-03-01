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
     * login
     */
    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);
    $userResult = $pdo->query("SELECT * FROM testapp.user WHERE phonenumber='" . $_POST["phonenumber"] . "'" );
    $user = $userResult->fetch();
    if ($user && $user["password"] == $_POST["password"]) {
        $_SESSION["User"] = $user["phonenumber"];
        echo "OK";
    }
    else {
        echo "Wrong";
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}




?>