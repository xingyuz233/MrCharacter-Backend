<?php
/**
 * Created by IntelliJ IDEA.
 * User: xingyu
 * Date: 2018/3/2
 * Time: 下午12:02
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

    if (!$_SESSION['User']) {
        echo "Wrong";
    } else {
        $fontArrayResult = $pdo->query("SELECT * FROM testapp.font WHERE userid=".$_SESSION["User"]);
        $fontArray = $fontArrayResult->fetchAll();
        echo json_encode(array_utf8_encode($fontArray));
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
