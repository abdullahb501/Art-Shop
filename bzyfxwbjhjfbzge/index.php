<?php
function safePost($conn,$name){
    return isset($_POST[$name])?$conn->real_escape_string(strip_tags($_POST[$name])):"";
}

REMOVED
REMOVED
REMOVED
REMOVED
$conn = new mysqli($servername, $username,$password, $dbname);

function storeDetails($conn){
    $array = array();
    $sql = "SELECT Name FROM `Art`";
    $result = $conn->query($sql);
    $result->data_seek(0);
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
           $array[] = $row["Name"];
        }
    }
    return $array;
}

function getDetails($conn, $name){
    $sql = "SELECT * FROM `Art` WHERE `name` = '$name'";
    $result = $conn->query($sql);
    $result->data_seek(0);
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {

            echo "<div id =\"details\"><tr>" .
//                https://stackoverflow.com/questions/20556773/php-display-image-blob-from-mysql
                "<td><br>" . '<img alt="image" src="data:image/jpeg;base64,'.base64_encode($row['Picture']).'"/>' . "<br></td>" .
                "<td><br> ID: " . $row["ID"] . "<br></td>" .
                "<td> Name: " . $row["Name"] . "<br></td>" .
                "<td> Date: " . $row["Date"] . "<br></td>" .
                "<td> Width: " . $row["Width"] . "m <br></td>" .
                "<td> Height: " . $row["Height"] . "m <br></td>" .
                "<td> Price: £" . $row["Price"] . "<br></td>" .
                "<td> Desc: " . $row["Description"] . "<br></td>" .
                "</tr></div>";
        }
    }
}

function content($conn,$a,$count){
    ?>
    <div class = "contentContainer">
        <?php getDetails($conn,$a[$count]); ?>
        <p><button id= "<?php echo $a[$count]."Button" ?>" name = "<?php echo $a[$count]."Button" ?>" onclick="orderForm()">Click</button></p>
    </div>
<?php
    echo $count;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cara's Art Shop</title>
    <link rel="stylesheet" type="text/css" href="indexStyle.css">
</head>
<body>
<p id = "discount"><strong> 15% Off Orders Over £30 </strong></p>
<h1>Cara's Art Shop</h1>

<div id = "navbar">
    <a href="#">About Us</a>
    <a href="#">Home</a>
    <a href="#">Our Mission</a>
    <a href="#">Careers</a>
    <a href="#">Suppliers</a>
</div>

<p>Hello and welcome to my website! Below are my products for sale.</p>

<?php $a = storeDetails($conn);
$count = 0;
$max = 0;

$sql = "SELECT ID FROM `Art`";
$result = $conn->query($sql);
$result->data_seek(0);
if ($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
        $max += 1;
    }
}

for ($i=0;$i<$max;$i++){
    content($conn,$a,$count);
    $count++;
}
?>
<script>
    function orderForm() {
        window.location.href = "order.php";
        if("Button" in <?php echo $a[$count]."Button"?>){
            document.getElementById(<?php echo $a[$count]."Button"?>).addEventListener("click", sendName)
        }
    }

    function sendName(){
        if("Button" in document.getElementById(<?php echo $a[$count]."Button"?>)){
            // TODO: Make AJAX REQUEST TO SEND Name to other page probably
<!--            --><?php //$artHouse = safePost($conn,$a[$count])  ?>
        }
    }
</script>
</body>
</html>

