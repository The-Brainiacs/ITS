<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor\autoload.php';
require 'api\db.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Salam there from root");
    return $response;
});

// Logbook - Retrive table
$app->get('/logbook', function (Request $request, Response $response, array $args) {

    $sql = "SELECT * FROM log_book";

    try {
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

//Logbook - Retrieve table based on search week
$app->get('/log_book/{week}', function (Request $request, Response $response, array $args) {
    $id = $args['week'];
    $sql = "SELECT * FROM log_book WHERE week = $week";

    try {
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
    // $response->getBody()->write("get single user based on id=$id");
    // return $response;
});

//Logbook -Insert Logbook
$app->post('/log_book', function (Request $request, Response $response, array $args) {
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
            "rowcount" =>$count
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
    // $response->getBody()->write("api to post a single user");
    // return $response;
});
$app->run();