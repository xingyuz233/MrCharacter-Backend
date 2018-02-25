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

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $userResult = $pdo->query("SELECT * FROM testapp.user WHERE phonenumber='" . $_POST["User.PHONENUMBER"] . "'");
    $user = $userResult->fetch();
    if ($user) {
        echo false;
    } else {
        $insertUser = $pdo->prepare("INSERT INTO testapp.user (phonenumber, username, password) VALUES 
                                                                (:phonenumber, :username, :password)");
        $insertUser->bindValue(':phonenumber', $_POST["User.PHONENUMBER"]);
        $insertUser->bindValue(':username', $_POST["User.USERNAME"]);
        $insertUser->bindValue(':password', $_POST["User.PASSWORD"]);
        $insertUser->execute();
        $_SESSION["User"] = $_POST["User.PHONENUMBER"];
        echo true;
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

function array_utf8_encode($dat)
{
    if (is_string($dat))
        return utf8_encode($dat);
    if (!is_array($dat))
        return $dat;
    $ret = array();
    foreach ($dat as $i => $d)
        $ret[$i] = array_utf8_encode($d);
    return $ret;
}


?>