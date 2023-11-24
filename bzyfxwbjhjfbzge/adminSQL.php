
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
$sold = isset($_POST["Sold"]) ? $_POST["Sold"] : 0;
//$file = isset($_FILES["uploadFile"]) ? $_FILES["uploadFile"] : "";

if (isset($_FILES["uploadFile"]) && $_FILES["uploadFile"]["error"] == 0) {
    // Get the file information
    $check = getimagesize($_FILES["uploadFile"]["tmp_name"]);
    if($check !== false) {
        $image = $_FILES['uploadFile']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $sql = "UPDATE `Art` SET `Name` = '$name',`Date` = '$date',`Width` = '$width',
                 `Height` = '$height',`Price` = '$width',`Description` = '$height',
                 `Picture` = '$imgContent',`Sold` = '$sold' WHERE `ID` = '$idUpdate'";
        $result = $conn->query($sql);
        if($result){
            echo "good";
        } else {
            echo "bad";
        }
    }
} else {
    echo "Please select a valid image file.";
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
