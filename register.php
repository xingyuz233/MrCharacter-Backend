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
    $userResult = $pdo->query("SELECT * FROM testapp.user WHERE phonenumber='" . $_POST["phonenumber"] . "'");
    $user = $userResult->fetch();
    if ($user) {
        echo "Wrong";
    } else {
        $insertUser = $pdo->prepare("INSERT INTO testapp.user (phonenumber, username, password) VALUES 
                                                                (:phonenumber, :username, :password)");
        $insertUser->bindValue(':phonenumber', $_POST["phonenumber"]);
        $insertUser->bindValue(':username', $_POST["username"]);
        $insertUser->bindValue(':password', $_POST["password"]);
        $insertUser->execute();
        $_SESSION["User"] = $_POST["phonenumber"];
        echo "OK";
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