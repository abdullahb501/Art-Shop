<?php
function safePost($conn,$name){
    return isset($_POST[$name])?$conn->real_escape_string(strip_tags($_POST[$name])):"";
}

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username,$password, $dbname);

function getOrder($conn){
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
       echo "Sorry, there are no orders to display right now.";
    }
    $result->data_seek(0);
}

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
    <h2>Admin Login</h2>
    <form action="admin.php" method="post">
        <p><label style="padding: 0" for="pass"></label><input id="pass" name="pass" type="password"></p>
        <br>
        <p><label style="padding: 0" for="submit"></label><input id="submit" type="submit"></p>
    </form>
    </body>
    </html>
    <?php
}

//WeKnowTheGame23
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pass'])) {
        $pass = safePost($conn, "pass");
        if ($pass === "WeKnowTheGame23") {
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
                getOrder($conn);
                ?>
            </table>
            <h2>Update Art</h2>
            <form method="post" enctype="multipart/form-data">
                <p><label for="idUpdate">ID:      </label><input id="idUpdate" name="idUpdate" type = text></p>
                <p><label for="Name">Name:        </label><input id="Name" name="Name" type = text></p>
                <p><label for="Date">Date:        </label><input id="Date" name="Date" type = text></p>
                <p><label for="Width">Width:      </label><input id="Width" name="Width" type = text></p>
                <p><label for="Height">Height:    </label><input id="Height" name="Height" type = text></p>
                <p><label for="Price">Price:      </label><input id="Price" name="Price" type = text></p>
                <p><label for="Desc">Description: </label><input id="Desc" name="Desc" type = text></p>
                <p><label for="Sold">Sold (0 for no, 1 for Yes): </label><input id="Sold" name="Sold" type = text></p>
                <input type="file" name="uploadFile" id="uploadFile">
                <p><input id="updateArt" name="uploadFile" type="submit">
            </form>

            <h2>Delete Orders</h2>
            <form method="post">
                <p><label for="idDelete">ID To Delete: </label><input id="idDelete" name="idDelete" type = text></p>
                <input id = "delOrder" type="submit">
            </form>

            <script>
                document.getElementById("updateArt").addEventListener("click",updateArt);
                document.getElementById("delOrder").addEventListener("click",delOrder);

                function updateArt(event){
                    event.preventDefault();
                    const form = document.forms[0];
                    const formData = new FormData(form);
                    formData.append('uploadFile', form.querySelector('#uploadFile').files[0]);

                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "adminSQL.php", true);
                    xhr.setRequestHeader("enctype", "multipart/form-data"); // Set the content type for file uploads
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log(xhr.responseText);
                        }
                    };
                    xhr.send(formData);
                }

                function delOrder(event){
                    event.preventDefault();
                    const idDel = document.getElementById("idDelete").value;
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "adminSQL.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log(xhr.responseText);
                        }
                    };
                    xhr.send("idDel=" + encodeURIComponent(idDel));
                }
            </script>
            </body>
            </html>
            <?php
        } else {
            passForm();
        }
    }
} else {
    passForm();
}
