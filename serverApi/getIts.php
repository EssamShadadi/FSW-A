<?php
include "config.php";

// get all IT Specialists 
$stmt = $pdo->prepare("SELECT * FROM ItSpecialists");
if($stmt->execute()){

    $ItSpecialists=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["ItSpecialists"=> $ItSpecialists,"success"=>true]);
}else{
    echo json_encode(["success"=>false,"message"=> "error in fetching IT Specialists"]);

}