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
    echo "still good here: " . $myArray[0];

    // Convert array elements to integers using intval()
    $myArray = array_map('intval', $myArray);
    echo "myArray here: " . $myArray[0];

    // Create a comma-separated string of IDs for the IN clause
    $idList = implode(",", $myArray);
    echo "still good here: " . $idList[0];

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
    }

    // Use the IDs in an SQL SELECT statement
    $sql = "SELECT * FROM `Art` WHERE `ID` IN ('$idList')";
    $result = $conn->query($sql);
    showDetails($result);
} else {
    // Handle JSON decoding error
    http_response_code(400); // Bad Request
    echo "Error decoding JSON data";
}

function showDetails(mysqli_result $result){
    $content = '';
    while ($row = $result->fetch_assoc()) {
        $content .= "<div id=\"details\"><table>" .
            "<tr><td>" . '<img alt="image" src="data:image/jpeg;base64,' . base64_encode($row['Picture']) . '"/>' . "</tr></td>" .
            "<tr><td> ID: " . $row["ID"] . "</td></tr>" .
            "<tr><td> Name: " . $row["Name"] . "</td></tr>" .
            "<tr><td> Date: " . $row["Date"] . "</td></tr>" .
            "<tr><td> Width: " . $row["Width"] . "m </td></tr>" .
            "<tr><td> Height: " . $row["Height"] . "m </td></tr>" .
            "<tr><td> Price: £" . $row["Price"] . "</td></tr>" .
            "<tr><td> Desc: " . $row["Description"] . "</td></tr>" .
            "</table></div>";
    }
    return $content;
}