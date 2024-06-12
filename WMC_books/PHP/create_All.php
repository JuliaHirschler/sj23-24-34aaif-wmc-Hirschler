<?php
// required headers
header("Access-Control-Allow-Origin: *");

require 'DB_Connect.php';
// Wir brauchen ein feld um was es sich handelt entweder author generes titles - Feld 1 - n, wenn nichts mehr vorhanden ist dann null setzten
$F1 = $F2 = $F3 = $F4 = $F5 = null;

$database = new Database();
$conn = $database->connect();

if ($conn === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit;
}

// Print received POST data for debugging
echo json_encode($_POST);


if (isset($_POST)) {
    //$WhatToCreate = hidden!
    $WhatToCreate = $_POST["WhatToCreate"]; // Das Feld muss auch WhatToCreate in jedem Formular übergeben werden, hier stehen die möglich erlaubten Werte drinnen.

    // Author
    if(isset($_POST["author_FirstName"])){
        $F1 = $_POST["author_FirstName"];
    }
    if(isset($_POST["author_LastName"])) {
        $F2 = $_POST["author_LastName"];
    }
    if(isset($_POST["author_birthdate"])){
        $F3 = $_POST["author_birthdate"];
    }
    if(isset($_POST["author_generes"])){
        $F4 = $_POST["author_generes"];
    }
    if(isset($_POST["author_biography"])){
        $F5 = $_POST["author_biography"];
    }
    //Generes
    if(isset($_POST["Generes"])){
        $F1 = $_POST["Generes"];
    }
    //Titles
    if(isset($_POST["Titles"])){
        $F1 = $_POST["Titles"];
    }
    if(isset($_POST["Author"])){
        $F2 = $_POST["Author"];
    }
    if(isset($_POST["titles_Generes"])){
        $F3 = $_POST["titles_Generes"];
    }

    // echo "interpret: $interpret, title: $title";
    // $insert = "INSERT INTO playlist (interpret, title, genre)
    // 						VALUES ('$interpret', '$title', $genre)";

    $into_author = 'author (author_firstName, author_LastName, author_birthdate, author_generes, author_biography)';
    $values_author = '(:F1, :F2, :F3, :F4, :F5)';

    $into_generes = 'generes1 (Generes)';
    $values_generes = '(:F1)';

    $into_titles = 'titles1 (Titles, Author, Generes)';
    $values_titles = '(:F1, :F2, :F3)';

    switch($WhatToCreate){ // die varibalen müssen drüben genau die selben varbiablen haben
        case "author":
            $into = $into_author;
            $values = $values_author;
            break;
        case "generes":
            $into = $into_generes;
            $values = $values_generes;
            break;
        case "titles":
            $into = $into_titles;
            $values = $values_titles;
            break;
    }

    $insert = "INSERT INTO $into
                VALUES $values";
    // look if statement works, copy the statement from the browser to the database script
    // echo $insert;
    // send the insert to the database
    try {
        // $result = $conn->query($insert);		// true if it works, false if not
        $result = $conn->prepare($insert);		// send the statement to the db (without values from user!!!)

        // bind the values to the placehoder (param)
        $result->bindParam(':F1', $F1);
        if($F2 != null){
            $result->bindParam(':F2', $F2);
        }
        if($F3 != null){
            $result->bindParam(':F3', $F3);
        }
        if($F4 != null){
            $result->bindParam(':F4', $F4);
        }
        if($F5 != null){
            $result->bindParam(':F5', $F5);
        }
        // $result->debugDumpParams();

        // execute the statement on the database
        $result->execute();

        // close the db connection
        $conn = null;
    } catch (PDOException $e) {
        http_response_code(500);		// 5xx ---> Error on the server side!!!!

        // response with json
        // echo json_encode(
        // 	array("message" => "Something went wrong:" . $e->getMessage())
        // );
        echo json_encode(
            array("message" => "Something went wrong:" . $e->getMessage())
        );
    }


    if ($result) {
        http_response_code(201);		// 200 -> OK, 201 -> Created

        // response with json
        echo json_encode(
            array("message" => "Created")
        );
    }
} else {
    // set response code - 403  -Forbidden
    http_response_code(403);

    // tell the user error
    echo json_encode(
        array("message" => "No action")
    );
}
