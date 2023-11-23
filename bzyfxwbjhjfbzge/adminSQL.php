
<?php
REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username, $password, $dbname);

$idUpdate = isset($_POST["idUpdate"]) ? $_POST["idUpdate"] : "";
$name = isset($_POST["Name"]) ? $_POST["Name"] : "";
$date = isset($_POST["Date"]) ? $_POST["Date"] : "";
$width = isset($_POST["Width"]) ? $_POST["Width"] : 0;
$height = isset($_POST["Height"]) ? $_POST["Height"] : 0;
$price = isset($_POST["Price"]) ? $_POST["Price"] : 0;
$desc = isset($_POST["Desc"]) ? $_POST["Desc"] : "";
$file = isset($_FILES["uploadFile"]) ? $_FILES["uploadFile"] : "";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

function checkRealFile(){
    if (!isset($_FILES["uploadFile"])) {
        echo "File key not found in \$_FILES array.\n";
        return 0;
    }

    $check = getimagesize($_FILES["uploadFile"]["tmp_name"]);

    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".\n";
        return 1;
    } else {
        echo "File is not an image.\n";
        return 0;
    }
}

function checkExists($target_file){
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.\n";
        return 0;
    }
    return 1;
}

function checkSize(){
    if ($_FILES["uploadFile"]["size"] > 500000) {
        echo "Sorry, your file is too large.\n";
        return 0;
    }
    return 1;
}

function checkType($imageFileType){
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n";
        return 0;
    }
    return 1;
}

if (checkRealFile() === 1 && checkExists($target_file) === 1 && checkSize() === 1 && checkType($imageFileType) === 1) {
    $imageData = file_get_contents($_FILES["uploadFile"]["tmp_name"]);

    $sql = "UPDATE `Art` SET `Name`=?, `Date`=?, `Width`=?, `Height`=?, `Price`=?, `Description`=?, `Picture`=? WHERE `ID`=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssiiisbi', $name, $date, $width, $height, $price, $desc, $imageData, $idUpdate);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "The file " . htmlspecialchars(basename($_FILES["uploadFile"]["name"])) . " has been uploaded and saved to the database.\n";
        } else {
            echo "No changes were made to the database.\n";
        }
    } else {
        echo "Sorry, there was an error uploading your file.\n";
    }
    $stmt->close();
} else {
    echo "Sorry, your file was not uploaded.";
}
$conn->close();

$conn = new mysqli($servername, $username, $password, $dbname);
$idDel = isset($_POST["idDel"]) ? $_POST["idDel"] : "";

if ($idDel) {
    $sql = "DELETE FROM `Order` WHERE `ID` = '$idDel'";
    if ($conn->query($sql) === TRUE) {
        echo "Order ID: " . $idDel . " was deleted successfully!\n";
    } else {
        echo "Error: Field is blank, invalid, or the ID does not exist.\n";
    }
} else {
    echo "No Orders Deleted.\n";
}

$conn->close();
