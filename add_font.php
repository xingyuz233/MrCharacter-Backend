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
    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);

    /*
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $font = $pdo->query("SELECT * FROM testapp.font WHERE phonenumber='" . $_POST["phonenumber"] . "'");
    $user = $userResult->fetch();
    */
    if (!$_SESSION['User']) {
        echo "Wrong";
    } else {
        $insertUser = $pdo->prepare("INSERT INTO testapp.font (name, userid) VALUES 
                                                                (:name, :userid)");
        $insertUser->bindValue(':name', $_POST["name"]);
        $insertUser->bindValue(':userid', $_SESSION["User"]);
        $insertUser->execute();


        //创建字体目录
        $dir = iconv("UTF-8", "GBK", "data/"+$_SESSION["User"]+"/"+$_POST["name"]);
        echo "OK";
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}
