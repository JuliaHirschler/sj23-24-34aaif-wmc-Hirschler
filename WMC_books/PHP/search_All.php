<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (isset($_GET["s"])) { //if (isset($_GET["s"]))

  require 'DB_Connect.php';

  // read the value from the key s (param from the URL)
  $search_value = $_GET["s"]; 
  $WhatToSearch = $_GET["WhatToSearch"];

  // 1.Step: Create the select statements
  $select_Generes = "SELECT `ID_Generes`, `Generes` FROM `generes1` WHERE `Generes` Like :search";
  $select_Author = "SELECT `author_ID`, `author_firstName`, `author_LastName`, `author_birthdate`, `Generes`, `author_biography` 
                    FROM `author` 
                    INNER JOIN `generes1` ON `author_generes` = `ID_Generes` WHERE `author_firstName` Like :search OR `author_LastName` Like :search";
  $select_Titles = "SELECT `ID_Title`, `Titles`, CONCAT(`author_firstName`,' ',`author_LastName`) AS `author` , `generes1`.`Generes` FROM `titles1`
                    INNER JOIN `author` ON `Author` = `author_ID` 
                    INNER JOIN `generes1` ON `titles1`.`Generes` = `ID_Generes` WHERE `Titles` Like :search";

switch($WhatToSearch){
    case "generes":
        $select = $select_Generes;
        break;
    case "author":
        $select = $select_Author;
        break;
    case "titles":
        $select = $select_Titles;
        break;
}

  // PROBLEM!!!!
  // $search = '%$search_value%';     // NO RESULT!!!!!
  $search = "%$search_value%";  // $search = "%$search_value%";

  // 2.Step: prepare the statement in the DB
  $result = $conn->prepare($select); //$result = $conn->prepare($select_query);
  $result->bindParam(':search', $search);
  $result->execute();  
  $result->setFetchMode(PDO::FETCH_ASSOC);

  if($result->rowCount() == 0 ){
    echo json_encode(
        array("message" => "Nothing was found with this search parameter: $search!")
    );
  }
  else {
      $rows = $result->fetchAll(); // means that the result will be an associative array
      http_response_code(200);
      echo json_encode($rows);
  };

  $conn = null;

} else {
  http_response_code(404);
		
  echo json_encode(
      array("message" => "page not found")
    );
}
