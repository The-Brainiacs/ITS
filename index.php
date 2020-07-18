<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php'; // '../vendor/autoload.php';
require 'api/db.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello there from root");
    return $response;
});


//get single user profile
$app->get('/profiles/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM profiles WHERE id = $id";


// Logbook - Retrive table
// $app->get('/logbook', function (Request $request, Response $response, array $args) {

//     $sql = "SELECT * FROM log_book";

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
});

//update email, phone , address of the user
$app->put('/profiles/{id}', function (Request $request, Response $response, array $args) {
    
    
    $id = $args["id"];
    // $request->getAttribute('id');
    $phone = $request->getParam('newphone');
    $email = $request->getParam('newemail');
    $address = $request->getParam('newaddress');
    
    $sql = "UPDATE profiles SET phone=$phone, email=$email, address=$address WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);

        $stmt->execute();
        $count = $stmt->rowCount();

        $data = array(
            "rowAffected" => $count,
            "status" => "success"
        );
        echo json_encode($data);
    
    } catch(PDOException $e){
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
    // resp.send('Haluuuuya');
});



$app->run();
