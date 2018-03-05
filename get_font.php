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
        $fontArrayResult = $pdo->query("SELECT * FROM testapp.font WHERE userphone=".$_SESSION["User"]);
        $fontArray = $fontArrayResult->fetchAll();

        $json_string = request_json($fontArray, $_SESSION["User"]);
        $progress_list = get_progress($json_string);

        foreach ($fontArray as $single_font) {
            $single_font["progress"] = $progress_list[$single_font['id']];
        }


        echo json_encode(array_utf8_encode($fontArray));
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

function request_json($fontArray, $user_id) {

    $fontList = array();
    foreach ($fontArray as $single_font) {
        array_push($fontList, $single_font["id"]);
    }

    return json_encode(array('cmd'=>'progress', 'user_id'=>$user_id, 'font_id'=>$fontList));
}

function get_progress($json_string) {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($socket, "localhost", 9999);

    socket_write($socket, $json_string, strlen($json_string));

    $out = socket_read($socket, 2048);

    $progress_list = json_decode($out);

    return $progress_list;
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
