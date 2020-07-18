<?php


require 'db.php';

// $id = $request->getAttribute('singleuserid');
// $id='222';
$username= $_GET["username"];
$sql = "SELECT * FROM user WHERE username = $username";

try{
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($user);
} catch(PDOException $e){
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}

//end of lesson 2
?>