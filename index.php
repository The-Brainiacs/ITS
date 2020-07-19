<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'api/db.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello there from root");
    return $response;
});

//get all logbook
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

//get logbook by week
$app->get('/logbook/{week}', function (Request $request, Response $response, array $args) {

    $week = $args['week'];
    $sql = "SELECT * FROM log_book WHERE week = $week";

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

//Logbook -Insert Logbook
$app->post('/logbook', function (Request $request, Response $response, array $args) {
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
});

//get all users
$app->get('/users', function (Request $request, Response $response, array $args) {

    $sql = "SELECT * FROM user";

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

//get all notifications
$app->get('/notifications', function (Request $request, Response $response, array $args) {

    $sql = "SELECT * FROM notification";

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


//get single user profile
$app->get('/profiles/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM profiles WHERE id = $id";

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

//Insert BLI-1C Form
$app->post('/bli1c', function (Request $request, Response $response, array $args) {
    $coor_name = $_POST["coor_name"];
    $faculty = $_POST["faculty"];
    $office_num = $_POST["office_num"];
    $phone_num = $_POST["phone_num"];
    $faculty_programme = $_POST["faculty_programme"];
    $coor_email = $_POST["coor_email"];

    $comp_name = $_POST["comp_name"];
    $comp_reg = $_POST["comp_reg"];
    $comp_ceo = $_POST["comp_ceo"];
    $comp_website = $_POST["comp_website"];
    $comp_category = $_POST["comp_category"];
    $comp_sector = $_POST["comp_sector"];
    
    $department = $_POST["department"];
    $contact_name = $_POST["contact_name"];
    $contact_phone = $_POST["contact_phone"];
    $contact_email = $_POST["contact_email"];
 
    try {
        $sql = "INSERT INTO bli1c 
            (coor_name, faculty, office_num, phone_num, faculty_programme, coor_email,   
            comp_name, comp_reg, comp_ceo, comp_website, comp_category, comp_sector,
            department, contact_name, contact_phone, contact_email) 
            VALUES 
            (:coor_name, :faculty, :office_num, :phone_num, :faculty_programme, :coor_email,
            :comp_name, :comp_reg, :comp_ceo, :comp_website, :comp_category, :comp_sector,
            :department, :contact_name, :contact_phone, :contact_email)";

        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':coor_name', $coor_name);
        $stmt->bindValue(':faculty', $faculty);
        $stmt->bindValue(':office_num', $office_num);
        $stmt->bindValue(':phone_num', $phone_num);
        $stmt->bindValue(':faculty_programme', $faculty_programme);
        $stmt->bindValue(':coor_email', $coor_email);

        $stmt->bindValue(':comp_name', $comp_name);
        $stmt->bindValue(':comp_reg', $comp_reg);
        $stmt->bindValue(':comp_ceo', $comp_ceo);
        $stmt->bindValue(':comp_website', $comp_website);
        $stmt->bindValue(':comp_category', $comp_category);
        $stmt->bindValue(':comp_sector', $comp_sector);

        $stmt->bindValue(':department', $department);
        $stmt->bindValue(':contact_name', $contact_name);
        $stmt->bindValue(':contact_phone', $contact_phone);
        $stmt->bindValue(':contact_email', $contact_email);
        
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
});

//get single bli1c
$app->get('/bli1c', function (Request $request, Response $response, array $args) {

    $sql = "SELECT LAST * FROM bli1c";

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

$app->run();
