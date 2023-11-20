<?php

function safeGET($conn, $name){
    return isset($_GET[$name])?$conn->real_escape_string(strip_tags($_GET[$name])):"";
}

function safePost($conn, $name){
    return isset($_POST[$name])?$conn->real_escape_string(strip_tags($_POST[$name])):"";
}

function getDetails($conn, $name){
    $sql = "SELECT * FROM `Art` WHERE `name` = '$name'";
    $result = $conn->query($sql);
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div id =\"details\"><table>" .
//                https://stackoverflow.com/questions/20556773/php-display-image-blob-from-mysql
                "<tr><td>" . '<img alt="image" src="data:image/jpeg;base64,'.base64_encode($row['Picture']).'"/>' . "</tr></td>" .
                "<tr><td> ID: " . $row["ID"] . "</tr></td>" .
                "<tr><td> Name: " . $row["Name"] . "</tr></td>" .
                "<tr><td> Date: " . $row["Date"] . "</tr></td>" .
                "<tr><td> Width: " . $row["Width"] . "m </tr></td>" .
                "<tr><td> Height: " . $row["Height"] . "m </tr></td>" .
                "<tr><td> Price: £" . $row["Price"] . "</tr></td>" .
                "<tr><td> Desc: " . $row["Description"] . "</tr></td>" .
                "</table></div>";
        }
    }
    $result->data_seek(0);
}

function getArtID($conn, $name){
    $sql = "SELECT * FROM `Art` WHERE `name` = '$name'";
    $result = $conn->query($sql);
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
           if($row["Name"] === $name){
               return $row["ID"];
           }
        }
    }
    $result->data_seek(0);
    return 0;
}

function orderComplete($conn,$name,$phone,$email,$address,$artID){
    $sql = "INSERT INTO `Order` (`ID`,`Name`,`Phone`,`Email`,`Postal_Address`,`ArtID`)
            VALUES (NULL,'$name','$phone','$email','$address','$artID')";
    $result = $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        echo "inserted new entry with id ".$conn->insert_id;
    } else {
        die ("Error: " . $sql . "<br>" . $conn->error);//FIXME only use during debugging
    }
    $result->data_seek(0);
}

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username,$password, $dbname);

$name = safePost($conn,"Name");
$phone = safePost($conn,"Phone");
$email = safePost($conn,"Email");
$address = safePost($conn,"Address");
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
<p class = "discount"><strong> 20% Off Orders Over £10 </strong></p>
<h1>Cara's Art Shop: Order Form</h1>

<main id ="main">
<div id = "orderForm">
<form action="order.php" method="post">
    <p><label for="name">Name: </label><input id="name" name="Name" value="<?php echo $name?>" type="text"></p>
    <p><label for="phone">Phone: </label><input id="phone" name="Phone" value="<?php echo $phone?>" type="text"></p>
    <p><label for="email">Email: </label><input id="email" name="Email" value="<?php echo $email?>" type="text"></p>
    <p><label for="address">Address: </label><input id="address" name="Address" value="<?php echo $address?>" type="text"></p>
    <input type="submit">
</form>
</div>
<?php
$initialName = safeGET($conn,"artName");
$artName = str_replace("Button","",$initialName);
echo "artName: " . $artName . "<br>";

//$initialArray = array("");
//$array = array_push($initialArray,$properID);
//echo "Array0 - " . $array[0] . "\n";
//echo "Array1 - " . $array[1] . "\n";
//echo "Array2 - " . $array[2] . "\n";

$artID = getArtID($conn,$artName);
echo "ID: " . $artID . "<br>";
if($conn && $name && $phone && $email && $address && $artID){
    orderComplete($conn,$name,$phone,$email,$address,$artID);
}
?>
<div class="contentContainerOrder">
    <?php
    getDetails($conn,$artName);
    ?>
</div>
</main>
</body>
</html>
<?php
