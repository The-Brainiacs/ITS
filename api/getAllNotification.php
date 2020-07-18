
<?php

require 'db.php';

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

//end of lesson 2
?>

