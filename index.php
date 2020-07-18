<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'api/db.php';
$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Testing ITS REST api");
    return $response;
});

//API GET-all patients
$app->get('/patients', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM patients";

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

//API GET-single patient
$app->get('/patients/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM patients WHERE id = $id";

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

// API POST-add new patient
$app->post('/patients', function (Request $request, Response $response, array $args) {
    
    $id = $_POST["id"];
    $name = $_POST["name"]; 
    $admission_date = $_POST["admission_date"];
    $icu_date = $_POST["icu_date"];
    $dicharge_date = $_POST["dicharge_date"];
    $patient_status = $_POST["patient_status"];

    try {
        $sql = "INSERT INTO patients (id,name,admission_date,icu_date,dicharge_date,patient_status) VALUES (:id,:name,:admission_date,:icu_date,:dicharge_date,:patient_status)";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':icu_date', $icu_date);
        $stmt->bindValue(':admission_date', $admission_date);
        $stmt->bindValue(':dicharge_date', $dicharge_date);
        $stmt->bindValue(':patient_status', $patient_status);

        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;

        $data = array(
            "status" => "success",
            "rowcount" =>$count,
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

// API PUT-update one profile
$app->put('/patients/{id}', function (Request $request, Response $response, array $args) {
    
    $name = $request->getParam('name');
    $id = $_GET["id"];
    // $request->getAttribute('id');
    $icu_date = $request->getParam('icu_date');
    $admission_date = $request->getParam('admission_date');
    $dicharge_date = $request->getParam('dicharge_date');
    $patient_status = $request->getParam('patient_status');

    $sql = "UPDATE patients SET
            name 	= :name,
            admission_date	= :admission_date,
            icu_date 	= :icu_date,
            dicharge_date 	= :dicharge_date,
            patient_status 	= :patient_status,
			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':icu_date', $icu_date);
        $stmt->bindParam(':admission_date', $admission_date);
        $stmt->bindParam(':dicharge_date', $dicharge_date);
        $stmt->bindParam(':patient_status', $patient_status);

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
});

// API PUT-update patient status
$app->put('/patients/status/{id}', function (Request $request, Response $response, array $args) {
    $name = $request->getParam('name');
    $id = $_GET["id"];
    // $request->getAttribute('id');
    $icu_date = $request->getParam('icu_date');
    $admission_date = $request->getParam('admission_date');
    $dicharge_date = $request->getParam('dicharge_date');
    $patient_status = $request->getParam('patient_status');

    $sql = "UPDATE patients SET
            patient_status 	= :patient_status,
			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':patient_status', $patient_status);

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
});

$app->run();




