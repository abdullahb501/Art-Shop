<?php
function safeGET($conn, $name){
    return isset($_GET[$name]) ? $conn->real_escape_string(strip_tags($_GET[$name])) : "";
}

function safePost($conn, $name){
    return isset($_POST[$name]) ? $conn->real_escape_string(strip_tags($_POST[$name])) : "";
}

function getDetails($conn, $id){
    $sql = "SELECT * FROM `Art` WHERE `ID` = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        showDetails($result);
        return true;
    }
    $result->data_seek(0);
    return  false;
}

function markSold($conn, $id){
    $sql = "UPDATE `Art` SET `Sold`='1' WHERE `ID`='$id'";
    $result = $conn->query($sql);
    if($result){
        return true;
    }
    return false;
}

function orderComplete($conn, $name, $phone, $email, $address, $artID){
    $sql = "INSERT INTO `Order` (`ID`,`Name`,`Phone`,`Email`,`Postal_Address`,`ArtID`)
            VALUES (NULL,'$name','$phone','$email','$address','$artID')";
    $result = $conn->query($sql);
    if($result){
        return true;
    }
    return false;
}

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username, $password, $dbname);

$name = filter_var(safePost($conn, "Name"), FILTER_SANITIZE_STRING);
$phone = filter_var(safePost($conn, "Phone"), FILTER_SANITIZE_STRING);
$email = filter_var(safePost($conn, "Email"), FILTER_SANITIZE_EMAIL);
$address = filter_var(safePost($conn, "Address"), FILTER_SANITIZE_STRING);

$initialID = filter_var(safeGET($conn, "artName"), FILTER_SANITIZE_STRING);
$artID = str_replace("Button", "", $initialID);

$artIDField = filter_var(safePost($conn, "artName"), FILTER_SANITIZE_STRING);
if($artIDField && $name && $email && $phone && $address){
    orderComplete($conn, $name, $phone, $email, $address, $artIDField);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexStyle.css">
</head>
<body>
<p class="discount"><strong> 20% Off Orders Over £10 </strong></p>
<h1>Cara's Art Shop</h1>
<br>
<h2>Order Form</h2>

<main id="main">
    <div id="orderForm">
        <form action="order.php" method="post">
            <p><label for="name">Name: </label><input id="name" name="Name" value="<?php echo $name ?>" type="text"></p>
            <p><label for="phone">Phone: </label><input id="phone" name="Phone" value="<?php echo $phone ?>" type="text"></p>
            <p><label for="email">Email: </label><input id="email" name="Email" value="<?php echo $email ?>" type="text"></p>
            <p><label for="address">Address: </label><input id="address" name="Address" value="<?php echo $address ?>" type="text"></p>
            <p><input id="artName" name="artName" value="<?php echo $artID ?>" type="hidden"></p><br>
            <input type="submit">
        </form>
    </div>
    <div id="contentContainerOrder">
        <?php

//        TODO: Make Orders entered into database when submitted with art id
//        TODO: Make multiple order entries when multiple paintings are selected

//        if(markSold($conn,$artID) === true){
//            echo "Painting Sold.";
//        } else {
            if($artID){
                getDetails($conn, $artID);
            } else if($artIDField) {
                getDetails($conn, $artIDField);
            } else {
                getDetails($conn, $artID);
            }
//        }
        ?>
    </div>
</main>
<script>
    function getButtonIdsFromUrl() {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('buttonIds');
    }

    document.addEventListener("DOMContentLoaded", function() {
        let updatedArray = [];
        let buttonIds = getButtonIdsFromUrl();
        if (buttonIds) {
            buttonIds = JSON.parse(decodeURIComponent(buttonIds));
            console.log("Button IDs:", buttonIds);

            updatedArray = buttonIds.map(element => element.replace("Button", ""));
            console.log("Updated array:", updatedArray);
        } else {
            console.log("No button IDs found.");
        }

        let xhr = new XMLHttpRequest();
        let url = "orderArt.php";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server
                document.getElementById('contentContainerOrder').innerHTML = xhr.responseText;






            }
        };
        let data = JSON.stringify({ updatedArray: updatedArray });
        xhr.send(data);
    });

    // TODO: JavaScript Videos Errors Best Practice (Probs do same on admin update and delete)
    let errs = "";
    let name = document.getElementById("name").value;
    let phone = document.getElementById("phone").value;
    let email = document.getElementById("email").value;
    let address = document.getElementById("address").value;
</script>
</body>
</html>