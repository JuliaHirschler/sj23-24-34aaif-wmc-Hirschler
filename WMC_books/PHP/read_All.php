<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'DB_Connect.php';
$database = new Database();
$conn = $database->connect();
// include the DB_Connect.php file

// Check if the "WhatToSelect" parameter is set in the GET request
if (isset($_GET["WhatToSelect"])) {

    $WhatToSelect = $_GET["WhatToSelect"];
    // Log the received value for debugging
    error_log("WhatToSelect: " . $WhatToSelect);

    // Define SQL queries for different selections
    $select_Generes = "SELECT `ID_Generes`, `Generes` FROM `generes1`";
    $select_Author = "SELECT `author_ID`, `author_firstName`, `author_LastName`, `author_birthdate`, `Generes`, `ID_Generes`, `author_biography` 
                      FROM `author` 
                      INNER JOIN `generes1` ON `author_generes` = `ID_Generes`";
    $select_Titles = "SELECT `ID_Title`, `Titles`, CONCAT(`author_firstName`, ' ', `author_LastName`) AS `author`, `author_ID`, `generes1`.`Generes`, `ID_Generes` 
                      FROM `titles1`
                      INNER JOIN `author` ON `Author` = `author_ID`
                      INNER JOIN `generes1` ON `titles1`.`Generes` = `ID_Generes`";

    // Determine which query to use based on the "WhatToSelect" parameter
    switch($WhatToSelect) {
        case "generes1":
            $select = $select_Generes;
            break;
        case "author":
            $select = $select_Author;
            break;
        case "titles1":
            $select = $select_Titles;
            break;
        default:
            // If "WhatToSelect" has an invalid value, send a 400 Bad Request response
            http_response_code(400);
            echo json_encode(array("message" => "Invalid selection."));
            exit;
    }

    // Execute the query
    $result = $conn->query($select);

    // Fetch all rows as an associative array
    $all_rows = [];
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $all_rows[] = $row;
    }

    // Convert the array to JSON and send it back as the response
    echo json_encode($all_rows);

    // Set the HTTP status code to 200 OK
    http_response_code(200);

} else {
    // If "WhatToSelect" is not set, send a 400 Bad Request response
    http_response_code(400);
    echo json_encode(array("message" => "WhatToSelect parameter is missing."));
}

// Close the database connection
$conn = null;
?>
