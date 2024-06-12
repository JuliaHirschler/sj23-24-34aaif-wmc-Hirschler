<?php
// required headers
require 'DB_Connect.php';
$database = new Database();
$conn = $database->connect();

header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
if (isset($_GET["id"])) {

	require 'DB_Connect.php';

	$id = $_GET['id'];
    $WhatToDelete = $_GET["WhatToDelete"]; // Muss auch drüben verwendet werden!!!!
	// 1.step without prepared statement
	// $delete_stmt = "delete from playlist where id = $id";
    $table = "titles1";
    $column = "ID_Title";
    if($WhatToDelete == "generes"){
        $select1 = "SELECT *
                    From `author` WHERE `author_generes` = :id";
        $select2 = "SELECT *
                    FROM `titles1` WHERE 'Generes' = :id";
        $result1 = $conn->prepare($select1);
        $result2 = $conn->prepare($select2);
        $result1->bindParam(':id', $id);
        $result2->bindParam(':id', $id);
        $result1->execute();
        $result2->execute();
        if($result1->rowCount() > 0 || $result2->rowCount() > 0){
            echo json_encode(
                array("message" => "Delete id $id in generes failed, bc it is used!")
            );
            exit;
        }
        $table = "generes1";
        $column = "ID_Generes";
    }

    if($WhatToDelete == "author"){
        $select = "SELECT * FROM `titles1` WHERE Author = :id";   
        $result = $conn->prepare($select);
        $result->bindParam(':id', $id);
        $result->execute();
        if($result->rowCount() > 0 ){
            echo json_encode(
                array("message" => "Delete id $id in author failed, bc it is used in titles!")
            );
            exit;
        }
        $table = "author";
        $column = "author_ID";
    }


    $delete_stmt = "delete from $table where $column = :id";
	// bind param
    $result = $conn->prepare($delete_stmt);
	$result->bindParam(':id', $id);
	$result->execute();

	if($result) {
		echo json_encode(
			array("message" => "Deleted id $id")
		);
	} else 
    {
		echo json_encode(
			array("message" => "Delete id $id failed!")
		);
	}
	
} else {
	echo json_encode(
		array("message" => "No action")
	);
}
