<?php
session_start();

// SQL Creds
$conn = new mysqli($servername, $username, $password, $dbname);

function safePost($conn, $name){
    return isset($_POST[$name]) ? $conn->real_escape_string(strip_tags($_POST[$name])) : "";
}

// Get the JSON data from the request
$jsonData = file_get_contents("php://input");

// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);

$name = filter_var(safePost($conn, "Name"), FILTER_SANITIZE_STRING);
$phone = filter_var(safePost($conn, "Phone"), FILTER_SANITIZE_STRING);
$email = filter_var(safePost($conn, "Email"), FILTER_SANITIZE_EMAIL);
$address = filter_var(safePost($conn, "Address"), FILTER_SANITIZE_STRING);

// Check if the decoding was successful
if ($data !== null) {
    // Access the array sent from the client
    $myArray = $data['updatedArray'];

    // Convert array elements to integers using intval()
    $myArray = array_map('intval', $myArray);

    foreach ($myArray as $id) {
        $id = intval($id);
        $sql = "SELECT * FROM `Art` WHERE `ID` = '$id'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<div class=\"details\"><table>" .
                "<tr><td>" . '<img alt="image" src="data:image/jpeg;base64,' . base64_encode($row['Picture']) . '"/>' . "</td></tr>" .
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
    foreach ($myArray as $id) {
        $id = intval($id);
        if($id && $name && $phone && $email && $address){
            orderComplete($conn, $name, $phone, $email, $address, $id);
        }
    }
} else {
    // Handle JSON decoding error
    http_response_code(400);
}

function orderComplete($conn, $name, $phone, $email, $address, $id){
    $sql = "INSERT INTO `Order` (`ID`,`Name`,`Phone`,`Email`,`Postal_Address`,`ArtID`)
            VALUES (NULL,'$name','$phone','$email','$address','$id')";
    $conn->query($sql);
}