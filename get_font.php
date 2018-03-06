<?php
/**
 * Created by IntelliJ IDEA.
 * User: xingyu
 * Date: 2018/3/2
 * Time: 下午12:02
 */

$username = "root";
$password = "root";


try {
    session_start();
    $connString = "mysql:host=115.159.185.234;dbname=font";
    $pdo = new PDO($connString, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /**
     * login
     */

    if (!$_SESSION['User']) {
        echo "Wrong";
    } else {
        $fontArrayResult = $pdo->query("SELECT * FROM font.font WHERE userphone=" . $_SESSION["User"]);
        $fontArray = $fontArrayResult->fetchAll();

//        $json_string = request_json($fontArray, $_SESSION["User"]);
//        $progress_list = get_progress($json_string);

        foreach ($fontArray as $index => $single_font) {
//            $fontArray[$index]["progress"] = $progress_list[$single_font['name']];
            $fontArray[$index]["progress"] = .5;
        }

        echo json_encode(array_utf8_encode($fontArray));
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

function request_json($fontArray, $user_id)
{

    $fontList = array();
    foreach ($fontArray as $single_font) {
        array_push($fontList, $single_font["name"]);
    }

    return json_encode(array('cmd' => 'progress', 'user_id' => $user_id, 'font_id' => $fontList));
}

function get_progress($json_string)
{
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
