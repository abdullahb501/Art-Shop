<?php
function safePost($conn,$name){
    return isset($_POST[$name])?$conn->real_escape_string(strip_tags($_POST[$name])):"";
}

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username,$password, $dbname);

function passForm(){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Password</title>
        <link rel="stylesheet" type="text/css" href="adminStyle.css">
    </head>
    <body>
        <form action="admin.php" method="post">
            <label for="pass"></label><input id="pass" name="pass" type="password">
            <input type="submit">
        </form>
    </body>
    </html>
    <?php
}
$pass = safePost($conn,"pass");
//WeKnowTheGame23
if($pass === ""){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="adminStyle.css">
    </head>
    <body>
    <h1>Admin</h1>

    <div id = "Status">
    <?php
    $id = safePost($conn,"idUpdate");
    $name = safePost($conn,"Name");
    $date = safePost($conn,"Date");
    $width = (float)safePost($conn,"Width");
    $height = (float)safePost($conn,"Height");
    $price = (float)safePost($conn,"Price");
    $desc = safePost($conn,"Desc");
    $idDel = (int)safePost($conn, "idDelete");

    if($id){
        //https://www.w3schools.com/php/php_mysql_update.asp
        $sql = "UPDATE Art SET `Name`='$name',`Date`='$date',`Width`='$width',
                           `Height`='$height',`Price`='$price',`Description`='$desc' WHERE `ID`='$id'";
        $result = $conn->query($sql);

        if ($conn->query($sql) === TRUE) {
            echo "<div id = 'updateArtSuccess'>Art ID: " . $id . " was updated successfully!</div>";
        } else {
            echo "<div class = 'updateArtFail'>Error: Field is blank, invalid or the id does not exist.</div>";
//            echo "<p class = 'updateArtFail'>Error updating record: " . $conn->error . "</p>";
        }
    } else {
        echo "<div class = 'noStatus'>No Art Updated.</div>";
    }


    if($idDel) {
        $sql = "DELETE FROM `Order` WHERE `ID` = '$idDel'";
        $result = $conn->query($sql);
        if ($conn->query($sql) === TRUE) {
            echo "<div id = 'updateOrderSuccess'>Order ID: " . $id . " was deleted successfully!</div>";
        } else {
            echo "<div class = 'updateOrderFail'>Error: Field is blank, invalid or the id does not exist.</div>";
//            echo "<p class = 'updateOrderFail'>Error updating record: " . $conn->error . "</p>";
        }
    } else {
        echo "<div class = 'noStatus'>No Orders Deleted.</div>";
    }
    ?>
    </div>
    <h2>All Orders</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Postal_Address</th>
        </tr>
        <?php
        $sql = "SELECT * FROM `Order`";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>" .
                    "<td>" . $row["ID"] . "</td>" .
                    "<td>" . $row["Name"] . "</td>" .
                    "<td>" . $row["Phone"] . "</td>" .
                    "<td>" . $row["Email"] . "</td>" .
                    "<td>" . $row["Postal_Address"] . "</td>" .
                    "</tr>";
            }
        } else {
            die ("No matches");
        }
        ?>
    </table>
    <h2>Update Art</h2>
    <form action="admin.php" method="post">
        <p><label for="idUpdate">ID:      </label><input id="idUpdate" name="idUpdate" type = text></p>
        <p><label for="Name">Name:        </label><input id="Name" name="Name" type = text></p>
        <p><label for="Date">Date:        </label><input id="Date" name="Date" type = text></p>
        <p><label for="Width">Width:      </label><input id="Width" name="Width" type = text></p>
        <p><label for="Height">Height:    </label><input id="Height" name="Height" type = text></p>
        <p><label for="Price">Price:      </label><input id="Price" name="Price" type = text></p>
        <p><label for="Desc">Description: </label><input id="Desc" name="Desc" type = text></p>
        <p><input type="submit">
    </form>

    <h2>Delete Orders</h2>
    <form action="admin.php" method="post">
        <p><label for="idDelete">ID To Delete: </label><input id="idDelete" name="idDelete" type = text></p>
        <input type="submit">
    </form>
    </body>
    </html>
    <?php
} else {
    passForm();
}

