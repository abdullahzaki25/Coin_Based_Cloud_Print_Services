<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "student");

$nm = $_GET["nm"];

if($nm==""){

}
else{

$sql = "SELECT * FROM  stationary WHERE stationary_name LIKE ('$nm%')";
$result = $mysqli->query($sql);

while ($row = $result->fetch_array()) {
	echo "<input type='text' value=".$row["stationary_name"].">";
	$_SESSION['f2_name'] = $row["stationary_name"];
	$_SESSION['st_id'] = $row["stationary_id"];
}
}

?>