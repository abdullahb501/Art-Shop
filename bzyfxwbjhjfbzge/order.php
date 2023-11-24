<?php

function getDetails($conn, $id){
    $sql = "SELECT * FROM `Art` WHERE `ID` = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
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

function safeGET($conn, $name){
    return isset($_GET[$name]) ? $conn->real_escape_string(strip_tags($_GET[$name])) : "";
}

function safePost($conn, $name){
    return isset($_POST[$name]) ? $conn->real_escape_string(strip_tags($_POST[$name])) : "";
}

$initialID = filter_var(safeGET($conn, "singleArt"), FILTER_SANITIZE_STRING);
$artID = str_replace("SingleButton", "", $initialID);

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
        <form id = "buyArt" action="order.php" method="post" onsubmit="return checkOrderForm()">
            <p><label for="name">Name: </label><input id="name" name="Name" type="text"></p>
            <p><label for="phone">Phone: </label><input id="phone" name="Phone" type="text"></p>
            <p><label for="email">Email: </label><input id="email" name="Email" type="text"></p>
            <p><label for="address">Address: </label><input id="address" name="Address" type="text"></p>
            <p><input id="artName" name="artName" value="<?php echo $artID ?>" type="hidden"></p><br>
            <input id = "insertData" type="submit">
        </form>
    </div>
    <div id="contentContainerOrder">
        <?php

//        TODO: Make Orders entered into database when submitted with art id
//        TODO: Make multiple order entries when multiple paintings are selected
//        $singleArt = filter_var(safeGET($conn, "singleArt"), FILTER_SANITIZE_STRING);
//        $artID = str_replace("SingleButton", "", $singleArt);
        getDetails($conn, $artID);
//
//        $name = isset($_POST["name"]) ? $_POST["name"] : "";
//        $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
//        $email = isset($_POST["email"]) ? $_POST["email"] : "";
//        $address = isset($_POST["address"]) ? $_POST["address"] : "";
//        $artID = $singleArt;
//
//        if($name && $artID){
//            $sql = "INSERT INTO `Order` (`ID`,`Name`,`Phone`,`Email`,`Postal_Address`,`ArtID`)
//            VALUES (NULL,'$name','$phone','$email','$address','$artID')";
//            $conn->query($sql);
//        }
        ?>
    </div>
</main>
<script>
    document.getElementById("insertData").addEventListener("click",insertData);
    function insertData() {
        const name = document.getElementById("name").value;
        const phone = document.getElementById("phone").value;
        const email = document.getElementById("email").value;
        const address = document.getElementById("address").value;
        if (document.getElementById("artName").value !== "") {
            const artID = document.getElementById("artName").value;
            console.log("artName: " + artID);
            let xhr = new XMLHttpRequest();
            let url = "orderArt.php";

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    } else {
                        console.error("Error:", xhr.status, xhr.statusText);
                    }
                }
            };

            // Create the data string for the request body
            let data = "name=" + encodeURIComponent(name) +
                        "&phone=" + encodeURIComponent(phone) +
                        "&email=" + encodeURIComponent(email) +
                        "&address=" + encodeURIComponent(address) +
                        "&artID=" + encodeURIComponent(artID);
            xhr.send(data);

            console.log("Name: " + name);
            console.log("Phone: " + phone);
            console.log("Email: " + email);
            console.log("Address: " + address);
            console.log("artID: " + artID);
        } else {
            let xhr = new XMLHttpRequest();
            let url = "orderArt.php";

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    } else {
                        console.error("Error:", xhr.status, xhr.statusText);
                    }
                }
            };

            // Create the data string for the request body
            let data = "name=" + encodeURIComponent(name) +
                "&phone=" + encodeURIComponent(phone) +
                "&email=" + encodeURIComponent(email) +
                "&address=" + encodeURIComponent(address);
            xhr.send(data);

            console.log("Name: " + name);
            console.log("Phone: " + phone);
            console.log("Email: " + email);
            console.log("Address: " + address);
        }
    }

    function getButtonIdsFromUrl() {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('buttonIds');
    }

    document.addEventListener("DOMContentLoaded", function() {
        let updatedArray = [];
        if(getButtonIdsFromUrl() === null){
            console.log("No Art or single Art")
        } else {
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
        }
    });

    function checkOrderForm(){
        let errs = "";
        let name = document.getElementById("name").value;
        let phone = document.getElementById("phone").value;
        let email = document.getElementById("email").value;
        let address = document.getElementById("address").value;

        if(name === ""){
            errs += "- Please Enter Your Name.\n";
        }
        if(phone === ""){
            errs += "- Please Enter Your Phone Number.\n";
        }
        if(email === ""){
            errs += "- Please Enter Your Email.\n";
        }
        if(address === ""){
            errs += "- Please Enter Your Address.\n";
        }

        if(errs !== ""){
            window.alert(errs);
        }
        return (errs==="");
    }










</script>
</body>
</html>