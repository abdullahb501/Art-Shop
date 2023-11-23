<?php
//session_start();
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
    $conn->query($sql);
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
<h1>Cara's Art Shop: Order Form</h1>

<main id="main">
    <div id="orderForm">
        <form action="order.php" method="post">
            <p><label for="name">Name: </label><input id="name" name="Name" value="<?php echo $name ?>" type="text"></p>
            <p><label for="phone">Phone: </label><input id="phone" name="Phone" value="<?php echo $phone ?>" type="text"></p>
            <p><label for="email">Email: </label><input id="email" name="Email" value="<?php echo $email ?>" type="text"></p>
            <p><label for="address">Address: </label><input id="address" name="Address" value="<?php echo $address ?>" type="text"></p>
            <p><input id="artName" name="artName" value="<?php echo $artID ?>" type="hidden"></p>
            <input type="submit">
        </form>
    </div>
    <div class="contentContainerOrder">
        <?php
//        Retrieve and display the ArtID from the query parameter
//        $artID = isset($_GET['buttonID']) ? $_GET['buttonID'] : "";
//        echo "ArtID: " . $artID;

//        $array = array();
//        $i = array_push($array, $artID);
//        $arrayLength = count($array);
//        echo "ArrayLength: $arrayLength <br>";
//        print_r($array);

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

    function getArt(event){
        event.preventDefault();
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "orderArt.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        for(let i = 0; i< updatedArray.length;i++){
            console.log(updatedArray[i]);
            xhr.send("idArt=" + encodeURIComponent(updatedArray[i]));
        }
    }

    let errs = "";
    let name = document.getElementById("name").value;
    let phone = document.getElementById("phone").value;
    let email = document.getElementById("email").value;
    let address = document.getElementById("address").value;
</script>
</body>
</html>