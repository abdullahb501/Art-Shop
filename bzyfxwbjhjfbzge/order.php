<?php

function safePost($conn, $name){
    return isset($_POST[$name])?$conn->real_escape_string(strip_tags($_POST[$name])):"";
}

function getDetails($conn, $name){
    $sql = "SELECT * FROM `Art` WHERE `name` = '$name'";
    $result = $conn->query($sql);
    $result->data_seek(0);
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {

            echo "<div id =\"details\"><tr>" .
                "<td><br> ID: " . $row["ID"] . "<br></td>" .
                "<td> Name:   " . $row["Name"] . "<br></td>" .
                "<td> Date:   " . $row["Date"] . "<br></td>" .
                "<td> Width:  " . $row["Width"] . "m <br></td>" .
                "<td> Height: " . $row["Height"] . "m <br></td>" .
                "<td> Price: £" . $row["Price"] . "<br></td>" .
                "<td> Desc: " . $row["Description"] . "<br></td>" .
                "</tr></div>";
        }
    }
}

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username,$password, $dbname);

$name = safePost($conn,"name");
$phone = safePost($conn,"phone");
$email = safePost($conn,"email");
$address = safePost($conn,"address");
?>
<html lang="en">
<head>
    <title>Order Form</title>
    <link rel="stylesheet" href="indexStyle.css">
</head>
<body>
<p id ="discount"><strong>20% Off Orders Over £10<strong></p>
<h1>Cara's Art Shop: Order Form</h1>

<form action="order.php" method="get">
    <p><label for="name">Name: </label><input id="name" name="Name" value="<?php echo $name?>" type="text"></p>
    <p><label for="phone">Phone: </label><input id="phone" name="Phone" value="<?php echo $phone?>" type="text"></p>
    <p><label for="email">Email: </label><input id="email" name="Email" value="<?php echo $email?>" type="text"></p>
    <p><label for="address">Address: </label><input id="address" name="Address" value="<?php echo $address?>" type="text"></p>
    <input type="submit">
    <?php
//    echo "A1: " . $artHouse . "<br>";
//    echo "A2: " . $artHouse1 . "<br>";
//    echo "A3: " . $artHouse2 . "<br>";

//    if($artHouse === "houseButton"){
//        getDetails($conn,"house");
//        echo "HOUSE";
//    } else if($artHouse === "candyButton"){
//        getDetails($conn,"candy");
//        echo "Candy";
//    } else if($artHouse === "fishButton"){
//        getDetails($conn,"fish");
//        echo "FISH";
//    }
    ?>
</form>
</body>
</html>
<?php
