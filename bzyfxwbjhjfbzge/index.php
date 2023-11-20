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
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class =\"details\"><table>" .
//                https://stackoverflow.com/questions/20556773/php-display-image-blob-from-mysql
                "<tr><td>" . '<img alt="image" src="data:image/jpeg;base64,'.base64_encode($row['Picture']).'">' . "</td></tr>" .
                "<tr><td> ID: " . $row["ID"] . "</td></tr>" .
                "<tr><td> Name: " . $row["Name"] . "</td></tr>" .
                "<tr><td> Date: " . $row["Date"] . "</td></tr>" .
                "<tr><td> Width: " . $row["Width"] . "m </td></tr>" .
                "<tr><td> Height: " . $row["Height"] . "m </td></tr>" .
                "<tr><td> Price: £" . $row["Price"] . "</td></tr>" .
                "<tr><td> Desc: " . $row["Description"] . "</td></tr>" .
                "</table></div>";
        }
    }
    $result->data_seek(0);
}
function content($conn,$a,$count){
    ?>
    <div class = "contentContainer">
        <?php
        getDetails($conn,$a[$count]);
        ?>
        <p><button id= "<?php echo $a[$count]."Button" ?>" name = "<?php echo $a[$count]."Button" ?>" onclick="orderForm('<?php echo $a[$count]."Button" ?>')">Click</button></p>
    </div>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cara's Art Shop</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="indexStyle.css">
</head>
<body>
<p class = "discount"><strong> 15% Off Orders Over £30 </strong></p>
<h1>Cara's Art Shop</h1>

<div id = "navbar">
    <a href="#">About Us</a>
    <a href="#">Home</a>
    <a href="#">Our Mission</a>
    <a href="#">Careers</a>
    <a href="#">Suppliers</a>
    <a id="basket-link" href="order.php">Basket</a>
</div>

<p>Hello and welcome to my website! Below are my products for sale.</p>
<div id = "sectionButtons">
    <div id="prevButton"><button name="prevButton" onclick="prevB()">&lt;&lt; Previous</button></div>
    <div id="nextButton"><button name="nextButton" onclick="nextB()">Next &gt;&gt;</button></div>
</div>
<br><br><br>
<div id = "contentGrid">
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
</div>

<script>
    let contentContainers = document.querySelectorAll(".contentContainer");
    let currentArtIndex = 0;

    function hideAllContent() {
        contentContainers.forEach(container => {
            container.style.display = "none";
        });
    }

    function showContent(startIndex, count) {
        for (let i = startIndex; i < startIndex + count; i++) {
            if (contentContainers[i]) {
                contentContainers[i].style.display = "block";
            }
        }
    }

    let itemsPerPage = 12;
    function prevB() {
        hideAllContent();
        currentArtIndex -= itemsPerPage;
        if (currentArtIndex < 0) {
            currentArtIndex = 0;
        }
        showContent(currentArtIndex, itemsPerPage);
    }

    function nextB() {
        hideAllContent();
        currentArtIndex += itemsPerPage;
        if (currentArtIndex >= contentContainers.length) {
            currentArtIndex = contentContainers.length - itemsPerPage;
        }
        showContent(currentArtIndex, itemsPerPage);
    }

    hideAllContent();
    showContent(currentArtIndex, itemsPerPage);

    function orderForm(artName) {
        window.location.href="order.php?artName=" + artName;
        // TODO: send buttonID to order.php until basket link is clicked
    }
</script>
</body>
</html>

