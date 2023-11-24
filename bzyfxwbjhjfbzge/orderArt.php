<?php

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the JSON data from the request
$jsonData = file_get_contents("php://input");

// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);

// Check if the decoding was successful
if ($data !== null) {
    // Access the array sent from the client
    $myArray = $data['updatedArray'];

    // Convert array elements to integers using intval()
    $myArray = array_map('intval', $myArray);

    // Initialize the content variable
    $content = '';

    foreach ($myArray as $id) {
        // Use the ID in an SQL SELECT statement
        $sql = "SELECT * FROM `Art` WHERE `ID` = '$id'";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Add the details to the content
            showDetails($result);
        } else {
            // Handle the query error if needed
            $content .= "Error executing query for ID $id<br>";
        }
    }
} else {
    // Handle JSON decoding error
    http_response_code(400);
}

function showDetails(mysqli_result $result){
    while ($row = $result->fetch_assoc()) {
        echo "<div id=\"details\"><table>" .
            "<tr><td>" . '<img alt="image" src="data:image/jpeg;base64,' . base64_encode($row['Picture']) . '"/>' . "</tr></td>" .
            "<tr><td> ID: " . $row["ID"] . "</td></tr>" .
            "<tr><td> Name: " . $row["Name"] . "</td></tr>" .
            "<tr><td> Date: " . $row["Date"] . "</td></tr>" .
            "<tr><td> Width: " . $row["Width"] . "m </td></tr>" .
            "<tr><td> Height: " . $row["Height"] . "m </td></tr>" .
            "<tr><td> Price: £" . $row["Price"] . "</td></tr>" .
            "<tr><td> Desc: " . $row["Description"] . "</td></tr><br>" .
            "</table></div>";
    }
}