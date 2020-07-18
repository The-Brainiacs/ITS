<?php
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");

require 'db.php';


$week = $_POST["week"];
$date = $_POST["date"];
$day = $_POST["day"];
$log = $_POST["log"];

try {
    $sql = "INSERT INTO log_book (week,date,day,log) VALUES (:week,:date,:day,:log)";
    $db = new db();
    // Connect
    $db = $db->connect();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':week', $week);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':day', $day);
    $stmt->bindValue(':log', $log);

    $stmt->execute();
    $count = $stmt->rowCount();
    $db = null;

    $data = array(
        "status" => "success",
        "rowcount" =>$count,
        "weeek" => $week,
        "date" => $date,
        "day" => $day,
        "log" => $log,
    );
    echo json_encode($data);
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}
