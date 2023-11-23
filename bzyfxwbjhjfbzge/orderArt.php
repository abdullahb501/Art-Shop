<?php

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username, $password, $dbname);


$dataArray = json_decode($_POST['idArt']);
$cleanedDataArray = array_map(function ($item) use ($conn) {
    return $conn->real_escape_string($item);
}, $dataArray);

$sql = "SELECT * FROM `Art` WHERE `ID` IN ('" . implode("','", $cleanedDataArray) . "')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<div id =\"details\"><table>" .
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
$result->data_seek(0);
