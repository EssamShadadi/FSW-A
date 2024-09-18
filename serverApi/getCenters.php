<?php
include "config.php";

// get all centers 
$stmt = $pdo->prepare("SELECT * FROM centers");
if($stmt->execute()){

    $centers=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["centers"=> $centers,"success"=>true]);
}else{
    echo json_encode(["success"=>false,"message"=> "error in fetching centers"]);

}