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
    $sql = "SELECT * FROM `Order`";
    $result1 = $conn->query($sql);
    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            echo "<p>" . $row["ID"] .
                " " . $row["Name"] .
                " " . $row["Phone"] .
                " " . $row["Email"] .
                " " . $row["Postal_Address"] . "</p>\n";
        }
    } else {
        die ("No matches");
    }
    $conn->close();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <style>
            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
    <h1>Admin</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Postal_Address</th>
        </tr>
    </table>
    </body>
    </html>
    <?php
} else {
    passForm();
}

